<?php

namespace App\Http\Traits;

use Carbon\Carbon;
use App\Models\Loan;
use Illuminate\Support\Facades\Storage;

trait Export  
{
    public function csv($columns = [], $data) {    
   
        $handle = fopen(Storage::disk('local')->path('export.csv'),  'w');  

        fputcsv($handle, $columns);

        foreach($data as $item)
        {           
        
            fputcsv($handle, $item);
        }   
   
        fclose($handle);       

        return Storage::disk('local')->download('export.csv');
      
    } 
}