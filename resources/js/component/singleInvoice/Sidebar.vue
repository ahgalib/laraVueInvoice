<template>

    <div class="main-sidebar-div">

        <table>
            <tbody>
                <tr class="total-row">
                    <td class="text-dark bold-text">Total</td>
                    <td class="text-end">{{totalAmount ? totalAmount.toLocaleString("en-US") : '' }} TK</td>
                </tr>

                <tr>
                    <td class="text-dark bold-text">Paid</td>
                    <td class="text-end totalPaid">{{ totalPaidAmount ? totalPaidAmount.toLocaleString("en-US") : '0' }} TK.</td>
                </tr>
            </tbody>
        </table>


        <table class="sidebar-modal">
            <tbody class="font-bold">
                <tr v-if="totalPaidAmount < totalAmount">
                    <div v-if="isInvoiceExist">

                        <td class="modal-name text-dark">
                            <div>
                                Deposit Request (
                                <span>TK.{{ depositAmount ? depositAmount.toLocaleString("en-US") : '' }}</span>
                                )
                            </div>
                        </td>
                        <td class="text-end"> <a href="javascript:void(0)" role="button"
                            class="modal-name" @click="depositModal">Edit</a>
                        </td>

                        <Dialog v-model:visible="createDeposit" modal header="Edit deposit" :style="{ width: '36rem' }" :breakpoints="{ '1199px': '75vw', '575px': '90vw' }" >
                            <EditDepositModal @close="closeModal" @closeDepositSuccess="closeDepoModal"/>
                        </Dialog>
                    </div>

                    <div v-if="!isInvoiceExist">
                        <td class="text-dark">
                            <a href="javascript:void(0)" class="modal-name" @click="depositModal">Request a deposit</a>
                        </td>
                        <Dialog v-model:visible="createDeposit" modal header="Request a deposit" :style="{ width: '36rem' }" :breakpoints="{ '1199px': '75vw', '575px': '90vw' }" >
                            <DepositModal @close="closeModal" @closeDepositSuccess="closeDepoModal"/>
                        </Dialog>
                    </div>
                </tr>

                <tr v-if="totalPaidAmount >= totalAmount">
                    <td class="text-dark">
                        <a href="javascript:void(0)" role="button" class="demo-modal-name">
                            Request a deposit
                        </a>
                    </td>
                </tr>


                <tr>
                    <td class="text-dark">
                        <a href="javascript:void(0)" role="button" class="modal-name" @click="transactionModal">
                            View Transactions
                        </a>
                    </td>

                    <Dialog v-model:visible="visible" modal header="View Transactions" :style="{ width: '36rem' }" :breakpoints="{ '1199px': '75vw', '575px': '90vw' }" >
                        <TransactionModal  @close="closeModal" @paidModal="markPaidModal"/>
                    </Dialog>
                </tr>


                <tr v-if="totalPaidAmount < totalAmount">
                    <td class="text-dark">
                        <a href="#" class="modal-name" @click="markPaidModal">Mark Paid</a>
                        <Dialog v-model:visible="markPaid" modal header="Mark Paid" :style="{ width: '36rem' }" :breakpoints="{ '1199px': '75vw', '575px': '90vw' }" >
                            <MarkPaidModal @close="closePaidModal" @successClose="closeSuccessModal"/>
                    </Dialog>
                    </td>
                </tr>

            </tbody>
        </table>

    </div>
    <Toast/>
</template>

<script setup>
import { ref, reactive, onMounted, toRefs, watch, computed } from "vue";
import Dialog from 'primevue/dialog';
import DepositModal from './modals/DepositModal.vue'
import EditDepositModal from './modals/EditDepositModal.vue'
import TransactionModal from './modals/TransactionModal.vue'

import MarkPaidModal from './modals/MarkPaidModal.vue'

import Toast from 'primevue/toast';
import { useToast } from 'primevue/usetoast';

const toast = useToast();

import {useInvoiceStore} from '../../store/Invoice';
import { storeToRefs } from "pinia";

const store = useInvoiceStore();
const {totalAmount, dueAmount, totalPaidAmount, isInvoiceExist, depositAmount} = storeToRefs(store);


const visible = ref(false);
const markPaid = ref(false);
const createDeposit = ref(false);
const editDeposit = ref(false);


const depositModal = () => {
    createDeposit.value = true;
}


const editDepositModal = () => {
    editDeposit.value = true;
}


const transactionModal = () => {
    visible.value = true;
}

const markPaidModal = () => {
    markPaid.value = true;
}

const closeModal = () => {
    visible.value = false;
    createDeposit.value = false;
    editDeposit.value = false;
}

const closePaidModal = () => {
    markPaid.value = false;

}

const dynamicSuccessAlert = (modalValue, severity, message) => {
    modalValue.value = false;
    toast.add({ severity: severity, detail: message, life: 3000 });
}

const closeSuccessModal = () => {
    dynamicSuccessAlert(markPaid, 'success',  'Payment Successfully Recorded');
    markPaid.value = false;
}

const closeDepoModal = () => {
    dynamicSuccessAlert(createDeposit, 'success',  'Invoice Successfully Updated')
}
</script>



<style scoped>
.main-sidebar-div{
    background-color: white;
    padding:22px 10px;
}


table{
    width:100%;
}

.text-dark {
    color: #333; /* Adjust the color as needed */
    padding:10px 0px;
}
.sidebar-modal{
    margin-top:15px;
}

.text-end {
    text-align: right;

}
.bold-text{
    font-weight: bold;
}

.modal-name{
    color:#008EA0
}
.demo-modal-name{
    color:#111415
}
</style>
