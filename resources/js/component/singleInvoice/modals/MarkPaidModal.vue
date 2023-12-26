<template>
    <div>

        <div class="mark-paid-div">

            <div class="checkbox-div">
                <input class="paid-checkbox-box" type="checkbox" v-model="isFullyPaid" id="paid-checkbox" @change="updatePaidAmount">
                <label for="paid-checkbox" class="fully-paid-text"> Fully Paid </label>
            </div>

            <label for="amount">Amount paid</label>
            <InputNumber v-model="paidInfo.amount" class="number-field" id="amount"  :disabled="isTotalAmountDisable" @input="isCheckedPaidAmount"/>


            <label for="date">Date</label>
            <Calendar v-model="paidInfo.date" class="calendar-field"/>

            <label for="method">Method</label>
            <Dropdown v-model="paidInfo.method" :options="methods" showClear  placeholder="Select a
            method" class="w-full md:w-14rem seleck-field" />


            <label for="note">Note</label>
            <InputText id="note" class="input-field" v-model="paidInfo.note" aria-describedby="username-help" />
        </div>

        <div class="divider"></div>

        <div class="button-div">
            <Button v-if="!paidLoading" label="Add Payment" severity="success" text @click="submitPaidModal"/>

            <button v-if="paidLoading" class="disableButton" disabled>Add Payment<span class="spin"> <i class="pi pi-spin pi-spinner" style="font-size: 1rem"></i></span></button>

            <Button label="Cancel" severity="secondary" text  @click="$emit('close')"/>

        </div>

        <Toast />
    </div>
</template>

<script setup>
import { ref, reactive, onMounted, toRefs, watch, computed, watchEffect  } from "vue";

import InputText from 'primevue/inputtext';
import InputNumber from 'primevue/inputnumber';

import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';




import Dropdown from 'primevue/dropdown';
import Calendar from 'primevue/calendar';

import {useInvoiceStore} from '../../../store/Invoice';
import { storeToRefs } from "pinia";

const store = useInvoiceStore();
const {totalAmount, dueAmount, totalPaidAmount, paidLoading} = storeToRefs(store);

const {addPayment} = store;

const methods = ref(['Cash', 'Credit', 'Check', 'Transfer']);
const toast = useToast();
const emit = defineEmits('successClose');

const paidInfo = reactive({
    amount: 0,
    date:  new Date(),
    method:'',
    note:''
})


const isFullyPaid = ref(false);
const isTotalAmountDisable = ref(false);

const updatePaidAmount = () => {
    if(isFullyPaid.value){
        paidInfo.amount = dueAmount.value;
        isTotalAmountDisable.value = true;
    }else{
        paidInfo.amount = 0;
        isTotalAmountDisable.value = false;
    }
}


function dynamicText(status, message){
    return toast.add({ severity: status, detail: message, life: 3000 });
}


const isCheckedPaidAmount = () => {

    if(dueAmount.value < paidInfo.amount){
        isFullyPaid.value = true;
    }else{
        isFullyPaid.value = false;
    }
}

const submitPaidModal = async() => {

    if(paidInfo.amount <= 0){
        dynamicText('error','Amount Should be Greater Then 0')
    }else if(paidInfo.method == ''){
        dynamicText('error','Payment Method Required')
    }else{
        await addPayment(paidInfo);

        emit('successClose')

    }


}






</script>


<style scoped>
.mark-paid-div{
    padding:5px 20px;
}

.checkbox-div{

    margin-bottom:20px;
    font-size:17px;
    font-weight: 500;
}

.paid-checkbox-box{
    width: 20px;
    height: 19px;
    /* margin-top: 20px; */

}
.fully-paid-text{
    margin-left:5px;

}

.input-field{
    width:100%;
    padding:12px 10px;
    font-size:16px;
    margin-bottom:20px;
    margin-top:8px;
}

.number-field{
    width:100%;
    padding:3px 0px;
    margin-bottom:16px;
    margin-top:7px;
}
.seleck-field{
    width:100%;
    margin-bottom:20px;
    padding:2px 0px;
    margin-top:8px;
}
.calendar-field{
    width:100%;
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
    padding-bottom:20px;
}

.disableButton{
    background-color: white;
    border:2px solid white;
    font-weight:bold;
    font-size:16px;
}

.spin{
    margin-left:7px;
}

</style>
