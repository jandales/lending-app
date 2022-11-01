import { createRouter, createWebHistory } from 'vue-router'

import middleware  from '../middleware/index';

const router = createRouter({ 

    history : createWebHistory(),

    routes : [
                
        { 
            path : '/', name : 'home', component : () => import('../pages/Home.vue'), beforeEnter : middleware.authenticated , children : 
            [
                { path : '' , name : 'dashboard', component : () => import('../pages/Dashboard.vue') },

                { path : 'loans' , name : 'loans', component : () => import('../components/loans/LoanIndex.vue') },

                { path : 'loans/details/:id' , name : 'loans.details', component : () => import('../components/loans/LoanDetails.vue') },

                { path : 'loans/create' , name : 'loans.create', component : () => import('../components/loans/LoanCreate.vue') },

                { path : 'loan-types' , name : 'loanTypes', component : () => import('../components/LoanTypes/Index.vue') },

                { path : 'loan-types/create' , name : 'loanTypes.create',  component : () => import('../components/LoanTypes/Create.vue')  },

                { path : 'loan-types/edit/:id', name : 'loanTypes.edit',  component : () => import('../components/LoanTypes/Edit.vue')  },

                { path : 'borrowers', name : 'borrowers', component : () => import('../components/borrowers/BorrowerIndex.vue') },

                { path : 'borrowers/create', name : 'borrowers.create', component : () => import('../components/borrowers/BorrowerCreate.vue') },

                { path : 'borrowers/edit/:id', name : 'borrowers.edit', component : () => import('../components/borrowers/BorrowerEdit.vue') },

                { path : 'borrowers/details/:id', name : 'borrowers.details', component :  () => import('../components/borrowers/BorrowerDetails.vue') },            

                { path: 'payments' , name : 'payments', component : () => import('../components/payments/PaymentIndex.vue')},
      
                { path: 'payments/create', name : 'payments.create', component : () => import('../components/payments/Create.vue') },

                { path: 'reports/loans', name : 'report.loans', component : () => import('../components/reports/ReportLoans.vue') },

                { path: 'reports/payments', name : 'report.payments', component : () => import('../components/reports/ReportPayments.vue') },

                { path : 'reports/customers', name : 'report.customers', component :  () => import('../components/reports/ReportBorrower.vue') },

                { path : 'users', name : 'users', component : () => import('../components/users/UserIndex.vue'),  beforeEnter : middleware.role  },

                { path : 'users/create', name : 'users.create', component : () => import('../components/users/UserCreate.vue'),  beforeEnter : middleware.role },

                { path : 'users/edit/:id', name : 'users.edit', component : () => import('../components/users/UserEdit.vue'),  beforeEnter : middleware.role  },

                { path : 'funds', name : 'funds', component : () => import('../components/funds/FundIndex.vue'),  beforeEnter : middleware.role  },

                { path : 'settings', name: 'settings', component : () => import('../pages/Setting.vue'),  children : [
      
                    {path : 'profile', name : 'settings.profile', component : () => import('../components/settings/Profile.vue')},

                    { path : 'change-password', name : 'settings.change.password', component : () => import('../components/settings/ChangePassword.vue') },

                    {path : 'interest', name : 'settings.interest', component : ()=> import('../components/settings/Interest.vue'), beforeEnter : middleware.role}

                ], beforeEnter : middleware.authenticated},
                               
            ]
        },

        { path : '/login', name : 'login', component : () => import('../pages/Login.vue'), beforeEnter : middleware.guest },

        { path : '/forgot-password', name : 'forgot.password', component : () => import('../pages/ForgotPassword.vue'), beforeEnter : middleware.guest },

        { path : '/reset-password/:token', name : 'reset.password', component : () => import('../pages/ResetPassword.vue'), beforeEnter : middleware.guest },         

        { path: '/:pathMatch(.*)*', name: 'page.not.found', component: () => import('../pages/Page404.vue') },
       
    ],
    linkActiveClass: "active"
   
});

export default router;