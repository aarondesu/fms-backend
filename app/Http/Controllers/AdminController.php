<?php
namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

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
    {}
    public function retrieve()
    {}
    public function update()
    {}
    public function delete()
    {}
}
