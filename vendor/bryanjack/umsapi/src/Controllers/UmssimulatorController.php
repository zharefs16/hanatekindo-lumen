<?php

namespace Bryanjack\Umsapi\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

class UmssimulatorController extends Controller
{
    public function login(Request $request)
    {
        $resp = new \stdClass;
        // dd($request->user_email);
        if (!$this->username($request->user_email)) {
            $resp->status = '99';
            $resp->message = "failed";
            $resp->attribute = '';
            return response()->json($resp);
        }

        if ($this->username($request->user_email)) {
            $query = User::where('user_email', $request->user_email)
            ->update(['user_status' => '2']);
            $resp->status = '00';
            $resp->message = "success";
            $resp->attribute = '';
            return response()->json($resp);
        }

        
    }

    public function logout(Request $request)
    {
        $resp = new \stdClass;
        if (!$this->username($request->user_id)) {
            $resp->status = '99';
            $resp->message = "failed";
            $resp->attribute = '';
            return response()->json($resp);
        }
        
        if ($this->username($request->user_id)) {
            $query = User::where('user_email', $request->user_email)
            ->update(['user_status' => '1']);
            $resp->status = '00';
            $resp->message = "success";
            $resp->attribute = '';
            return response()->json($resp);
        }
    }

    public function username($username)
    {
        $query = User::where([
                ['user_email', '=', $username],
            ])
            ->get();

        $user = $query->first();

        // dd($user);
        return $user;
    }

}