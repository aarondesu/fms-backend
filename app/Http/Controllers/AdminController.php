<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Validator;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(["auth:sanctum", "ability:admin"]);
    }

    public function index(Request $request)
    {
        $search = $request->get('search');
        $admins = Admin::where('username', 'LIKE', '%' . $search . '%')->paginate(30);
        return response()->json(['success' => true, 'data' => [
            'list'     => $admins->items(),
            'lastPage' => $admins->lastPage(),
        ]]);
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username'    => 'required|unique:admins',
            'password'    => 'required',
            'privilleges' => 'required',
        ]);

        if (! $validator->fails()) {
            try {
                $admin              = new Admin();
                $admin->username    = $request->username;
                $admin->privilleges = $request->privilleges;
                $admin->password    = bcrypt($request->password);
                $admin->save();

                return response()->json(['success' => true, 'message' => 'OK']);

            } catch (QueryException | Exception $error) {
                if (is_a($error, QueryException::class)) {
                    return response()->json(['success' => false, 'errors' => [$error->getMessage()]]);
                }
                return response()->json(['success' => false, 'errors' => ['Internal Error']], 500);
            }
        } else {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 400);
        }
    }
    public function retrieve($id)
    {
        try {
            $admin = Admin::find($id);
            return response()->json(['success' => true, 'data' => $admin]);
        } catch (Exception $error) {
            return response()->json(['success' => false, 'message' => 'Internal server error'], 500);
        }

    }

    public function update(Request $request, $id)
    {}

    public function delete(Request $request)
    {
        $admins = Admin::findMany($request->admins);
        $admins->each(function ($admin) {
            $admin->delete();
        });

        return response()->json(['success' => true, 'message' => 'OK']);
    }
}
