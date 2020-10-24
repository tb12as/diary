<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
  public function index(Request $request)
  {
    if ($request->ajax()) {
      $data = User::where('level', 2)->withCount('diaries')->latest()->get();
      return UserResource::collection($data);
    }

    return view('admin.user_management');
  }

  public function show($id)
  {
    return User::findOrFail($id);
  }

  public function destroy($id)
  {
    $user = User::findOrFail($id);
    $user->delete();
    return new UserResource($user);
  }

  public function toAdmin(Request $request)
  {
    $id = $request->id;
    $user = User::findOrFail($id);
    $user->level = 1;
    $user->save();
    return new UserResource($user);
  }
}
