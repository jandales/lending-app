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
import ResetPassword  from '../pages/ResetPassword.vue'
import Page404 from '../pages/Page404.vue'
import Setting from '../pages/Setting.vue'
import ChangePassword from '../components/settings/ChangePassword.vue'
import Profile from '../components/settings/Profile.vue'
import LoanIndex from '../components/loans/Index.vue';
import LoanCreate from '../components/loans/Create.vue';
import PaymentIndex from '../components/payments/Index.vue';
import PaymentCreate from '../components/payments/Create.vue';
import LoanDetails from '../components/loans/Details.vue';
import middleware  from './middleware'



const router = createRouter({ 
    history : createWebHistory(),
    routes : [
        { path : '/', name : 'home', component : Home, beforeEnter : middleware.authenticated , children : [

            { path : 'Dashboard' , name : 'dashboard', component : Dashboard },

            { path : 'loans' , name : 'loans', component : LoanIndex },
            { path : 'loans/details/:id' , name : 'loans.details', component : LoanDetails },
            { path : 'loans/create' , name : 'loans.create', component : LoanCreate },

            { path : 'loan-types' , name : 'loanTypes', component : LoanTypeIndex },
            { path : 'loan-types/create' , name : 'loanTypes.create',  component : CreateType  },
            { path : 'loan-types/edit/:id', name : 'loanTypes.edit',  component : EditType  },

            { path : 'customers', name : 'customers', component : customerIndex },
            { path : 'customers/create', name : 'customers.create', component : customerCreate },
            { path : 'customers/edit/:id', name : 'customers.edit', component : customerEdit },

            { path: 'payments' , name : 'payments', component : PaymentIndex },
            { path: 'payments/create/:loan_id?', name : 'payments.create', component : PaymentCreate },

            { path : 'settings', name: 'settings', component : Setting, beforeEnter : middleware.authenticated , children : [

                {path : '', name : 'profile', component : Profile},

                {path : '/change-password', name : 'change.password', component :ChangePassword}

            ]},

        ]},

        { path : '/login', name : 'login', component : Login, beforeEnter : middleware.guest },

        { path : '/forgot-password', name : 'forgot.password', component : ForgotPassword, beforeEnter : middleware.guest },

        { path : '/reset-password/:token', name : 'reset.password', component : ResetPassword, beforeEnter : middleware.guest },

       

        { path : '/page-not-found', name : 'page.not.found', component : Page404 }
    ],
   
});

export default router;