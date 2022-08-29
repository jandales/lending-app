import { createRouter, createWebHistory } from 'vue-router'

import Login from '../pages/Login.vue'
import Home from '../pages/Home.vue'
import LoanTypeIndex from '../components/LoanTypes/Index.vue'
import CreateType from '../components/LoanTypes/Create.vue'
import EditType from '../components/LoanTypes/Edit.vue'
import borrowerIndex from '../components/borrowers/Index.vue'
import borrowerCreate from '../components/borrowers/Create.vue'
import borrowerEdit from '../components/borrowers/Edit.vue'
import borrowerDetails from '../components/borrowers/Details.vue';
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
import ReportLoans from '../components/reports/ReportLoans.vue';
import ReportBorrower from '../components/reports/ReportBorrower.vue';
import ReportPayments from '../components/reports/ReportPayments.vue';
import Interest from '../components/settings/Interest.vue';
import UserIndex from '../components/users/Index.vue';
import UserCreate from '../components/users/Create.vue';
import UserEdit from '../components/users/Edit.vue';
import middleware  from './middleware';

const router = createRouter({ 

    history : createWebHistory(),

    routes : [
                
        { 
            path : '/', name : 'home', component : Home, beforeEnter : middleware.authenticated , children : 
            [
                { path : '' , name : 'dashboard', component : Dashboard },

                { path : 'loans' , name : 'loans', component : LoanIndex },

                { path : 'loans/details/:id' , name : 'loans.details', component : LoanDetails },

                { path : 'loans/create' , name : 'loans.create', component : LoanCreate },

                { path : 'loan-types' , name : 'loanTypes', component : LoanTypeIndex },

                { path : 'loan-types/create' , name : 'loanTypes.create',  component : CreateType  },

                { path : 'loan-types/edit/:id', name : 'loanTypes.edit',  component : EditType  },

                { path : 'borrowers', name : 'borrowers', component : borrowerIndex },

                { path : 'borrowers/create', name : 'borrowers.create', component : borrowerCreate },

                { path : 'borrowers/edit/:id', name : 'borrowers.edit', component : borrowerEdit },

                { path : 'borrowers/details/:id', name : 'borrowers.details', component : borrowerDetails },            

                { path: 'payments' , name : 'payments', component : PaymentIndex },

                { path: 'payments/create/:loan_id?', name : 'payments.create', component : PaymentCreate },

                { path: 'reports/loans', name : 'report.loans', component : ReportLoans },

                { path: 'reports/payments', name : 'report.payments', component : ReportPayments },

                { path : 'reports/customers', name : 'report.customers', component : ReportBorrower },

                { path : 'users', name : 'users', component : UserIndex,  beforeEnter : middleware.role  },

                { path : 'users/create', name : 'users.create', component : UserCreate,  beforeEnter : middleware.role },

                { path : 'users/edit/:id', name : 'users.edit', component : UserEdit,  beforeEnter : middleware.role  },

                { path : 'settings', name: 'settings', component : Setting,  children : [
      
                    {path : 'profile', name : 'settings.profile', component : Profile},

                    // {path : 'change-password', name : 'settings.change.password', component :ChangePassword},

                    {path : 'interest', name : 'settings.interest', component : Interest, beforeEnter : middleware.role}

                ], beforeEnter : middleware.authenticated},
                               
            ]
        },

        { path : '/login', name : 'login', component : Login, beforeEnter : middleware.guest },

        { path : '/forgot-password', name : 'forgot.password', component : ForgotPassword, beforeEnter : middleware.guest },

        { path : '/reset-password/:token', name : 'reset.password', component : ResetPassword, beforeEnter : middleware.guest },       

        { path : '/page-not-found', name : 'page.not.found', component : Page404 },
       
    ],
    linkActiveClass: "active"
   
});

export default router;