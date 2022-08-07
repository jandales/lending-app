<?php 

namespace App\Http\Services;

use App\Models\Borrower;
use Illuminate\Http\Request;
use App\Http\Traits\UploadTrait;
use App\Http\Resources\BorrowerResource;

class BorrowerServices {

    use UploadTrait;

    public function getAll()
    {
        return BorrowerResource::collection(Borrower::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;
        $validated['email'] = $request->email; 
        $validated['avatar'] = $this->upload($request, 'avatar'); 
        return Borrower::create($validated);      
    }



    public function update(Request $request, Borrower  $borrower)
    {      
        $oldImagePath = null;

        if ($request->hasFile('avatar')){
            $oldImagePath = $borrower->avatar;
            $borrower->avatar = $this->upload($request, 'avatar');  
        } 

        $borrower->firstname = $request->firstname;
        $borrower->lastname =$request->lastname;
        $borrower->email =$request->email;
        $borrower->phone = $request->phone;
        $borrower->address = $request->address;
        $borrower->user_id = $request->user()->id;
        $borrower->save();

        if ($oldImagePath != null){
            $this->deleteImage($oldImagePath);
        }

        return new BorrowerResource($borrower);
    }

    public function destroy(Borrower $borrower)
    {
        $this->deleteImage($borrower->avatar);        
        return $borrower->delete();
    }

    public function search($keyword)
    {
        return BorrowerResource::collection(Borrower::search($keyword)->get());
    }

    public function count()
    {
        return Borrower::count();
    }

    
}