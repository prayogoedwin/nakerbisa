<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NakerPencariKeahlianKeterampilan extends Model
{
    //
     //
     use SoftDeletes;

     protected $table = 'naker_pencari_keahlian_keterampilan';
 
     protected $fillable = [
         'user_id',
         'keahlian',
     ];
}
