<?php 

namespace App\Http\Contracts;

interface ExportContract {

    public function csv($columns = [], $data);
    public function format($model);
    public function columns();

}
      