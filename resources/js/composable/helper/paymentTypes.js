import { ref } from 'vue';

export default function usePaymentTypes() { 

    const paymentTypes = ref([
        { name :  'Daily', value : 'daily'},
        { name :  'Weekly', value : 'weekly'},
        { name :  '15Days', value :'15Days'},
        { name :  'Monthly', value :'monthly'},
    ])

    return  { paymentTypes }

}