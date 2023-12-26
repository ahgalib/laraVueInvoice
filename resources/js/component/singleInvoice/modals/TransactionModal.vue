<template>
    <div>
        <table>
            <thead>
            <tr>
                <th class="item-th">DATE</th>
                <th class="note-th">NOTE</th>
                <th class="total-info">AMOUNT</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in transactionData" :key="item.id">
                <td class="item-th">{{ item.paid_date  }}</td>
                <td class="note-th">{{ item.note }}</td>
                <td class="amount-td"> {{ item.paid_amount ? item.paid_amount.toLocaleString("en-US") : '0'}} TK.

                    <i class="pi pi-trash" style="color: red" @click="deleteItem(item.id)"></i>

                </td>
                <td></td>
            </tr>
            <tr v-if="transactionData.length <= 0">
                <td colspan = "3" class="no-data-td">No data</td>

            </tr>
            </tbody>
        </table>

        <div class="button-div">
            <Button label="Cancel" severity="secondary" text  @click="$emit('close')"/>
            <Button label="Add Payment" severity="success" text @click="openPaidModal" v-if="totalAmount > totalPaidAmount"/>
        </div>
    </div>
</template>

<script setup>
import { ref, reactive, onMounted, watch, } from "vue";

import {useInvoiceStore} from '../../../store/Invoice';
import { storeToRefs } from "pinia";
import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';

const toast = useToast();

const emit = defineEmits('paidModal');



const store = useInvoiceStore();
const {totalAmount, totalPaidAmount, transactionData, successDeleteTrans} = storeToRefs(store);



const {getTransaction, deleteTransaction} = store;

const deleteItem = (id) => {
    deleteTransaction(id);
    if(successDeleteTrans){
        toast.add({ severity: 'error', detail: 'Transaction Has Been Deleted Successfully', life: 3000 });
        successDeleteTrans.value = false
    }
}

const openPaidModal = () => {
    emit('paidModal');
}

onMounted(async ()=>{
    await getTransaction()
})
</script>



<style scoped>
table{
    width:100%;

}

th {
    background-color: transparent;
    padding: 25px 5px;
    border-bottom: 1px solid #ddd;

}

.item-th{
    text-align:left;
}
.note-th{
    text-align: left;
}

td {
    padding: 20px 0px;
    border-bottom: 1px solid #ddd; /* Add a bottom border for separation */
    text-align: center;
}

.amount-td{
    display:flex;
    justify-content: space-around;

}

.button-div{
    float:right;
}


</style>
