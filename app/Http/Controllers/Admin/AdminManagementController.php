<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;

class AdminManagementController extends Controller
{
	public function index(Request $request)
	{
		if ($request->ajax()) {
			$data = User::where('level', 1)->withCount('diaries')->latest()->get();
			return UserResource::collection($data);
		}

		return view('admin.admin_management');
	}
	public function show($id)
	{
		return User::findOrFail($id);
	}
	public function store(AdminRequest $request)
	{
		$data = User::updateOrCreate(['id' => $request->admin_id], [
			'name' => $request->name,
            'email' => $request->email,
            'level' => 1,
            'password' => $request->password ? bcrypt($request->password) : User::find($request->admin_id)->password,
		]);

		return Response::json([
			'done' => true,
		], 200);
	}
	public function destroy($id)
	{
		$data = User::findOrFail($id);
		$data->delete();

		return Response::json([
			'done' => true,
		], 200);
	}
}
