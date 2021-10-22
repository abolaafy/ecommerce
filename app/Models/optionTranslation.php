<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class optionTranslation extends Model
{
    public $timestamps = false ;
    protected $fillable =['name' ,'locale'];
}
