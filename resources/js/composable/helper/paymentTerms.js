import { ref } from 'vue';

export default function usePaymentTerms() { 

    const paymentTerms = ref([
        { name : `${1} Month`, value : 1 },
        { name : `${2} Months`, value : 2 },
        { name : `${3} Months`, value : 3 },
        { name : `${4} Months`, value : 4 },
        { name : `${5} Months`, value : 5 },
        { name : `${6} Months`, value : 6 },
        { name : `${7} Months`, value : 7 },
        { name : `${8} Months`, value : 8 },
        { name : `${9} Months`, value : 9 },
        { name : `${10} Months`, value : 10 },
        { name : `${11} Months`, value : 11 },
        { name : `${12} Months`, value : 12 },
    ])

    return {
        paymentTerms
    }
}


