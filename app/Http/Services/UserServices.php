<?php 

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserServices
{


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



    public function update(User $user, Request $request)
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
   
    

    public function store(Request $request)
    {
        $validated = $request->validated();

        $validated['address'] = $request->address;

        $validated['phone'] = $request->phone;

        $validated['password'] = Hash::make($validated['password']);

        return User::create($validated);
        
    }

   
}