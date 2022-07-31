<?php 

namespace App\Http\Services;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Traits\UploadTrait;
use App\Http\Resources\BorrowerResource;

class CustomerServices {

    use UploadTrait;

    public function getAll()
    {
        return BorrowerResource::collection(Customer::all());
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
        return new BorrowerResource($customer);
    }

    public function update(Request $request, Customer  $customer)
    {      
        $oldImagePath = null;

        if ($request->hasFile('avatar')){
            $oldImagePath = $customer->avatar;
            $customer->avatar = $this->upload($request, 'avatar');  
        } 

        $customer->firstname = $request->firstname;
        $customer->lastname =$request->lastname;
        $customer->email =$request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->user_id = $request->user()->id;
        $customer->save();

        if ($oldImagePath != null){
            $this->deleteImage($oldImagePath);
        }

        return new BorrowerResource($customer);
    }

    public function destroy(Customer $customer)
    {
        $this->deleteImage($customer->avatar);        
        return $customer->delete();
    }

    public function search($keyword)
    {
        return BorrowerResource::collection(Customer::search($keyword)->get());
    }
    public function count()
    {
        return Customer::count();
    }
}