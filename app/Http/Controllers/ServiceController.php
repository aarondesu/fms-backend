<?php
namespace App\Http\Controllers;

use App\Models\Service;
use Exception;
use Illuminate\Http\Request;
use Validator;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum')->except('retrieve');
    }
    public function index()
    {
        try {
            $services = Service::all();

            return response()->json(['success' => true, 'data' => $services]);
        } catch (Exception $error) {
            return $this->throwUnhandledErrorResponse();
        }
    }
    public function create(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'name'      => 'required',
                'unit_type' => 'required',
                'rate'      => 'required',
            ]);

            if (! $validate->fails()) {
                $service            = new Service();
                $service->name      = $request->name;
                $service->unit_type = $request->unit_type;
                $service->rate      = $request->rate;

                $service->save();

                return response()->json(['succes' => true, 'message' => 'OK']);
            } else {
                return response()->json(['success' => false, 'errors' => $validate->errors()], 400);
            }

        } catch (Exception $error) {
            return $this->throwUnhandledErrorResponse();
        }
    }
    public function retrieve($id)
    {
        try {
            $service = Service::find($id);
            if ($service && $service->exists()) {
                return response()->json(['success' => true, 'data' => $service]);
            } else {
                return response()->json(['success' => false, 'errors' => ['Serivce does not exist.']], 400);
            }

        } catch (Exception $error) {
            return $this->throwUnhandledErrorResponse();
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $service = Service::find($id);
            if ($service && $service->exists()) {
                $service->name      = $request->name;
                $service->unit_type = $request->unit_type;
                $service->rate      = $request->rate;

                $service->save();

                return response()->json(['success' => true, 'message' => 'OK']);
            } else {
                return response()->json(['success' => false, 'errors' => ['Serivce does not exist.']], 400);
            }

        } catch (Exception $error) {
            return $this->throwUnhandledErrorResponse();
        }
    }
    public function delete(Request $request, $id)
    {
        try {
            $service = Service::find($id);
            if ($service && $service->exists()) {
                $service->delete();

                return response()->json(['success' => true, 'message' => 'OK']);
            } else {
                return response()->json(['success' => false, 'errors' => ['Serivce does not exist.']], 400);
            }

        } catch (Exception $error) {
            return $this->throwUnhandledErrorResponse();
        }
    }
}
