import {defineStore} from 'pinia';
import axios from 'axios'

export const useCreateInvoiceStore = defineStore('createInvoice',{

    state : () => ({
        userData : null
    }),
    actions: {
        submitForm(){
            console.log('pinia worked');
        }
    }
})
