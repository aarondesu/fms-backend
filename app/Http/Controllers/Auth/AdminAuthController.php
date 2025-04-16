<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AdminAuthController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth:admin')->except(['login']);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required',
        ]);

        if (! $validator->fails()) {
            if (auth()->guard('admin')->attempt(['username' => $request->username, 'password' => $request->password])) {
                $token = auth()->guard('admin')->user()->createToken('water-system', ['admin'], now()->addWeek());

                return response(['success' => true, 'data' => [
                    'admin' => auth()->guard('admin')->user(),
                    'token' => $token->plainTextToken,
                ]]);
            } else {
                return response()->json(['success' => false, 'errors' => ['Invalid Username or Password']], 401);
            }
        } else {
            return response(['success' => false, 'errors' => $validator->errors()], 400);
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json(['success' => true]);
    }
}
