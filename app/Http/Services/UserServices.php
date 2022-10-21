<?php 

namespace App\Http\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserServices
{
    private int $perpage = 5;

    public function getUsers($filter = null)
    {      
        $users = User::where('role' ,'>', 0);       

        if ($filter != null) {
            $users->where('role', $filter);
        }

        return $users
                ->orderBy('created_at','desc')
                ->paginate($this->perpage)
                ->through(function($user) {                    
                    return $this->format($user);
                 });          
    }

    public function format($user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'phone' => $user->phone,
            'role' => $user->roleInWord(), 
            'created_at' => $user->created_at->format('Y-m-d'),
        ];
    }

  

    public function update(User $user, Request $request)
    {
        if (! is_null($password) ) {            
            $user->password = Hash::make($request->password);
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

    public function search($keyword)
    {     
        return User::Search($keyword)
                ->orderBy('created_at','desc')
                ->paginate($this->perpage)
                ->through(function($user) {
                    return $this->format($user);
                });
    }

   
}