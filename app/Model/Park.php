<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Park extends Model
{
	protected $table = "parks";
	protected $fillables = ['vacancy_id','cpf','timeIn','timeOut','model','board'];

	public function vacancy()
	{
		return $this->belongsTo(Vacancy::class);
	}


}
