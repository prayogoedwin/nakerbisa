<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NakerBerita extends Model
{
    //
    use SoftDeletes;

    protected $table = 'naker_berita';

    protected $fillable = [
        'name',         
        'cover',        
        'description',  
        'like_count',   
        'shared_count', 
        'status',       
        'created_by',   
        'updated_by',   
        'deleted_by',  
    ];
}
