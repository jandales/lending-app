<template>
  <div class="w-full bg-white">
      <div class="flex flex-col  p-4">
           <h1 class="block tracking-wider text-lg mb-6 ">Customers Report</h1> 
      
  
      
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
                  Name
                </th>
                <th scope="col">
                    Email
                </th>
                <th scope="col">
                  Phone
                </th>
                <th scope="col">
                  address
                </th>
                <th scope="col">
                  Loan Count
                </th>
                <th scope="col">
                   Total Loan
                </th>  
              </tr>
            </thead>
            <tbody>  
           
              <tr v-if="borrowers.length > 0" v-for="borrower in borrowers" class="bg-white border-b transition duration-300 ease-in-out last:border-b-0 hover:bg-gray-100"> 
                <td class="capitalize text-sm  font-light px-6 py-4 whitespace-nowrap">
                     {{ borrower.name }}
                </td>       
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">    
                 {{ borrower.email }}  
                </td>
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                     {{ borrower.phone  }}
                </td>  
                <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ borrower.address }}
                </td>  
                <td class="text-sm text-center text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                   {{ borrower.loans_count }}
                </td>
                  <td class="text-sm text-gray-900 font-light px-6 py-4 whitespace-nowrap">
                  {{ borrower.loans_sum_total_amount }}
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

  const { getBorrowerReports, borrowerReports } = useReport();

  const { moneyFormatter } = useFormater();  

  const form = reactive({

    start_date : null,

    end_date : null,

    filter : null,   

  })

  const submit = async () => {   

    await getBorrowerReports({...form});

  }

  const borrowers = computed(() => {
     return  borrowerReports.value.map(borrower => { 
            borrower.loans_sum_total_amount = moneyFormatter(borrower.loans_sum_total_amount);          
            return borrower;
      })
  });


</script>