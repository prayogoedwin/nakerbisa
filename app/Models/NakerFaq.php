<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class NakerFaq extends Model
{
    //
    use SoftDeletes;

    protected $table = 'naker_faqs';

    protected $fillable = ['name', 'description', 'created_by', 'updated_by', 'deleted_by', 'id_deleted'];
}
