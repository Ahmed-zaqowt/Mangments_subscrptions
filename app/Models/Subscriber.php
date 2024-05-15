<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model
{
    use HasFactory;
    protected $guarded = [] ;

    const SMSM = ' بانتظار الادراج   ';
    const SMSS = ' بانتظار الادراج    ';
    function sub()  {
      return $this->belongsTo(Subscriber::class , 'subscriber_id');
    }

    function user() {
          return $this->belongsTo(User::class) ; 
    }



}
