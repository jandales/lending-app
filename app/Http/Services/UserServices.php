<?php 

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Traits\UploadTrait;
use Illuminate\Support\Facades\Hash;

class UserServices
{
    use UploadTrait;

    public function getUsers()
    {
        return User::where('role' ,'>', 0)->get()          

            ->map(function($user) {

                return [

                    'id' => $user->id,
        
                    'name' => $user->name,
        
                    'email' => $user->email,
        
                    'avatar' => $user->avatar, 
                    
                    'phone' => $user->phone,
        
                    'role' => $user->roleInWord(),  
                            
                ];

            });

          
    }



    public function updateUser(User $user, Request $request)
    {
        
        $password = $request->password;

        if (!is_null($password) ) {
            
            $user->password = Hash::make($password);

        }

        $user->name = $request->name;

        $user->phone = $request->phone;        

        $user->address = $request->address;        

        $user->save();

        return $user;

    }


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
    

    public function store(Request $request)
    {
        $validated = $request->validated();

        $validated['address'] = $request->address;

        $validated['phone'] = $request->phone;

        $validated['password'] = Hash::make($validated['password']);

        return User::create($validated);
        
    }

   
}