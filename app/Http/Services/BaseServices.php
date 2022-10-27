<?php 

namespace App\Http\Services;

class BaseServices 
{
    public ?int $perpage = null;

    public function __construct()
    {
        $this->perpage = (int)config('pagination.per_page');
      
    }
}