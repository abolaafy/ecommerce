<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
        protected $fillable = ['name' , 'permissions'];
        public $timestamps = false;

        public function getPermissionsAttribute ($permissions)
        {
            return json_decode($permissions , true);
        }
}
