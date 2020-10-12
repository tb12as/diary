<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagement extends Controller
{
    public function index()
    {
    	$data = User::where('level', 2)->latest()->get();
    	return UserResource::collection($data);
    }

    public function detail($id)
    {
    	$user = User::findOrFail($id);
    	return $user;
    }

    public function deleteUser($id)
    {
    	$user = User::findOrFail($id);
    	$user->delete();
    	return new UserResource($user);
    }
}
