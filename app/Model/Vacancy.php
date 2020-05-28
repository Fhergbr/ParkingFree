<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Vacancy extends Model
{
    public function park()
    {
    	return $this->hasOne(Park::class);
    }
}
