<template>
    <div>

        <div class="top-header">
            <p>Total amount</p>
            <p>TK.{{ dueAmount }}</p>
        </div>

        <div class="mark-paid-div">

            <div>

                <label for="percentage" class="depo-label">Percentage</label>
                <input type="number" v-model="percentage" class="number-field" id="percentage" @keyup="calculateAmount()"/>
            </div>


            <p class="equal"> = </p>

            <div>
                <label for="amount" class="depo-label">Amount </label>
                <input type="number" v-model="amount" class="number-field" id="amount" @keyup="calculatePercentage()"/>
            </div>
        </div>


        <label for="date" class="date-label">Due Date</label>
        <Calendar v-model="dueDate" class="calendar-field"/>



        <div class="divider"></div>

        <div class="button-div">
            <Button label="Add Payment" severity="success" text @click="submitDepositModal"/>
            <Button label="Cancel" severity="secondary" text  @click="$emit('close')"/>
        </div>

        <Toast />
    </div>
</template>

<script setup>
import { ref, reactive, onMounted, toRefs, watch, computed, watchEffect  } from "vue";

import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';


import Calendar from 'primevue/calendar';

import {useInvoiceStore} from '../../../store/Invoice';
import { storeToRefs } from "pinia";

const store = useInvoiceStore();
const {dueAmount, totalPaidAmount} = storeToRefs(store);

const {createDepositRequest} = store;


const toast = useToast();

let percentage = ref(0);
let amount = ref(0);
let dueDate = ref(new Date());

const emit = defineEmits('closeDepositSuccess');


function calculateAmount () {

    if(percentage.value > 100){
        toast.add({ severity: 'error', detail: 'Max percentage amount is 100', life: 3000 })
        percentage.value = 0;
        amount.value = 0;
    }else{

        amount.value = ((percentage.value * dueAmount.value) / 100).toFixed(2);
    }

}


function calculatePercentage () {

    if(amount.value > dueAmount.value){
        toast.add({ severity: 'error', detail: 'Amount Cannot bigger then tatal amount', life: 3000 })
        percentage.value = 0;
        amount.value = 0;
    }else{

        percentage.value = ((amount.value / dueAmount.value) * 100).toFixed(2);
    }

}

const submitDepositModal = () => {
    if(amount.value <= 0 || percentage.value <= 0){
        toast.add({ severity: 'error', detail: 'Please enter an amount or percentage', life: 3000 })
    }else{
        createDepositRequest(amount.value,dueDate.value)
        emit('closeDepositSuccess')
    }
}


</script>


<style scoped>

.top-header{
    display: flex;
    justify-content: space-between;
    font-weight: 600;
}
.mark-paid-div{

    display: flex;
    justify-content: space-around;
}


.number-field{
    /* width:20%; */
    padding:12px 10px;
    margin-bottom:16px;
    margin-top:7px;

}

.calendar-field{
    width:40%;
    margin-bottom:20px;
    margin-top:8px;


}

.divider{
    width:100%;
    height:1px;
    background-color: rgb(224, 222, 222);
}

.button-div{
    float:right;
    padding-top:9px;

}

.equal{
    font-size:25px;
    font-weight: bold;
    margin-right:50px;

}

.depo-label{
    font-size:13px;
}

.date-label{
    display: block;
}
</style>
