<?php

namespace Capmega\UserCRUD;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	/*
     * A role has many users
     */
    public function user(){
    	return $this->hasMany('App\User');
    }
}
