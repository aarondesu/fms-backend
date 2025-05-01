<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Exception;
use Hash;
use Illuminate\Http\Request;

class AdminPasswordController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth:sanctum', 'ability:admin']);
    }

    public function reset(Request $request)
    {
        try {
            $admin           = $request->user();
            $admin->password = bcrypt('password');
            $admin->save();

            return response()->json(['success' => true, 'message' => 'OK']);
        } catch (Exception $error) {
            return response()->json(['success' => false, 'errors' => ['Unhandled Exception']], 500);
        }

    }
    public function change(Request $request)
    {
        try {
            $admin_id = $request->user()->id;
            $admin    = Admin::find($admin_id);

            if (! Hash::check($request->password, $admin->password)) {
                $admin->password = bcrypt($request->password);
                $admin->save();

                return response()->json(['success' => true, 'message' => 'OK']);
            } else {
                return response()->json(['success' => false, 'errors' => ['New password and Old password cannot be the same']], 400);
            }

        } catch (Exception $error) {
            return response()->json(['success' => false, 'errors' => ['Unhandled Exception']], 500);
        }
    }
}
