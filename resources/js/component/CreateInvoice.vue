<template>
    <div class="top-section">
        <div>
            <p><router-link class="breadcrumb" to="/">Document / </router-link> <router-link class="breadcrumb" to="/invoice"> Invoice </router-link> / create</p>
        </div>
        <div>
            <Button label="Save" severity="info" @click="submitCreateInvoiceForm()"/>
        </div>
    </div>
    <Toast />
    <div class="create-wrapper">
        <div class="create-sectin">
            <Card>
                <template #content>
                    <div class="create-invoice-card">
                        <div class="user-info" v-if="showSelectbox == false">
                            <div class="edit-with-name">
                                <h3>{{ invoiceUser.user.name }}</h3>
                                <button class="name-edit">edit</button>
                            </div>
                            <p style="margin-top:-8px;">{{invoiceUser.user.email}}</p>
                        </div>

                        <div class="select-user" v-if="showSelectbox">
                            <Dropdown v-model="invoiceUser.user" :options="users" optionLabel="name" placeholder="Select User" class="w-full md:w-18rem select-dropdown" @change="changeUser(invoiceUser.user.id)"/>
                        </div>


                        <div class="invoice-form">
                            <span class="p-float-label">
                                <InputText id="username" v-model="createInvoiceData.invoiceNumber" class="input-field"/>
                                <label for="invoiceNumber">Invoice Number</label>
                            </span>
                            <span class="p-float-label">
                                <InputText id="p-order" v-model="createInvoiceData.purchase" class="input-field"/>
                                <label for="p-order">Purchase Order (PO) #</label>
                            </span>
                            <span class="p-float-label">
                                <Calendar v-model="createInvoiceData.date" showIcon dateFormat="dd M yy"/>
                                <label>Date #</label>
                            </span>
                            <span class="p-float-label">
                                <Calendar v-model="createInvoiceData.dueDate" showIcon dateFormat="dd M yy" @change="dateFormat"/>
                                <label>Due Date #</label>
                            </span>

                        </div>
                    </div>
                </template>
            </Card>


            <div class="invoice-item-section">
                <Card>
                    <template #content>

                        <div>
                            <table width="100%" class="invoice-table">
                                <tr>
                                    <td>
                                        <table width="100%" class="invoice-table">
                                            <tr>
                                                <th class="service-item-th" style="width:27%" border="1">ITEM</th>
                                                <th>QUENTITY</th>
                                                <th>PRICE</th>
                                                <th>AMOUNT</th>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr v-for="(item, index) in selectedServiceArray" :key="index" class="main-table-tr">
                                    <td>
                                        <table width="100%" style="margin-bottom:20px;">
                                            <tr class="table-data">
                                                <td class="item-name">
                                                    <div class="item-div">
                                                        <div>{{ item.name }}</div>
                                                        <div><i class="pi pi-trash" @click="deleteItem(index)"></i></div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <input type="text" v-model="item.quantity" class="input-box" @keyup="updateTotalAmount(item)">
                                                </td>

                                                <td><input type="text" v-model="item.price" class="input-box" @keyup="updateTotalAmount(item)"></td>

                                                <td>{{ item.totalAmount.toLocaleString("en-US") }} TK</td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">

                                                    <input type="text" class="item-description" placeholder="Item description">
                                                </td>
                                                <td class="tax-td" @click="discountPopUp">
                                                    Tax & Discount
                                                </td>
                                            </tr>
                                        </table>
                                        <Divider />
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <Divider />

                        <div class="table-bottom-div">
                            <div class="select-user">
                                <Dropdown v-model="selectedService" :options="services" optionLabel="name" placeholder="Select a Service" class="w-full md:w-18rem select-dropdown" @change="getSelectedItemName()"/>
                            </div>

                            <div class="total-into">
                                <table width="100%" >
                                    <tr>
                                        <th>Subtotal</th>
                                        <th>TK{{subtotalAmount.toLocaleString("en-US")}}</th>
                                    </tr>
                                    <tr class="">
                                        <td @click="visible = true" class="invoice-tax-td">{{ taxs.firstTaxName }} {{taxs.firstTaxRate}} % (incl.)</td>
                                        <td>TK{{firstTaxAmount.toLocaleString("en-US")}} </td>
                                    </tr>
                                    <tr class="">
                                        <td @click="visible = true" class="invoice-tax-td">{{ taxs.secondTaxName }} {{taxs.secondTaxRate}}% (incl.)</td>
                                        <td>TK{{ secondTaxAmount.toLocaleString("en-US") }}</td>
                                    </tr>
                                    <tr class="table-data-subtotal">
                                        <td>Total</td>
                                        <td>TK{{totalAmount.toLocaleString("en-US")}}</td>
                                    </tr>
                                    <Divider />
                                    <tr class="table-data-amount">
                                        <td>Amount due </td>
                                        <td>TK{{totalAmount.toLocaleString("en-US")}}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                    </template>
                </Card>
            </div>

        </div>

        <div class="deposit-section">
            <Card class="upgrade-card-1">
                <template #title> Update Document</template>
                <template #content>
                    <p class="m-0">
                        Send as many documents as you want by upgrading your plan.
                    </p>
                    <Button label="View Plan" severity="success" outlined />
                </template>
            </Card>
        </div>

        <!----------- tax modal start ------------->
        <div class="card flex justify-content-center">
            <Dialog v-model:visible="visible" modal header="TAX Settings" :style="{ width: '40rem' }" :breakpoints="{ '1199px': '75vw', '575px': '90vw' }">
                <Tax @taxEmit= "getTax"/>
            </Dialog>
        </div>
         <!----------- tax modal end ----------------->

    </div>
</template>

<script setup>

import { ref, reactive, onMounted, toRefs, watch, computed } from "vue";
import Card from 'primevue/card';
import Dropdown from 'primevue/dropdown';
import InputText from 'primevue/inputtext';
import Toast from 'primevue/toast';

import { useToast } from 'primevue/usetoast';
import Divider from 'primevue/divider';
import Calendar from 'primevue/calendar';
import axios from 'axios';
import Tax from './createInvoiceComponent/TaxModal.vue'

import Dialog from 'primevue/dialog';

const visible = ref(false);


const selectedService = ref('');
const selectedServiceArray = ref([]);
const services = ref([]);
const toast = useToast();

const selectedUser = ref();
const today = new Date();


const showSelectbox = ref(true);
// Calculate the due date (current date + 7 days)
const dueDate = new Date(today);
dueDate.setDate(today.getDate() + 7);


const createItemData = reactive({
    service_title : '',
    quantity : '',
    price : '',
    total_price : '',
    note : '',
})

const changeUser = (id) => {
    showSelectbox.value = false;
    createInvoiceData.user = id;


}


function dynamicText(message){
    return toast.add({ severity: 'error', detail: message, life: 3000 });
}



const createInvoiceItems = () => {
    selectedServiceArray.value.forEach((item, index) => {
        createItemData.service_title = item.name;
        createItemData.quantity = item.quantity;
        createItemData.price = item.price;
        createItemData.total_price = item.totalAmount;
        createItemData.note = ''; // Update this if needed

        console.log(`Item ${index + 1}:`, createItemData);

        //console.log('this is service array item man ',selectedServiceArray.value);
    });
}

const users = ref([])

const fetchAllUser = async() => {
    let response = await axios.get('http://127.0.0.1:8000/api/user');
    users.value = response.data.data
}

//////////////////////// tax part start ///////////////////////////////////

const taxs = reactive({
    firstTaxName : 'First Tax',
    firstTaxRate : 30,
    secondTaxName : 'Second Tax',
    secondTaxRate : 23,
})
const getTax = (tax) => {
    console.log('emit works',tax.firstTaxCode);
    taxs.firstTaxName = tax.firstTaxCode;
    taxs.firstTaxRate = tax.firstTaxRate;
    taxs.secondTaxName = tax.secondTaxCode;
    taxs.secondTaxRate = tax.secondTaxRate;
    visible.value = false;
}

/////////////////////////// tax part end /////////////////////////////////

const updateTotalAmount = (item) => {
    item.totalAmount = item.quantity * item.price;
}

const deleteItem = (index) => {
    selectedServiceArray.value.splice(index, 1);
}


const subtotalAmount = computed(()=>{
    return selectedServiceArray.value.reduce((sum,item)=>{
        createInvoiceData.subtotal = sum + (item.totalAmount || 0)
        return sum + (item.totalAmount || 0)
    },0)


})


const firstTaxAmount = computed(()=>{
    return (subtotalAmount.value * taxs.firstTaxRate) / 100 ;
})

const secondTaxAmount = computed(()=>{
    return (subtotalAmount.value * taxs.secondTaxRate) / 100 ;
})


const totalAmount = computed(()=>{
    return (subtotalAmount.value + firstTaxAmount.value + secondTaxAmount.value)
})


// ---------- submit invoice data ------------------------------
const invoiceUser = ref({
    user:'',
});




const createInvoiceData = reactive({
    user: '',
    invoiceNumber : '',
    purchase : '',
    date : today,
    dueDate : dueDate,
    subtotal : '',
    total : totalAmount,
    firstTaxName: taxs.firstTaxName,
    firstTaxRate : taxs.firstTaxRate,
    firstTaxAmount : firstTaxAmount,
    secondTaxName : taxs.secondTaxName,
    secondTaxRate : taxs.secondTaxRate,
    secondTaxAmount : secondTaxAmount,


});



watch(
    [() => createInvoiceData.dueDate, () => createInvoiceData.date],
    ([newDueDate, currentDate], [oldDueDate, oldDate]) => {
        if (newDueDate < currentDate) {
        // Update the dueDate property in createInvoiceData
        createInvoiceData.dueDate = new Date(currentDate);

        }
    }
);

const submitCreateInvoiceForm = async() => {

    if(invoiceUser.user == ''){
        dynamicText('There should be a customer');
    }else if(createInvoiceData.invoiceNumber == ''){
        dynamicText('Invoice Number is required');
    }else if(createInvoiceData.dueDate < createInvoiceData.date){
        createInvoiceData.date = createInvoiceData.dueDate;
    }else if(selectedServiceArray.value.length <= 0){
        dynamicText('Please select a item');
    }else{
        

        let createData = await axios.post('http://127.0.0.1:8000/api/store-invoice',{
            'invoice_no'            : createInvoiceData.invoiceNumber,
            'user_id'               : createInvoiceData.user,
            'purchase_order'        : createInvoiceData.purchase,
            'issue_date'            : createInvoiceData.date.toISOString().substr(0, 10),
            'due_date'              : createInvoiceData.dueDate.toISOString().substr(0, 10),

            'subtotal'              : createInvoiceData.subtotal,
            'total'                 : createInvoiceData.total,
            'paid_amount'           : 0,
            'due_amount'            : createInvoiceData.total,

            'tax_title'             : createInvoiceData.firstTaxName,
            'tax_percentage'        : createInvoiceData.firstTaxRate,
            'tax_amount'            : createInvoiceData.firstTaxAmount,
            'second_tax_title'      : createInvoiceData.secondTaxName,
            'second_tax_percentage' : createInvoiceData.secondTaxRate,
            'second_tax_amount'     : createInvoiceData.secondTaxAmount,
        });

        let createItemData = await axios.post('http://127.0.0.1:8000/api/store-invoice-items-0987',{
            invoiceItems: selectedServiceArray.value,
        });


        if(createData.data.message === 'success'){
            toast.add({ severity: 'success', detail: 'Invoice HasBeen Created Successfully', life: 3000 });

            selectedServiceArray.value = [];
        }


    }
}



// -----------------submit invoice data end

// service section js start
const getSelectedItemName = () => {
    if (selectedService.value) {
        const selectedItem = {
            ...selectedService.value,
            quantity: 1,
            totalAmount: selectedService.value.price
        };
        selectedServiceArray.value.push(selectedItem);
    }
};



const fetchAllService = async() => {
    let response = await axios.get('http://127.0.0.1:8000/api/service');
    services.value = response.data.data
}


onMounted(async()=>{
    fetchAllUser()
    fetchAllService()
})


</script>

<style scoped>
.top-section{
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}
.breadcrumb{
    text-decoration: none;
}

.create-wrapper{
    display:flex;
    justify-content: space-between;
}

.create-sectin{
    width : 65%;
}


.deposit-section{
    width: 30%;
}

.create-invoice-card{
    display: flex;
    justify-content: space-between;
}

.select-user{
    width: 50%;
}

.select-dropdown{
    width:90% !important;
}

.p-float-label{
    margin-bottom:30px;
}

.input-field{
    width:100%;
}

.edit-with-name{
    display:flex;
    justify-content: space-between;
}
.name-edit{
    width: 58px;
    padding: 5px 10px;
    height: 33px;
    background: white;
    border: 2px solid white;
    color: rgb(0, 126, 128);
    margin-top:13px;
    font-size: 14px;
    border-radius: 6px;
    transition: .2s;
}

.name-edit:hover{
    background-color: rgb(241, 254, 254);
}


.invoice-table{
    margin-bottom: 10px;
}

.invoice-table th{
    padding-bottom:20px;
    border-bottom:1px solid rgb(233, 229, 229);
    text-align:right;
}

.service-item-th{
    text-align:left !important;
}
.item-name{
    text-align:left !important;
    width: 40%;

}

.invoice-tax-td{
    color: rgb(25, 136, 138);
    font-weight: bold;
    text-align: center;
    padding: 8px 0px;
    text-decoration: underline;
    cursor: pointer;
}

.item-div{
    display: flex;
    justify-content: space-between;
}

.table-data td{
    text-align:right;

}

.main-table-tr{
    margin-bottom:10px;
}

.pi-trash{
    color:red;
}

.input-box{
    width:100px;
    padding:5px 0px;
    text-align: center;

}

.discount{
    width:100px;
    padding:5px 0px;
    text-align: center;
}

.table-bottom-div{
    display:flex;
    justify-content: space-between;
}

.total-into{

    width:50%;
}


.table-data-amount{
    text-align: center;
}

.table-data-subtotal td{
    text-align: center;
    padding:6px 0px;
}

.item-description{
    width:100%;
    height:30px;
    margin-top:20px;
}
.tax-td{
    padding-top:30px;
    color:rgb(25, 136, 138);
    text-align: center;
    float:right;
    font-weight: bold;
}
</style>
