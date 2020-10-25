<?php 

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Image;

/**
 * services like upload file and more
 */
class SettingService
{
	public function uplodaFile($file)
	{
		$user = User::find(Auth::id());
		if ($user->profile_pic) {
			\File::delete("profile_images/$user->profile_pic");
		}

		$fileName = md5(date('dmyhis'.$file->getClientOriginalName())).'.png';
		if (!is_dir(public_path()."/profile_images")) {
			mkdir(public_path()."/profile_images");
		}
		$save = public_path()."/profile_images/$fileName";

		Image::make($file)->encode('png', 85)->save($save);	

		$user->profile_pic = $fileName;
		$user->save();

		return $fileName;
	}
}
