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

.mb-3{
  margin-bottom: 2rem;
}
</style>

<div class="container mt-5">
    <h2 class="block text-center mb-3">Borrower List</h2>

    <table  id="customers">
      <thead class="border-b bg-gray-800">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Name</th>
          <th scope="col">Email</th>
          <th scope="col">Address</th>
          <th scope="col">Phone</th>
          <th>Number of Loan</th>
          <th>Total Loan</th>          
        </tr>
      </thead class="border-b">
      <tbody>
       @foreach ($borrowers as $borrower)
       <tr class="bg-white border-b">
        <td class="text-center">{{ $loop->index + 1 }}</td>
        <td >
          {{ $borrower['name'] }}
        </td>
        <td>
          {{ $borrower['email'] }}
        </td>
        <td >
          {{ $borrower['address'] }}
        </td>
        <td>
          {{ $borrower['phone'] }}
        </td>
        <td class="text-center">
          {{ $borrower['loans_count'] }}
        </td>
        <td class="text-center">
          {{ 'Php ' . number_format($borrower['loans_sum_total_amount'],2) }}
        </td>       
      </tr>
       @endforeach
      
          
      </tbody>
    </table>

</div>
  </body>
</html>