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

    public static $STATUS_APPROVED = 'approved';
    public static $STATUS_ACTIVE = 'active';
    public static $STATUS_PENDING = 'pending';
    public static $STATUS_PAID = 'paid';
    public static $STATUS_REJECT = 'rejected';
    public static $STATUS_VOID = 'void';  

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

        return $query->where('status', Self::$STATUS_ACTIVE)->latest('created_at');

    }

    public function scopeExistingLoan($query, $id)
    {      
        
        $loan = $query->where('borrower_id', $id)->where(function ($q) {

                        $q->where('status', Self::$STATUS_APPROVED)

                        ->orWhere('status', Self::$STATUS_PENDING)

                        ->orWhere('status', Self::$STATUS_ACTIVE);

                })->first();

        return $loan === null ? false : true;

    }

    public function scopeCapital($query)
    {   

        $capital = 0;

        $loans =  $query->get();

        if (is_null($loans)) return 0;

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

                    ->where('loan_number', 'LIKE', '%' . $keyword . '%')  

                    ->orWhereHas('borrower', function ($q) use ($keyword) {

                        $q->where('firstname', 'LIKE', '%' . $keyword . '%')

                         ->orWhere('lastname', 'LIKE', '%' . $keyword . '%');  

                    })  

                    ->get();

    }

}
