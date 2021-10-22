<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeTranslation extends Model
{
			protected $fillable = ['name', 'locale','attribute_id'];
			  public $timestamps = false;
}
