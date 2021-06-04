<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{

    public function users()
    {
        return $this->belongsToMany('App\Models\User')->using('App\Models\RoleUser');
    }

    public function permissions()
    {
        return $this->belongsToMany(\App\Permission::class);
    }
}
