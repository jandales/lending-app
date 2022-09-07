<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
  </head>
  <body>

<div class="container mt-5">
    <h2 class="text-center mb-3">Laravel HTML to PDF Example</h2>
  
    <table class="table table-bordered mb-5">
        <thead>
            <tr class="table-danger">
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Email</th>
                <th scope="col">Address</th>
                <th scope="col">Phone</th>
           
            </tr>
        </thead>
        <tbody>
            @foreach($borrowers as $borrower)
            <tr>
                <th scope="row">{{ $borrower->id }}</th>
                <td>{{ $borrower->firstname . " " . $borrower->lastname }}</td>
                <td>{{ $borrower->email }}</td>
                <td>{{ $borrower->address }}</td>
                <td>{{ $borrower->phone }}</td>             
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
  </body>
</html>