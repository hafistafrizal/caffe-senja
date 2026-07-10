<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Base Controller untuk aplikasi Cafe Senja.
 * Menyediakan fitur dasar autentikasi dan validasi untuk semua controller lainnya.
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
