<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class sorteo extends Model
{
    protected $table = 'sorteos';
	protected $guarded = ['id'];

	public function cartones()
    {
        return $this->hasMany('App\cartones')->where('tipo','normal');
    }

    public function series()
    {
        return $this->hasMany('App\cartones')->where('tipo','serie');
    }
}
