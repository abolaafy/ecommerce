<?php

use Illuminate\Database\Seeder;

class userSeeader extends seeder
{
	public function run ()
	{
		factory(App\User::class , 17 ) -> create ();
	}
}