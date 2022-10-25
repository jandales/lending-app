<?php 

namespace App\Http\Services;

use App\Models\User;
use App\Helpers\Password;
use Illuminate\Http\Request;
use App\Jobs\ProccessSendPassword;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;

class UserServices extends BaseServices
{  

    public function getUsers($filter = null, $sort = null, $order = null)
    {      

        $users = User::where('role' ,'>', 0)
        
            ->when(!is_null($filter), function ($query) use ($filter) {
                if ($filter != 0) {
                    $query->where('role', $filter); 
                }                              
            })

            ->when(!is_null($sort) && !is_null($order), function ($query) use ($sort, $order) {               
                 $query->orderBy($sort, $order);                
            })

            ->orderBy('created_at','desc')
            ->paginate($this->perpage);

        return UserResource::collection($users);
                       
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
        $password = Password::generate();
        $validated = $request->validated();
        $validated['address'] = $request->address;
        $validated['phone'] = $request->phone;
        $validated['password'] = Password::make($password);
       
        $user =  User::create($validated);  
        
        dispatch(new ProccessSendPassword($user->email, $password));

        return $user;
    }

    public function search($keyword)
    {     
        $users = User::Search($keyword)
                ->orderBy('created_at','desc')
                ->paginate($this->perpage);              

        return UserResource::collection($users);
    }

   
}