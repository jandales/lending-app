<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    @vite('resources/css/app.css')
  </head>
  <body>

<style>
    .text-center {    
      text-align: center
    }
    #customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #04AA6D;
  color: white;
}
.mb-1{
  margin-bottom: 2rem;
}
.mb-3{
  margin-bottom: 2rem;
}
</style>

<div class="container mt-5">
    <h2 class="block text-center mb-1">Loan List</h2>

    <div class="block text-center mb-3">
      <label for="">{{ $start_date . " - " . $end_date }}</label>
    </div>

    <table  id="customers">
      <thead class="border-b bg-gray-800">
        <tr>
          <th>Loan Number</th>
          <th>Borrower</th>
          <th>Payment Terms</th>
          <th>Payment Type</th>
          <th>Interest</th>
          <th>Principal Amount</th>
          <th>Collection Amount</th>   
          <th>Total Amount</th>
          <th>Balance Amount</th>
          <th>Due Date</th> 
          <th>Status</th>   
          <th>Release Date</th>       
        </tr>
      </thead class="border-b">
      <tbody>
    
       @foreach ($loans as $loan)
       <tr class="bg-white border-b">       
        <td>
          {{ $loan['loan_number'] }}
        </td>
        <td>
          {{ ucfirst( $loan->borrower->firstname . " " . $loan->borrower->lastname)}}
        </td>
        <td >
          {{ $loan->terms . " ". "Months" }}
        </td>
        <td class="text-center">
          {{ ucfirst($loan->type) }}
        </td>
        <td class="text-center">
          {{ $loan->interest . '%' }}
        </td>
        <td class="text-center">
          {{  'Php ' . number_format($loan->principal_amount, 2) }}
        </td>  
        <td class="text-center">
          {{ 'Php ' . number_format($loan->collection_amount,2) }}
        </td>     
        <td class="text-center">
           {{ 'Php ' . number_format($loan->total_amount, 2) }}
        </td>
        <td class="text-center">
           {{ 'Php ' . number_format($loan->balance_amount, 2) }}
        </td>
        <td class="text-center">
          {{ $loan->due_date_at }}
       </td>
        <td class="text-center">
         {{  ucfirst($loan->status)  }}
        </td>
        <td>
          {{ $loan->updated_at->format('Y-m-d') }}
        </td>
      </tr>
       @endforeach     
                 
      </tbody>
    </table>

</div>
  </body>
</html>