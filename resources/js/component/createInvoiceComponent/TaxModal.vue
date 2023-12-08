<template>
    <div class="tax-header">
        <div>

            <p class="tax-text">Tax</p>
        </div>
        <div>
            <SelectButton v-model="value" :options="options" aria-labelledby="basic"/>
        </div>
    </div>
    <Divider/>

    <div class="first-tax-div">
        <span class="p-float-label">
            <InputText id="" v-model="taxs.firstTaxCode" class="input-field"/>
            <label for="invoiceNumber">Tax Code</label>
        </span>
        <span class="p-float-label">

            <InputNumber v-model="taxs.firstTaxRate" inputId="percent" prefix="%"/>
            <label for="percent" class="font-bold block mb-2"> Rate </label>
        </span>
    </div>

    <Divider/>

    <div class="card flex justify-content-center">
        <InputSwitch v-model="checked" />
    </div>

    <div class="second-tax-div" v-if="checked">
        <span class="p-float-label">
            <InputText id="" v-model="taxs.secondTaxCode" class="input-field"/>
            <label for="invoiceNumber">Second Tax Code</label>
        </span>
        <span class="p-float-label">
            <input type="number" min=0 max=100>
            <InputNumber v-model="taxs.secondTaxRate" inputId="percent" prefix="%" :min="0" :max="100"/>
            <label for="percent" class="font-bold block mb-2"> Second Tax Rate </label>
        </span>
    </div>
    <Divider/>

    <div class="footer">

        <button class="close-button">Close</button>
        <button class="save-button" @click="saveTax">Save</button>
    </div>
</template>

<script setup>

import { ref, reactive, watch } from 'vue';
import Dropdown from 'primevue/dropdown';
import Divider from 'primevue/divider';

import SelectButton from 'primevue/selectbutton';
import InputSwitch from 'primevue/inputswitch';
import InputText from 'primevue/inputtext';
import InputNumber from 'primevue/inputnumber';
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';


const emit = defineEmits('taxEmit')
const toast = useToast();
const value = ref('Off');
const options = ref(['Inclusive', 'Exclusive']);
const checked = ref(false);

const taxs = reactive({
    firstTaxCode  : 'Tax',
    firstTaxRate  : 0,
    secondTaxCode : 'Second Tax',
    secondTaxRate : 0,
})



// Watcher to check tax rate
watch(() => [taxs.firstTaxRate, taxs.secondTaxRate], ([firstTaxRate, secondTaxRate]) => {
    if (firstTaxRate > 100) {
        taxs.firstTaxRate = 0;
        toast.add({ severity: 'error', detail: 'Tax Rate cannot bigger then 100 ', life: 3000 });
    } else if (secondTaxRate > 100) {
        taxs.secondTaxRate = 0;
    }
});


const saveTax = () => {
    if(taxs.firstTaxCode == '' || taxs.secondTaxCode == ''){
        toast.add({ severity: 'error', detail: 'Tax Code is required ', life: 3000 });
    }
    else if(taxs.firstTaxRate >= 100  || taxs.secondTaxRate >= 100){

        toast.add({ severity: 'error', detail: 'Tax Rate cannot bigger then 100 ', life: 3000 });
    }
    else{

        emit('taxEmit',taxs);
    }

}

</script>

<style scoped>
.tax-header{
    display: flex;
    justify-content: space-between;
    height: 40px;

}
.tax-text{
    font-size:20px;
    font-weight: 500;
}
.footer button{
    float:right;
    background-color: white;
    border:none;
    font-size:16px;
    margin:0px 5px;
    padding:5px 8px;
}

.close-button:hover{
    background-color: rgb(221, 217, 217);

}

.second-tax-div{
    margin-bottom: 40px;
    display: flex;
    justify-content: space-between;
    margin-top:30px;
}

.first-tax-div{
    display: flex;
    justify-content: space-between;
    margin-top:30px;
}
</style>
