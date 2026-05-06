<?php

namespace App\Controllers;

class Clogin extends BaseController
{
    public function login(): string
    {
        return view('admin/v_login');
    }
}

