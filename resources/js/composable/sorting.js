import { ref } from 'vue';

export default function useSorting () { 

const sorting = ref([
        {name : 'name', displayName : 'Name - Ascending', value : 'asc' },
        {name : 'name', displayName : 'Name - Descending', value : 'desc' },
        {name : 'date', displayName : 'Date - Ascending',  value : 'asc' }, 
        {name : 'date', displayName : 'Date - Descending',  value : 'desc' }, 
])

const paymentSorting = ref([
        {name : 'lastname', displayName : 'Name - Ascending',   value : 'asc' },
        {name : 'lastname', displayName : 'Name - Descending',  value : 'desc' },
        {name : 'created_at', displayName : 'Date - Ascending',   value : 'asc' }, 
        {name : 'created_at', displayName : 'Date - Descending',  value : 'desc' }, 
])


const loanSorting = ref([
        {name : 'lastname', displayName : 'Name - Ascending',   value : 'asc' },
        {name : 'lastname', displayName : 'Name - Descending',  value : 'desc' },
        {name : 'created_at', displayName : 'Date - Ascending',   value : 'asc' }, 
        {name : 'created_at', displayName : 'Date - Descending',  value : 'desc' }, 
]);

const usersSorting = ref([
        {name : 'name', displayName : 'Name - Ascending',   value : 'asc' },
        {name : 'name', displayName : 'Name - Descending',  value : 'desc' },
        {name : 'created_at', displayName : 'Date - Ascending',   value : 'asc' }, 
        {name : 'created_at', displayName : 'Date - Descending',  value : 'desc' }, 
])
 
return  { sorting, loanSorting, paymentSorting, usersSorting }

}