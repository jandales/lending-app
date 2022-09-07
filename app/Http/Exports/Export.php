<?php

namespace App\Http\Exports;

use App\Http\Contracts\ExportContract;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;


class Export implements ExportContract
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

    public function format($model) 
    {

    }

    public  function columns()
    {

    }
}
