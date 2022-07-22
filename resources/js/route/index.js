import { createRouter, createWebHistory } from 'vue-router'

import Login from '../pages/Login.vue'
import Home from '../pages/Home.vue'
import LoanTypeIndex from '../components/LoanTypes/Index.vue'
import CreateType from '../components/LoanTypes/Create.vue'
import EditType from '../components/LoanTypes/Edit.vue'
import customerIndex from '../components/customers/Index.vue'
import customerCreate from '../components/customers/Create.vue'
import customerEdit from '../components/customers/Edit.vue'
import Dashboard from '../pages/Dashboard.vue'
import ForgotPassword from '../pages/ForgotPassword.vue'
import middleware  from './middleware'



const router = createRouter({ 
    history : createWebHistory(),
    routes : [
        { path : '/', name : 'home', component : Home, beforeEnter : middleware.authenticated , children : [

            { path : 'Dashboard' , name : 'dashboard', component : Dashboard },

            { path : 'transactions' , name : 'transactions', component : Dashboard },

            { path : 'loan-types' , name : 'loanTypes', component : LoanTypeIndex },
            { path : 'loan-types/create' , name : 'loanTypes.create',  component : CreateType  },
            { path : 'loan-types/edit/:id', name : 'loanTypes.edit',  component : EditType  },

            { path : 'customers', name : 'customers', component : customerIndex },
            { path : 'customers/create', name : 'customers.create', component : customerCreate },
            { path : 'customers/edit/:id', name : 'customers.edit', component : customerEdit },

        ]},

        { path : '/login', name : 'login', component : Login, beforeEnter : middleware.guest },

        { path : '/forgot-password', name : 'forgot.password', component : ForgotPassword, beforeEnter : middleware.guest }
    ],
   
});

export default router;