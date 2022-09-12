<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
   
  </head>
  <body>

<style>
 .flex{
  display : flex;
} 
.flex-row {
  flex-direction:row;
}
.flex-col {
  flex-direction:column;
}
.justify-between{
  justify-content: space-between;
}

.justify-content-end{
  justify-content: flex-end;
}
.w-full {
  width:100%;
}
.block {
  display:block;
  
}
.min-w-100{
  min-width:100px;
}

.gap-4{
  gap: 1rem;
}

.mr-8 {
  margin-right : 3rem;
}

label {
  margin-bottom: .500rem;
}

.text-right {
  text-align: right;
}

.text-center {    
      text-align: center
}

#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
  margin-top: 2rem;
  margin-bottom : 1rem;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
  font-size: 14px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  background-color: #04AA6D;
  color: white;
}

.mb-1{
  margin-bottom: 2rem;
}

.mb-3{
  margin-bottom: 2rem;
}

.left {
  float :left;
}
.right {
  float: right;
}

.clearfix {
  content: "";
  clear: both;
  display: table;
  overflow: auto;
}

.w-400px{
  width: 400px;
}

.mb-2{
  margin-bottom: .5rem;
}

</style>

<div class="container mt-5">
  <h2 class="block text-center mb-1">Loan Details</h2>
  <div class="flex w-full justify-between mb-3">
    <div class="left">
        <div class="w-full mb-2">
          <label>Name:</label>  
          <label>{{ $loan->borrower->firstname . " " . $loan->borrower->lastname }}</label>
       </div>
      <div class="w-full mb-2">  
          <label>Address :</label>
          <label>{{ $loan->borrower->address }}</label>
       </div>
      <div class="w-full mb-2"> 
          <label>Phone :</label>
          <label>{{ $loan->borrower->phone }}</label>
       </div>
    </div>
   <div class="right w-400px">

     <div class="right">
      <div class="w-full mb-2">
        <label>Payemnt Terms:</label>  
        <label>{{ $loan->terms . " ". "Months"}}</label>
    </div>
    <div class="w-full mb-2">  
        <label>Payment Type :</label>
        <label>{{ucfirst($loan->type)}}</label>
     </div>
    
      <div class="w-full  mb-2">
        <label>Principal Amount :</label>  
        <label>{{ 'Php ' . number_format($loan->principal_amount, 2) }}</label>
    </div>
    <div class="w-full mb-2">  
        <label>Interest :</label>
        <label>{{$loan->interest}}%</label>
     </div>

     </div>
    </div>
  </div>

      <div class="clearfix">
  
      </div>
  
      <table  id="customers">
        <thead class="border-b bg-gray-800">
          <tr>
            <th class="text-center">#</th>
            <th class="text-center">Due Date</th>
            <th class="text-center">Amount</th>
            <th class="text-center">Paid Date</th>
            <th class="text-center">Amount Paid</th>  
            <th class="text-center">Status</th>                
          </tr>
        </thead class="border-b">
        <tbody>
         <label for="">  </label>
          @foreach ($loan->dueDates as $payment)
          
              <tr class="bg-white border-b">    
                <td class="text-center"> 
                  {{ $loop->index + 1 }}
                </td>   
                <td class="text-center">
                  {{ date('Y-m-d', strtotime($payment->due_date)) }}
                </td>
                <td class="text-center">
                  {{ 'Php ' . number_format($payment->collection_amount, 2) }}
                </td>
                <td class="text-center">
                   {{ date('Y-m-d', strtotime($payment->paid_at)) }}
                </td>         
                <td class="text-center"> 
                  {{ 'Php ' . number_format($payment->amount_paid, 2)}}
                </td>  
                <td class="text-center">
                  {{ ucfirst($payment->status)  }}
                </td>             
            </tr>
      
          @endforeach
        
     
         
                   
        </tbody>
      </table>
  
<div class="right">
  <div class="w-full mb-2">  
    <label>Total Amount :</label>
    <label>{{ 'Php ' . number_format($loan->total_amount, 2) }}%</label>
 </div>
  <div class="w-full mb-2">
      <label>Collection Amount :</label>
      <label>{{'Php ' . number_format($loan->collection_amount, 2) }}</label>
   </div> 
 
 
 <div class="w-full mb-2">
    <label>Balance:</label>  
    <label>{{ 'Php ' . number_format($loan->balance_amount,2) }}</label>
 </div>
</div>
  
  </div>

</div>
  </body>
</html>