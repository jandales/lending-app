<?php 

namespace App\Http\Services;

use App\Models\Borrower;
use Illuminate\Http\Request;
use App\Http\Traits\UploadTrait;
use App\Http\Resources\BorrowerResource;


class BorrowerServices extends BaseServices  {

    use UploadTrait;   

    public function getAll($filter = null, $sort = null, $order = null)
    {  

        $borrowers = Borrower::
            when($filter != null, function($query) use($filter) { 
                if ( $filter != 'all') {
                    $query->where('status', $filter);
                }           
                
            })
            ->when($sort != null, function($query) use($sort, $order) {
                if ($sort == 'date') {
                    $sort = 'created_at';
                }
                if ($sort == 'name') {
                    $sort = 'lastname';
                }
                $query->orderBy($sort, $order);
            }) 
            ->orderBy('created_at', 'desc')
            ->paginate($this->perpage);


        return BorrowerResource::collection($borrowers);
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
        
        if (! is_null($oldImagePath) ) {
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
        $borrowers = Borrower::search($keyword)->paginate($this->perpage);
        return BorrowerResource::collection($borrowers);
    }

    public function count()
    {
        return Borrower::count();
    }

    
}