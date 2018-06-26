<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exames extends Model
{
    protected $fillable = ['local', 'categoria', 'nome', 'preco_final', 'preco_vitta', 'preco_parceiro', 'obs'];
    
    public function orcamento()
    {
        return $this->belongsTo('App\Orcamento');
    }
}
