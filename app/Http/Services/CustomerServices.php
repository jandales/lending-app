<?php 

namespace App\Http\Services;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Traits\UploadTrait;

class CustomerServices {

    use UploadTrait;

    public function getAll()
    {
        return Customer::all();
    }

    public function store(Request $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;
        $validated['email'] = $request->email; 
        $validated['avatar'] = $this->upload($request, 'avatar'); 
        return Customer::create($validated);      
    }

    public function view(Customer $customer)
    {

    }

    public function update(Request $request, Customer  $customer)
    {      
        $oldImagePath = $customer->avatar;

        if ($request->hasFile('avatar')){
            $customer->avatar = $this->upload($request, 'avatar');  
        } 

        $customer->firstname = $request->firstname;
        $customer->lastname =$request->lastname;
        $customer->email =$request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->user_id = $request->user()->id;

        if($customer->save()){
            $this->deleteImage($oldImagePath);
        }

        return $customer;
    }

    public function destroy(Customer $customer)
    {
        $this->deleteImage($customer->avatar);        
        return $customer->delete();
    }

    public function search($keyword)
    {
        return Customer::search($keyword)->get();
    }
}