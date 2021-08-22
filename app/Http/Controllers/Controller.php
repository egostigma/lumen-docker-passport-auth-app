<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function __construct()
    {
        $this->status = 'success'; 
        $this->code = 200; 
    }

    public function setResponse($data)
    {
        return response(array_merge($data, ['status' => $this->status]), $this->code);
    }
}
