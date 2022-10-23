import { ref } from 'vue';

export default function useStatus() { 

const borrowerStatus = ref([
        { name : 'all', value : 'all' },
        { name : 'active', value : 1 },
        { name : 'not active', value : 0 },
])

const paymentStatus = ref([
        { name : 'all', value : 'all' },
        { name : 'paid', value : 'paid' },
        { name : 'void', value : 'void' },
])

const loanStatus = ref([
        { name : 'all',      value : 'all' },
        { name : 'paid',     value : 'paid' },
        { name : 'approved', value : 'approved' },
        { name : 'active',   value : 'active' },
        { name : 'pending',  value : 'pending' },
        { name : 'rejected', value : 'rejected'},
        { name : 'void',     value : 'void' },
])

const roles = ref([
        { name : 'All',  value : 0 },
        { name : 'Admin', value : 1 },
        { name : 'Employee', value : 2},
])


return  { 
        borrowerStatus,
        paymentStatus,
        loanStatus,
        roles,
 }

}