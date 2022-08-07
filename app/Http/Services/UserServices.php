<?php 

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Traits\UploadTrait;

class UserServices
{
    use UploadTrait;

    public function update(Request $request)
    {
        $user = $request->user();  

        $user->name = $request->name;

        $user->phone = $request->phone;

        $user->address = $request->address;

        $user->save();

        return $user;
    }

    public function uploadAvatar(Request $request)
    {
        $user = $request->user();

        $oldAvatar = $user->avatar;

        $user->avatar = $this->upload($request, 'avatar');

        $user->save();

        $this->deleteImage($oldAvatar);

        return $user;

    }
}