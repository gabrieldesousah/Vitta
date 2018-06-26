<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orcamento extends Model
{
    protected $fillable = ['user_id', 'exame', 'nome', 'orcamento'];
    
    public function exames()
    {
        return $this->hasMany('App\Comment');
    }
}
