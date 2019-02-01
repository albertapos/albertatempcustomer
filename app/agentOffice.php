<?php

namespace pos2020;

use Illuminate\Database\Eloquent\Model;
use Validator;

class agentOffice extends Model
{
    protected $table = 'agent_office';

     public static function Validate($data) {
        $rules = array(
            'title' => 'required|min:3|max:255'
        );
        $messages = [
            'title.required' => 'Agent Office Name is required.'
          ];
        return Validator::make($data, $rules ,$messages);
    }
}
