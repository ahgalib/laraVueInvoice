<template>
    <div class="item-price-div">
        <h3>Table and price section</h3>
        <table>
            <thead>
            <tr>
                <th class="item-th">Item</th>
                <th class="quantity-th">Quantity</th>
                <th class="price-th">Price</th>
                <th class="total-info">Amount</th>
            </tr>
            </thead>
            <tbody>
            <tr class="invoice-tr" v-for="invoiceItem in invoiceData.invoice_items" :key="invoiceItem.id">
                <td>{{ invoiceItem.service_title }}</td>
                <td class="quan-td">{{ invoiceItem.quantity }}</td>
                <td class="price-td"> {{ invoiceItem.price ? invoiceItem.price.toLocaleString("en-US") : ''  }} TK. </td>

                <td class="total-info">{{ invoiceItem.total_price ? invoiceItem.total_price.toLocaleString("en-US") : ''  }} TK.</td>
            </tr>
            </tbody>
        </table>
        <Divider/>

        <div class="all-amount-div">
            <div class="heading-price">
                <div class="subtotal-div">
                    <p>subTatal</p>
                    <p>{{ invoiceData.tax_title }} ({{invoiceData.tax_percentage}}%)</p>
                    <p>{{ invoiceData.second_tax_title }} ({{invoiceData.second_tax_percentage}}%)</p>

                </div>
                <div class="price-div">
                    <p>{{ invoiceData.subtotal ? invoiceData.subtotal.toLocaleString("en-US") : ''  }} TK.</p>
                    <p>{{ invoiceData.tax_amount ?  invoiceData.tax_amount.toLocaleString("en-US") : '' }} TK.</p>
                    <p class="visit-tax-amount">{{ invoiceData.second_tax_amount ?invoiceData.second_tax_amount.toLocaleString("en-US") : '' }} TK.</p>

                </div>
            </div>

            <div class="divider"></div>

            <div class="heading-price">
                <div class="subtotal-div">
                    <p>Total</p>
                </div>
                <div class="price-div">
                    <p>{{ totalAmount ? totalAmount.toLocaleString("en-US") : '' }} TK.</p>
                </div>
            </div>

            <div class="divider"></div>

            <div class="heading-price" v-for="item in transactionData" :key="item.id">
                <div class="subtotal-div">
                    <p>Paid on {{ item.paid_date }}</p>
                </div>
                <div class="price-div">
                    <p>{{ item.paid_amount ? item.paid_amount.toLocaleString("en-US") : ''  }} TK.</p>
                </div>
            </div>

            <div class="divider"></div>

            <div class="heading-price">
                <div class="subtotal-div">
                    <p>Amount Due</p>
                </div>
                <div class="price-div">
                    <p>{{ dueAmount ? dueAmount.toLocaleString("en-US") : '0' }} TK.</p>
                </div>
            </div>

            <div class="bottom-main-amount" v-if="isInvoiceExist">
                <p>Deposit due | {{ depositDuDate }}</p>
                <p class="main-amount-show">{{ depositAmount ? depositAmount.toLocaleString("en-US") : '0'  }} TK.</p>
            </div>

            <div class="bottom-main-amount" v-if="!isInvoiceExist">
                <p>Amount due | {{ dueDate }}</p>
                <p class="main-amount-show">{{ dueAmount ? dueAmount.toLocaleString("en-US") : '0' }} TK.</p>
            </div>

        </div>


    </div>

</template>

<script setup>
import Divider from 'primevue/divider';

import {useInvoiceStore} from '../../store/Invoice';
import { storeToRefs } from "pinia";

const store = useInvoiceStore();
const {transactionData, dueAmount, totalPaidAmount, totalAmount, isInvoiceExist, depositAmount, depositDuDate, dueDate} = storeToRefs(store);


const props = defineProps({
    invoiceData: Object,
})
</script>

<style  scoped>
.item-price-div{
    padding:20px 25px;
}
table {
      border-collapse: collapse;
      width: 100%;
      margin-top:30px;
    }

    th {
      background-color: transparent;
      padding: 6px;

      border-bottom: 1px solid #ddd;
      border-top: 1px solid #ddd;
    }

    .item-th{
        text-align:left;
    }


    tbody {
      background-color: white;
    }


    td {
      padding: 10px 0px;
      border-top: 1px solid #ddd; /* Add a bottom border for separation */
    }

    .quan-td{
        text-align:center;
    }

    .price-th{
        text-align: right;
    }
    .price-td{
        text-align: right;
    }

    .total-info{
        text-align:right;
    }

    .all-amount-div{
        width:50%;
        float: right;
        font-size:15px;

    }
    .heading-price{
        display: flex;
        justify-content: space-between;
    }
    .subtotal-div{
        width:50%;
        text-align:left;
    }

    .visit-tax-amount{
        margin-top:20px;
    }

    .price-div{
        text-align:right;
    }

    .divider{
        height:.5px;
        background-color: rgb(214, 210, 210);
    }

    .bottom-main-amount{
        width:80%;
        background-color: #F0F3F4;
        float:right;
        padding:0px 10px;
        margin:30px 0px;
    }

    .main-amount-show{
        text-align:right;
        font-size:23px;
        font-weight: 400;
    }
</style>
