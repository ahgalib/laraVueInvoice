import {defineStore} from 'pinia';
import axios from 'axios'

export const useInvoiceStore = defineStore('createInvoice',{

    state : () => ({
        userData : {},
        loading : false,
        singleInvoiceData : [],
        totalAmount : null,
        dueAmount : null,
        transactionData : [],
        totalPaidAmount : null,
        isInvoiceExist : false,
        depositAmount : null,
        depositDuDate : null,
        dueDate : null,
        paidLoading: false,
        successDeleteTrans:false,
    }),

    actions: {

        async getSingleInvoice(uid){
            this.loading = true;

            let response = await axios.get('http://127.0.0.1:8000/api/single-invoice/'+uid);
            this.singleInvoiceData = response.data;
            this.userData = response.data.user;
            this.totalAmount = this.singleInvoiceData.total;
            this.dueAmount = this.singleInvoiceData.due_amount;
            this.dueDate = this.singleInvoiceData.due_date;
            this.totalPaidAmount = this.singleInvoiceData.paid_amount;

            //this.isInvoiceExist = false

            await this.getTransaction()
            await this.getDepositRequest()
            this.loading  = false;

            //return this.singleInvoiceData
        },


        async addPayment(paymentData){
            this.paidLoading  = true;
            let response = await axios.post('http://127.0.0.1:8000/api/add-transaction',{
                'invoice_id' :  this.singleInvoiceData.id,
                'paid_amount' :  paymentData.amount,
                'paid_date' :  paymentData.date.toISOString().substr(0, 10),
                'payment_method' :  paymentData.method,
                'note' :  paymentData.note,
            });
            await this.getTransaction()

            await this.getDepositRequest()

            this.calculateTotalAmount
            this.calculateDueAmount
            this.paidLoading  = false;

        },

        async getTransaction(){
            let response = await axios.get('http://127.0.0.1:8000/api/show-transaction/'+this.singleInvoiceData.id);

            this.transactionData = response.data.data


        },

        async deleteTransaction(id){
            let response = await axios.post('http://127.0.0.1:8000/api/delete-transaction',{
                'id' :  id,
                'invoiceId' :  this.singleInvoiceData.id,
            });
            await this.getTransaction()
            this.calculateTotalAmount
            this.calculateDueAmount
            this.successDeleteTrans = true

        },

        async createDepositRequest(amount, dueDate){
            let response = await axios.post('http://127.0.0.1:8000/api/invoice/deposit/'+this.singleInvoiceData.id,{
                'invoice_id' :  this.singleInvoiceData.id,
                'diposit_amount' :  amount,
                'due_date' :  dueDate.toISOString().substr(0, 10),
            });

            //console.log(response);
            await this.getDepositRequest()
            this.isInvoiceExist = true;
        },


        async editDepositRequest(amount, dueDate){
            let response = await axios.post('http://127.0.0.1:8000/api/invoice/deposit/update/'+this.singleInvoiceData.id,{
                'invoice_id' :  this.singleInvoiceData.id,
                'diposit_amount' :  amount,
                'due_date' :  dueDate.toISOString().substr(0, 10),
            });

            //console.log(response);
            if(amount > 0.1){

                this.isInvoiceExist = true;
            }else{
                this.isInvoiceExist = false;
            }
            await this.getDepositRequest()
        },

        async getDepositRequest(){

            let response = await axios.get('http://127.0.0.1:8000/api/invoice/deposit/show/'+this.singleInvoiceData.id);

            if(response.data.message === 'success'){
                this.isInvoiceExist = true;
                this.depositAmount = response.data.data.diposit_amount;
                this.depositDuDate = response.data.data.due_date;


            }else{
                this.isInvoiceExist = false;
                this.depositAmount = null;
                this.depositDuDate = null;
            }

            // console.log(response)

        },
    },
    getters: {
        calculateTotalAmount() {

            // Calculate the total paid amount using reduce
            let totalAmount =  this.transactionData.reduce((total, transaction) => total + transaction.paid_amount, 0);

           // console.log("This is the total amount:", this.totalPaidAmount = totalAmount);
            return this.totalPaidAmount = totalAmount

        },
        calculateDueAmount(){
            return this.dueAmount = this.totalAmount - this.totalPaidAmount
        }
    }

})
