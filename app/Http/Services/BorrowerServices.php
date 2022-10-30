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
        $validated['email']   = $request->email; 
        $validated['avatar']  = $this->upload($request, 'avatar');
        $validated['status']  = $request->status;  
        
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
        $borrower->lastname  = $request->lastname;
        $borrower->email     = $request->email;
        $borrower->phone     = $request->phone;
        $borrower->address   = $request->address;
        $borrower->user_id   = $request->user()->id;
        $borrower->status    = $request->status;
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

    public function search($keyword, $active = 0)
    {
        $borrowers = Borrower::when($active != 0, function($q) use ($active) {
                        $q->where('has_active_loan', $active);
                     })
                     ->Search($keyword)
                     ->paginate($this->perpage);

        return BorrowerResource::collection($borrowers);
    }

    public function count()
    {
        return Borrower::count();
    }

    public static function updateLoanStatus($borrower_id, $status)
    {
        $borrower = Borrower::find($borrower_id);
        $borrower->has_active_loan = $status;
        $borrower->save();
    }

    
}