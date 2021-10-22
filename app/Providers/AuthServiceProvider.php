<?php

namespace App\Providers;

use App\Models\Admin;
use App\Models\Rule;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        foreach (config('global.permissions') as $value => $kay  )
        {
             Gate::define($value, function () use ($value)
            {
                $permissions =  Rule::where('id' , auth('admin')->user()->rule_id) ->get('permissions')[0];
                if (in_array($value ,$permissions->permissions ))
                    return true;
                return  false;
             });
         }
        foreach (config('global.permissions') as $index => $value)
        {
        //    Gate::define($index  , function ($auth) use ($index)

             //   return $auth ->hasAbility($index);
         //   });
        }
    }
}
