<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RemoteAddress;
use App\Enum\EnumStatus;
use Symfony\Component\HttpFoundation\Response;

class RemoteAddressController extends Controller
{
    public function register(Request $request)
    {
    	$this->validate($request, [
			'remote_address' => 'required|ip'
        ]);


        try {
            DB::beginTransaction();

            $ip = explode('.', $request->remote_address);
            Service::create([
                'part1' => $ip[0];
                'part2' => $ip[1];
                'part3' => $ip[2];
                'part4' => $ip[3];
                'status' => EnumStatus::ACTIVE
            ]);

            DB::commit();
            return response([
                'status' => 'success',
                'message' => 'Remote Address saved successfully',
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
}
