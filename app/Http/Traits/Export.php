<?php

namespace App\Http\Traits;

use App\Models\Loan;
use Illuminate\Support\Facades\Storage;

trait Export  
{
    public function csv($columns = []) {    
   
        $handle = fopen(Storage::disk('local')->path('export.csv'),  'w'); 
        $columns = [
            'id',
            'loan_number',
            'terms',
            'type',
            'principal_amount',
            'total_amount',
            'balance_amount',
            'total_interest',
            'collection_amount',
            'interest',
            'status' ,
            'effective_at',
            'created_at', 
            'borrower',                  
            'payments' ,
            'due_dates',
        ];
        fputcsv($handle, $columns);
        Loan::chunk(2000, function($loans) use ($handle) {
            foreach($loans->toArray() as $collection) {

                $data = [
                    'id'
                ];

                fputcsv($handle, $collection);
            }     
        });         

        fclose($handle);       

        return Storage::disk('local')->download('export.csv');
      
    } 
}