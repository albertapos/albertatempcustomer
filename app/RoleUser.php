<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $table = 'role_user';

    public function user()
    {
    	return $this->belongsTo('pos2020\user');
    }
}
