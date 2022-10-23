<?php 

namespace App\Http\Services;

class BaseServices 
{
    public int $perpage;
 

    public function __construct()
    {
        $this->perpage = (int)config('pagination.per_page');
      
    }
}