import { createRouter, createWebHistory } from "vue-router";
import Home from '../component/Home.vue'

import CreateInvoice from '../component/CreateInvoice.vue';
import InvoiceList from '../component/InvoiceList.vue';
import SingleInvoice from '../component/singleInvoice/MainInvoice.vue';

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path:'/',
            name:'home',
            component : Home
        },

        {
            path:'/create-invoice',
            name:'create-invoice',
            component : CreateInvoice
        },
        {
            path: '/invoices-list',
            name: 'invoices-list',
            component : InvoiceList

        },
        {
            path: '/single-invoice/:uid',
            name: 'single-invoice',
            component : SingleInvoice

        },
    ]
})

export default router;
