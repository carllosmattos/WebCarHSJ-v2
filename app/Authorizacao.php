<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// use \App\solicitacao;

class Authorizacao extends Model
{
  
  protected $table = "authorizerequests";
  protected $fillable = ['driver'];
}
