<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Service;
use App\Enum\EnumStatus;
use Symfony\Component\HttpFoundation\Response;

class ServiceController extends Controller
{
    public function register(Request $request)
    {
    	$this->validate($request, [
			'host' => 'required',
			'app_key' => 'required',
			'app_name' => 'required|unique:services',
			'service_key' => 'required',
			'remote_addr' => 'required'
        ]);

        try {
            DB::beginTransaction();

            Service::create([
                'host' => $request->host,
                'app_key' => $request->app_key,
                'app_name' => $request->app_name,
                'service_key' => $request->service_key,
                'remote_addr' => $request->remote_addr,
                'status' => EnumStatus::ACTIVE
            ]);

            DB::commit();
            return response([
                'status' => 'success',
                'message' => 'Service saved successfully',
            ], Response::HTTP_OK);
        } catch (\PDOException $e) {
            DB::rollBack();
            $msg = substr($e->getMessage(), 0,strpos($e->getMessage(), ' (SQL: '));
            return response([
                'status' => 'PDOException',
                'message' => $msg
            ], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            DB::rollBack();
            return response([
                'status' => 'error',
                'message' => $e->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function auth(Request $request)
    {
        $this->validate($request, [
            'app_name' => 'required',
            'token' => 'required',
            'remote_addr' => 'required'
        ]);

        $service = Service::Where('status', [EnumStatus::ACTIVE])->where('app_name', $request->app_name)->first();

        if (!empty($service->app_key) && md5($service->app_key.'.'.$service->app_name.'.'.$service->service_key) === $request->token) {
            if (!empty($service->remote_addr) && $service->remote_addr == $request->remote_addr) {
                return response(['message'=>'Authorized'], 200);
            }
            return response(['message'=>'Remote address unauthorized'], 401);
        }


        return response(['message'=>'Unauthorized'], 401);
    }
}
