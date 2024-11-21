<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NakerInfografis extends Model
{
    //
    use SoftDeletes;

    protected $table = 'naker_infografis';

    protected $fillable = [
        'name',
        'path_file',
        'status',
        'created_by',
        'updated_by',
        'deleted_by',
    ];
}
