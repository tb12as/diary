<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function index()
    {
    	$data = User::find(Auth::id());
    	return view('settings', compact('data'));
    }
    public function save(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'min:3',
    		'password' => 'min:8|confirmed',
    	]);

    	$data = User::find(Auth::id());
    	$data->name = $request->name;
    	$data->password = bcrypt($request->password);
    	$data->save();

    	return response()->json([
    		'name' => $data->name,
    		'change_password' => ($request->password ? true : false),
    	]);
    }
}
