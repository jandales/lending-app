<template>
  <div class="w-full bg-white">
      <div class="flex flex-col  p-4">
      <h1 class="block tracking-wider text-lg mb-6 ">Loans Reports</h1> 
      
  
      
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

  <div  class="mt-4 border border-l-0 border-r-0 bg-white">
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
                  Terms
                </th>
                 <th scope="col">
                   Principal Amount
                </th>
                <th scope="col">
                   Interest
                </th>               
                <th scope="col">
                  Collection Amount
                </th>
                <th scope="col" >
                  Total Amount 
                </th>
                <th scope="col" >
                  Balance
                </th>
                <th scope="col" >
                  Status
                </th>
                <th scope="col">
                
                </th>
              </tr>
            </thead>
            <tbody>  
           
              <tr v-if="loans.length > 0" v-for="loan in loans" class="bg-white border-b transition duration-300 ease-in-out last:border-b-0 hover:bg-gray-100"> 
                <td class="text-sky-500 text-sm  font-light px-6 py-4 whitespace-nowrap">
                     {{ loan.loan_number }}
                </td>       
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">    
                 {{ loan.borrower.name}}  
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                     {{ loan.terms  }}
                </td>  
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ loan.principal_amount }}
                </td>  
                  <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ loan.interest }}
                </td>    
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ loan.total_amount }}
                </td>  
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ loan.collection_amount }}
                </td>           
                       
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ loan.balance_amount }}
                </td> 
                <td class="text-gray-900 font-light text-center  whitespace-nowrap">
                  <span v-if="loan.status == 'paid'" class="bg-green-500 text-xs px-2 py-1 rounded-md text-white capitalize">
                     {{ loan.status }}
                  </span>
                   <span v-else-if="loan.status == 'void'"  class="bg-rose-500 text-xs px-2 py-1 rounded-md text-white capitalize">
                     {{ loan.status }}
                  </span>
                  <span v-else-if="loan.status == 'rejected'"  class="bg-rose-500 text-xs px-2 py-1 rounded-md text-white capitalize">
                     {{ loan.status }}
                  </span>
                   <span v-else class="bg-blue-500 text-xs px-2 py-1 rounded-md text-white capitalize">
                     {{ loan.status }}
                  </span>                 
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
  import BaseAvatar from '../base/BaseAvatar.vue'  

  import { reactive, computed } from 'vue';
  import useReport from '../../composable/report';
  import useFormater from '../../composable/helper/formater'

  const { getLoanReports, loanReports } = useReport();

  const { moneyFormatter } = useFormater();  

  const form = reactive({

    start_date : null,

    end_date : null,

    filter : null,   

  })

  const submit = async () => {   

    await getLoanReports({...form});

  }

  const loans = computed(() => {
     return  loanReports.value.map(loan => {
            loan.terms = `${loan.terms} Months`;
            loan.principal_amount = moneyFormatter(loan.principal_amount);
            loan.collection_amount = moneyFormatter(loan.collection_amount);
            loan.total_amount = moneyFormatter(loan.total_amount);
            loan.balance_amount = moneyFormatter(loan.balance_amount);
            loan.interest = `${loan.interest}%`;
            return loan;
      })
  });


</script>