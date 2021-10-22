<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class users_verification_code extends Model
{
    protected $fillable = [  'code','user_id'];
    protected $table = 'users_verification_code';

    public function users ()
    {
        return $this -> belongsTo (App\User::class , 'user_id' , 'id');
    }
}
