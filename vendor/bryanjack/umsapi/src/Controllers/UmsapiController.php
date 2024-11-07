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

class UmsapiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('umsapi::index');
    }

    public function login(Request $request)
    {
        $resp = new \stdClass;
        if (!$this->user_login($request->user_email, $request->password)) {
            $resp->status = '99';
            $resp->message = "failed";
            $resp->data = '';
            return response()->json($resp);
        }

        if ($this->user_login($request->user_email, $request->password)) {
            // dd($this->username($request->user_email)->user_id);
            $query = User::where('user_email', $request->user_email)
            ->update(['user_status' => '2']);
            $resp->status = '00';
            $resp->message = "success";
            $resp->data = $this->username($request->user_email);
            return response()->json($resp);
        }

        
    }

    public function logout(Request $request)
    {
        $resp = new \stdClass;
        if (!$this->username($request->user_email)) {
            $resp->status = '99';
            $resp->message = "failed";
            $resp->data = '';
            return response()->json($resp);
        }
        
        if ($this->username($request->user_email)) {
            $query = User::where('user_email', $request->user_email)
            ->update(['user_status' => '1']);
            $resp->status = '00';
            $resp->message = "success";
            $resp->data = '';
            return response()->json($resp);
        }
    }

    public function user_login($username, $password)
    {
        $query = User::where([
                ['user_email', '=', $username],
                ['password', '=', sha1($password)],
            ])
            ->get();

        $user = $query->first();

        // dd($user);
        return $user;
    }

    public function user_id($user_id)
    {
        $query = User::where([
                ['user_id', '=', $user_id],
            ])
            ->get();

        $user = $query->first();

        // dd($user);
        return $user;
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

    public function user_detail(Request $request)
    {
        $query = User::where([
                ['user_id', '=', $request->user_id],
            ])
            ->get();

        $user = $query->first();

        $resp = new \stdClass;
        $resp->status = '00';
        $resp->message = "success";
        $resp->data = $user;
        return response()->json($resp);
    }

    public function data_user(Request $request)
    {
        $query = User::get();
        $count = User::get()->count();
        $login = User::where('user_status', '2')->get()->count();

        // dd($count);

        $no = 0;
        foreach($query as $user){
            $users[] = $user;
        }
        
        // dd($user);

        $resp = new \stdClass;
        $resp->status = '00';
        $resp->message = "success";
        $resp->user = $count;
        $resp->user_login = $login;
        $resp->data = $users;
        return response()->json($resp);
    }

    public function create (Request $request)
    {
        $request['password'] = sha1($request->password);
        $request['user_status'] = '1';
        $insert = User::create($request->all());
        
        $resp = new \stdClass;
        if($insert){
            $resp->status = '00';
            $resp->message = "success";
            $resp->data = $request->all();
            return response()->json($resp);
        }else{
            $resp->status = '99';
            $resp->message = "failed";
            $resp->data = '';
            return response()->json($resp);
        }

    }

    public function update (Request $request)
    {
        // dd($request->password);
        if($request->password == '') {
            $password = $this->user_id($request->user_id)->password;
        }else{
            $password = sha1($request->password);
        }
        // dd($password);
        $data = ['user_email' => $request->user_email,
        'user_fullname' => $request->user_fullname,
        'password' => $password];
        
        $update = User::where('user_id', $request->user_id)->update($data);

        $resp = new \stdClass;
        if($update){
            $resp->status = '00';
            $resp->message = "success";
            $resp->data = $request->all();
            return response()->json($resp);
        }else{
            $resp->status = '99';
            $resp->message = "failed";
            $resp->data = '';
            return response()->json($resp);
        }
        

    }

    public function hapus (Request $request)
    {
        $update = User::where('user_id', $request->user_id)->delete();

        $resp = new \stdClass;
        if($update){
            $resp->status = '00';
            $resp->message = "success";
            $resp->data = $request->all();
            return response()->json($resp);
        }else{
            $resp->status = '99';
            $resp->message = "failed";
            $resp->data = '';
            return response()->json($resp);
        }
    }

    public function menu(Request $request)
    {
        // $query = DB::connection('my_db')->table('my_table')->insert($data);
        $query = DB::table('menu')->orderBy('position', 'ASC')->get();

        $resp = new \stdClass;
        $resp->status = '00';
        $resp->message = "success";
        $resp->data = $query;
        return response()->json($resp);
    
    }

    public function update_menu(Request $request)
    {
        // dd($request->all());
        $menus = $request->menu;
        // dd(count($menus));
        // return response()->json($request->all());
        // exit();
        if (is_array($menus)) {
            if (count($menus) > 0) {
                // dd();
                // return response()->json($request->menu);
                $del_menu = DB::table('menu')->truncate();
                foreach ($menus as $key => $value) :
                    $menu[$key]['menu'] = $request->menu[$key];
                    $menu[$key]['link'] =$request->link[$key];
                    $menu[$key]['icon'] = $request->icon[$key];
                    $menu[$key]['position'] = $request->position[$key];
                endforeach;
                $input_menu = DB::table('menu')->insert($menu);
            }
        }

        $resp = new \stdClass;
        $resp->status = '00';
        $resp->message = "success";
        $resp->data = $request->all();
        return response()->json($resp);
    }

    public function update_logo(Request $request)
    {
        $query = DB::table('picture')->where('file', 'logo')->update(
            ['link' => $request->logo]
        );

        $resp = new \stdClass;
        $resp->status = '00';
        $resp->message = "success";
        $resp->data = $request->all();
        return response()->json($resp);
    }

    public function update_background(Request $request)
    {
        $query = DB::table('picture')->where('file', 'background')->update(
            ['link' => $request->background]
        );

        $resp = new \stdClass;
        $resp->status = '00';
        $resp->message = "success";
        $resp->data = $request->all();
        return response()->json($resp);
    }

    public function background(Request $request)
    {
        // $query = DB::connection('my_db')->table('my_table')->insert($data);
        $query = DB::table('picture')->where('file', 'background')->get();

        $resp = new \stdClass;
        $resp->status = '00';
        $resp->message = "success";
        $resp->data = $query;
        return response()->json($resp);
    
    }

    public function logo(Request $request)
    {
        // $query = DB::connection('my_db')->table('my_table')->insert($data);
        $query = DB::table('picture')->where('file', 'logo')->get();

        $resp = new \stdClass;
        $resp->status = '00';
        $resp->message = "success";
        $resp->data = $query;
        return response()->json($resp);
    }

    public function theme(Request $request)
    {
        // $query = DB::connection('my_db')->table('my_table')->insert($data);
        $query = DB::table('theme')->get();

        $resp = new \stdClass;
        $resp->status = '00';
        $resp->message = "success";
        $resp->data = $query;
        return response()->json($resp);
    }

    public function update_theme(Request $request)
    {
        // $query = DB::connection('my_db')->table('my_table')->insert($data);
        $query = DB::table('theme')->update(
            ['status' => 0]
        );
        $query = DB::table('theme')->where('colour', $request->theme)->update(
            ['status' => 1]
        );

        $resp = new \stdClass;
        $resp->status = '00';
        $resp->message = "success";
        $resp->data = $query;
        return response()->json($resp);
    }

    public function used_theme(Request $request)
    {
        // $query = DB::connection('my_db')->table('my_table')->insert($data);
        $query = DB::table('theme')->where('status', 1)->get();

        $resp = new \stdClass;
        $resp->status = '00';
        $resp->message = "success";
        $resp->data = $query;
        return response()->json($resp);
    }

}
