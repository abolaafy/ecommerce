<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Wishlist extends Model
{
    protected $table = 'wishlists';
    protected $fillable = ['user_id', 'item_id'];

    
}
