<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Product;
use Illuminate\Database\Seeder;

class protuctSeed extends Seeder
{
	public function run ()
	{
		factory (App\Models\Product::class , 17 )- > create();
	}
}

