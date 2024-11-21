<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NakerGaleri extends Model
{
    //
    use SoftDeletes;

    protected $table = 'naker_galeri';

    protected $fillable = [
        'name',
        'path_file',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
