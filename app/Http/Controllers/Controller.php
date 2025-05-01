<?php
namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

abstract class Controller extends BaseController
{
    public function throwUnhandledErrorResponse()
    {
        return response()->json(['success' => false, 'errors' => ['Uhandled Exceptiopn']], 500);
    }
}
