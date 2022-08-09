<?php
namespace App\Http\Reports;

interface Report {

  public function generate($start, $end, $filter = null);

}
?>