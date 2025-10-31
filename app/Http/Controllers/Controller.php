<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController; // Importamos la clase base

// La clase Controller ahora extiende BaseController
abstract class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
