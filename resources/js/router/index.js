import { createRouter, createWebHistory } from "vue-router";
import Home from '../component/Home.vue'
import Invoice from '../component/Invoice.vue'
import CreateInvoice from '../component/CreateInvoice.vue'

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path:'/',
            name:'home',
            component : Home
        },
        {
            path:'/invoice',
            name:'invoice',
            component : Invoice
        },
        {
            path:'/create-invoice',
            name:'create-nvoice',
            component : CreateInvoice
        }
    ]
})

export default router;
