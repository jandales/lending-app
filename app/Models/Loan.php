<?php

namespace App\Models;


use App\Models\PaymentDueDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_number',
        'borrower_id', 
        'terms',
        'type',
        'collection_amount',       
        'total_interest', 
        'principal_amount',
        'interest',
        'effective_at',
        'total_amount',
        'balance_amount',
        'user_id',
        'status',
    ];

    public static $APPROVED = 'approved';
    public static $ACTIVE = 'active';
    public static $PENDING = 'pending';
    public static $PAID = 'paid';
    public static $REJECT = 'rejected';
    public static $VOID = 'void';  

    public function borrower()
    {

        return $this->belongsTo(Borrower::class);

    }

    public function user()
    {

        return $this->belongsTo(User::class);

    }

    public function payments()
    {

        return $this->hasMany(Payment::class);

    }

    public function loanType()
    {

        return $this->belongsTo(LoanType::class);

    }

    public function dueDates()
    {

        return $this->hasMany(PaymentDueDate::class);

    }

    public function scopeActive($query)
    {

        return $query->where('status', Self::$ACTIVE)->latest('created_at');

    }

    public function scopeExistingLoan($query, $id)
    {      
        $loan = $query->where('borrower_id', $id)->where(function ($q) {
                        $q->where('status', Self::$APPROVED)
                        ->orWhere('status', Self::$PENDING)
                        ->orWhere('status', Self::$ACTIVE);
                })->first();

        return $loan === null ? false : true;

    }

    public function scopeCapital($query)
    {   

        $capital = 0;
        $loans =  $query->get();
        if (is_null($loans) ) return 0;
        forEach ($loans as $loan) {
            $capital += $loan->principal_amount;
        }
        return $capital;       
        
    }

    public function scopeRevenue($query)
    {  

        $capital = 0; 
        $interest = 0;   
        $loans =  $query->get();

        if (is_null($loans)) return 0;

        forEach ($loans as $loan) {
            $interest += $loan->interest;
            $capital += $loan->principal_amount;
        }
        $total = $capital + ($capital * ($interest / 100));

        return $total;        
        
    }

    public function scopeSearch($query, $keyword)
    {    
        
       return $query->with('borrower')                    
                    ->Where('loan_number', 'LIKE', '%' . $keyword . '%')                   
                    ->orWhereHas('borrower', function ($q) use ($keyword) {
                        $q->where('firstname', 'LIKE', '%' . $keyword . '%')
                          ->orWhere('lastname', 'LIKE', '%' . $keyword . '%');  
                    });
                  

    }

}
