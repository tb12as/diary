<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\SaveProfilePictureReequest;
use App\Http\Requests\SettingSaveRequest;
use App\Models\User;
use App\Services\SettingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class SettingController extends Controller
{
    public function index()
    {
    	$data = User::find(Auth::id());
    	return view('settings', compact('data'));
    }
    public function save(SettingSaveRequest $request)
    {
    	$data = User::find(Auth::id());
    	$data->name = $request->name;
    	$data->password = bcrypt($request->password);
    	$data->save();

    	return response()->json([
    		'name' => $data->name,
    		'change_password' => ($request->password ? true : false),
    	]);
    }

    public function saveProfilePic(SaveProfilePictureReequest $request)
    {
        if ($request->hasFile('profile_img')) {
            $fileName = (new SettingService())->uplodaFile($request->file('profile_img'));

            return response()->json([
                'message' => true,
                'fileName' => $fileName,
            ], 200);
        }
    }

    public function deleteProfilePic()
    {
        $user = User::find(Auth::id());
        if ($user->profile_pic) {
            \File::delete("profile_images/$user->profile_pic");
        }
        $user->profile_pic = null;
        $user->save();

        return response()->json([
            'message' => true,
        ], 200);
    }
}
