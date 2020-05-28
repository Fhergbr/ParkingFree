<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Post;
use App\Model\Park;
use App\Model\Price;
use App\Model\Vacancy;
use App\Model\History;

class HomeController extends Controller
{
    private $parking;
    private $vacancies;
    private $price;
    private $history;

    public function __construct(Park $parking,Vacancy $vacancies, Price $price,History $history)
    {
        $this->parking = $parking;
        $this->vacancies = $vacancies;
        $this->price = $price;
        $this->history = $history;
    }

    public function index()
    {
        $parkOrders = $this->parking->get()->last();
        $parkOrders?$parkOrder = $parkOrders->id + 1:$parkOrder = 1;
        
        $price = $this->price->first();
        !$price? $price = 0: $price = $price->price;


        $vacancyFree = $this->vacancies->where('status','=','livre')->count();

        $vacancies = $this->vacancies->all();
        $vacanciesLast = $vacancies->count();

        $vacancy = new Vacancy();
        $vacanciesLast>0?$vacancy->order=$vacanciesLast+1:$vacancy->order=1;
        $order = $vacancy->order;
        return view('Home',compact('order','vacancies','parkOrder','vacancyFree','price'));	
    }

    public function addPark(Request $request)
    {
    	$dataForm = $request->all();
        $vacancy = $this->vacancies->where('order','=',$dataForm['vacancy_id'])->first();

        $park = new Park();        
        $park->vacancy_id = $vacancy->id; 
        $park->cpf = $dataForm['cpf']; 
        $park->timeIn = date('H:i:s') ;
        $park->model = $dataForm['model']; 
        $park->board = $dataForm['board']; 

        $insert = $park->save();

        $insert?$vacancy->status="ocupado":"";
        $vacancy->save();
    }
    public function addVacancy(Request $request)
    {
        $data = $request->all();
        $vacancy = new Vacancy();
        $vacancy->order = $data['order'];
        $insert = $vacancy->save();
        // return view('Home');
    }


    public function control()
    {
        $price = $this->price->first();
        $vacancies = $this->vacancies->where('status','ocupado')->get();
        $vacancyLast = $this->vacancies->count();
        $vacancy = new Vacancy();
        $vacancyLast > 0 ? $vacancy->order = $vacancyLast + 1 : $vacancy->order = 1;
        $order = $vacancy->order;


        foreach($vacancies as $v)
        {
            $date = date('Y-m-d H:i:s');
            $create = strtotime($v->park->created_at);
            $now = strtotime($date);

            $difference = abs($now - $create);
            $day = 0;
            $rest = 0;

            // while($difference >= 86400) {
            //     $rest = $difference % 86400;
            //     $difference = $rest;
            //     $day++;
            // }

            $priceTotal = $price->price / 3600;
            if($day > 0)
            {
                $v->park->timeOut = number_format($difference * $priceTotal, 2) + ($price->price * 24);

            }
            else{
                $v->park->timeOut = number_format($difference * $priceTotal, 2);
            }
            $v->timeOut = $difference;
            $v->park->cpf == 0 ? $v->park->cpf = "--" : $v->park->cpf;

            // transforma segundos em horas
            // gmdate("H:i:s", $vacancy->timeOut)

        }

        return view('control.control',compact('vacancies','order','vacancyLast','price'));
        // $parking = $this->parking->where()
    }
    public function loadOutput($board)
    {
        $price = $this->price->first();
        $result  = array();
        $park = $this->parking->where('board','=',$board)->first();

        if($park)
        {

            $date = date('Y-m-d H:i:s');
            $create = strtotime($park->created_at);
            $now = strtotime($date);

            $difference = abs($now - $create);
            $convertDay = $difference / 86400;
            $rest = $difference % 86400;
            
            $day = intval($convertDay);
            $explodeDay = explode('.', $day);

            $priceTotal = $price->price / 3600;
            $park->timeOut = number_format($difference * $priceTotal, 2);
            $result = [$park->vacancy->order,$park->board,$park->cpf,$park->model,$park->timeIn,$park->timeOut,
                date("H:i:s"),gmdate("H:i:s", $difference),$day,$park->id];
                $park = $result;
            }
            else
                $park = 1;

            return $park;
        }
        public function priceForHour(Request $request)
        {
            $data = $request->all();
            $price = $this->price->find(1);
            $price->price = $data['price'];
            $save = $price->save();
            return redirect()->route('home');
        }
        public function edit(Request $request)
        {
            $dataForm = $request->all();
            $post = Post::find($id);
            $post['dsPost'] = $dataForm['dsPost'];
            $post['title'] = $dataForm['title'];
            $update = $post->save();
        }
        public function delete($id)
        {
            $post = Post::find($id);
            $delete = $post->delete();
        }

        public function Imprimir(Request $req)
        {
            $id = $req['id'];

            $park = $this->parking->where('board',$id)->first();

            $file = 'Temp/imprimir.txt';


            if($park->cpf == 0):

                $price = $this->price->first();

                $date = date('Y-m-d H:i:s');
                $create = strtotime($park->created_at);
                $now = strtotime($date);

                $difference = abs($now - $create);
                $convertDay = $difference / 86400;
                $rest = $difference % 86400;

                $day = intval($convertDay);
                $explodeDay = explode('.', $day);

                $priceTotal = $price->price / 3600;
                $park->timeOut = number_format($difference * $priceTotal, 2);
                
                //fim price


                $history = new History();
                $history->vacancy = $park->vacancy->order;

                $history->cpf = $park->cpf;
                $history->values = $park->timeOut;
                $history->save();


                $file = 'Temp/imprimir.txt';
                $header = "                             ".
                date("d-m-Y")."\n"
                ."----------------------------------------"."\n"           
                ."ParkingFree"."\n".
                "----------------------------------------"."\n";           
                $txt = "Código do Cliente: ".$park->id."\n".
                "Vaga N°: ".$park->vacancy_id ."\n".
                "CPF: ".$park->cpf . "\n".
                "Entrada: ". $park->timeIn."\n".
                "Saída: ". date("H:i:s")."\n".
                "Veículo: ". $park->model."\n".
                "Placa: ". $park->board."\n";

                $footer = "\n\n\n\n\n\n\n----------------------------------------"."\n".
                "Total a Pagar: R$".$park->timeOut;

                $date = date('d-m-Y');


            // cria o arquivo
                $_file = fopen($file,"w");
                fwrite($_file,$header);
                fwrite($_file,$txt);
                fwrite($_file,$footer);
                fclose($_file);

                return response()->download($file);

            // Lê o arquivo para download
                readfile($file);
            endif;                

            return redirect()->back();
        }

    }
