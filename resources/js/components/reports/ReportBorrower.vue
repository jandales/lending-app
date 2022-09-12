<template>
  <div class="w-full bg-white">
      <div class="flex flex-col  p-4">
          
      <div class="w-full flex items-center justify-between mb-6">
            <h1 class="tracking-wider text-lg">Borrower Reports</h1> 
          <div class="flex gap-4">
            <button @click="exportHandle">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3" />
              </svg>

            </button>

            <button @click="toPDFHandle">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0110.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0l.229 2.523a1.125 1.125 0 01-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0021 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 00-1.913-.247M6.34 18H5.25A2.25 2.25 0 013 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 011.913-.247m10.5 0a48.536 48.536 0 00-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5zm-3 0h.008v.008H15V10.5z" />
                </svg>
            </button>

          </div>
        </div>
  
      
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

  <div v-if="borrowers.length > 0" class="mt-4 border border-l-0 border-r-0 bg-white">
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
  import useExport from '../../composable/exports/loans';
  import useFormater from '../../composable/helper/formater'

  const { getBorrowerReports, borrowerReports } = useReport();

  const { exportBorrowers, reportBorrowerstoPDF } = useExport();

  const { moneyFormatter } = useFormater();  

  const form = reactive({

    start_date : null,

    end_date : null,

    filter : null,   

  })

  const submit = async () => {   

    await getBorrowerReports({...form});

  }

  const exportHandle = async () => {
     await exportBorrowers({...form});
  }
  const toPDFHandle = async () => {
    await reportBorrowerstoPDF();
  }

  const borrowers = computed(() => {
     return  borrowerReports.value.map(borrower => { 
            borrower.loans_sum_total_amount = moneyFormatter(borrower.loans_sum_total_amount);          
            return borrower;
      })
  });


</script>