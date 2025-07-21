<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

function isRoles()
{
    $data = DB::table('model_has_roles')->where('model_id', Auth::user()->id)->first();

    return $data->role_id;
}
