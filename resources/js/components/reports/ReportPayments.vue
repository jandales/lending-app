<template>
  <div class="w-full bg-white">
      <div class="flex flex-col  p-4">
           <h1 class="block tracking-wider text-lg mb-6 ">Payments Report</h1>  
      
  
      
     <div class="flex w-full gap-4">

     

         <div class="flex items-center w-full">

                <label for="exampleInputPassword1" class="form-label block min-w-[100px] text-gray-700">Start Date </label>
                <input type="date" name="start-date" v-model ="form.start_date" />
                <!-- <small class="text-alert-danger" v-for="error in errors.loan_type_id">{{ error }}</small> -->
        </div>


         <div class="flex items-center  w-full">

                <label for="exampleInputPassword1" class="form-label block min-w-[100px]  text-gray-700">End Date </label>
                <input type="date" name="end-date" v-model ="form.end_date" />
                <!-- <small class="text-alert-danger" v-for="error in errors.loan_type_id">{{ error }}</small> -->
         </div>

         <button @click="submit" class="btn-primary">Submit</button>


     </div>
    
  </div>
 
  </div>

  <div v-if="payments.length > 0" class="mt-4 border border-l-0 border-r-0 bg-white">
  <div class="flex flex-col">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="inline-block min-w-full sm:px-6 lg:px-8">       
        <div class="overflow-hidden">      
          <table class="min-w-full">
            <thead class="bg-white border-b">
              <tr>  
                    
                <th scope="col">
                  Loan Number
                </th>

                <th scope="col">
                    Borrower
                </th>
                <th scope="col">
                  Due Date
                </th>
                 <th scope="col">
                  Amount
                </th>
                <th scope="col">
                  Paid At
                </th>     
              </tr>
            </thead>
            <tbody>  
           
              <tr v-if="payments.length > 0" v-for="payment in payments" class="bg-white border-b transition duration-300 ease-in-out last:border-b-0 hover:bg-gray-100"> 
                <td class=" text-sm  font-light px-6 py-4 whitespace-nowrap">
                  {{ payment.loan.loan_number }}
                </td>       
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">    
                  {{ payment.borrower }}  
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ payment.due_date  }}
                </td>  
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ payment.amount }}
                </td>  
                  <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ payment.paid_at }}
                </td>  
              </tr>
              <tr v-else>
                <td colspan="8" class="text-xl text-center text-gray-900 font-light px-6 py-4 whitespace-nowrap">No Record Found</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

</div>
 
</template>
<script setup>
 

  import { reactive, computed } from 'vue';
  import useReport from '../../composable/report';
  import useFormater from '../../composable/helper/formater'

  const { getPaymentReports, paymentReports } = useReport();

  const { moneyFormatter } = useFormater();  

  const form = reactive({

    start_date : null,

    end_date : null,

    filter : null,   

  })

  const submit = async () => {   

    await getPaymentReports({...form});

  }

  const payments = computed(() => {
     return  paymentReports.value.map(payment=> {
            payment.amount = moneyFormatter(payment.amount);
            return payment;
      })
  });


</script>