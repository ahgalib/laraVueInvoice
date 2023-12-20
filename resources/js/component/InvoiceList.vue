<template>

    <div class="">
        <Dropdown v-model="selectedCity" :options="cities" optionLabel="" placeholder="Filter by customer" class="w-full custom-margin" :style="{ width: '20rem' }" />

        <Dropdown v-model="selectedCity" :options="cities" optionLabel="Inbox" placeholder="Inbox" class="w-full " :style="{ width: '10rem' }" />
    </div>

    <div v-if="loading === false">
        <table>
            <thead>
            <tr>
                <th>Invoice</th>
                <th>Status</th>
                <th>Date</th>
                <th class="last-col">Amount</th>
            </tr>
            </thead>
            <tbody>
            <tr class="invoice-tr" v-for="invoice in invoices" :key="invoice.id">

                <td>
                    <router-link :to="{name:'single-invoice',params:{uid:invoice.invoice_uid}}" class="router-link">
                    <p class="invoice-user">{{ invoice.user.name }}</p>
                    <p class="invoice-no"> #{{ invoice.invoice_no }}</p>
                </router-link>
                </td>
                <td> <Badge value="" severity="success"></Badge> Saved</td>
                <td>
                    <p>
                        <Badge value="issued" severity="success" class="success-bagde"></Badge>
                        {{ formatDueDate(invoice.issue_date)}}</p>
                    <p>
                        <Badge value="due" severity="warning" class="warning-bagde"></Badge>{{formatDueDate(invoice.due_date)}}
                    </p>
                </td>
                <td class="last-col">TK.{{ invoice.total.toLocaleString("en-US") }}</td>

            </tr>




            </tbody>
        </table>
    </div>

    <div class="card" v-if="loading">
        <DataTable :value="products">
            <Column field="code" header="Invoice">
                <template #body>
                    <Skeleton></Skeleton>
                </template>
            </Column>
            <Column field="name" header="Status">
                <template #body>
                    <Skeleton></Skeleton>
                </template>
            </Column>
            <Column field="category" header="Date" class="skeleton-th">
                <template #body>
                    <Skeleton></Skeleton>
                </template>
            </Column>
            <Column field="quantity" header="Amount">
                <template #body>
                    <Skeleton></Skeleton>
                </template>
            </Column>
        </DataTable>
    </div>


</template>

<script setup>
import Dropdown from 'primevue/dropdown';
import axios from 'axios';
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import {onMounted, ref} from 'vue';
import Badge from 'primevue/badge';

const invoices = ref([]);
const loading = ref(false);
const products = ref(new Array(4));
import Skeleton from 'primevue/skeleton';
const fetchAllInvoice = async() => {
    let response = await axios.get('http://127.0.0.1:8000/api/invoice-list');
    invoices.value = response.data

    console.log(invoices.value);
    console.log(response);

    loading.value = false;
}

const formatDueDate = (date) => {
      const options = {day: 'numeric', month: 'short', year: 'numeric',  };
      return new Date(date).toLocaleDateString('en-US', options);
}

onMounted(()=>{
    loading.value = true;
    fetchAllInvoice();
})
</script>

<style scoped>
.custom-margin{
    margin-right:40px;
}

table {
      border-collapse: collapse;
      width: 100%;
      margin-top:30px;
    }

    th {
      background-color: transparent;
      padding: 14px;
      text-align: left;

    }


    tbody {
      background-color: white;
    }

    .invoice-tr:hover {
      background-color: #f5f5f5; /* Add your preferred hover background color */
      cursor:pointer;
    }

    td {
      padding: 4px 14px;
      border-bottom: 1px solid #ddd; /* Add a bottom border for separation */
    }
   .loading{
        width:100%;
        height:150vh;
        background-color: black;
   }

   .warning-bagde{
    margin-right:24px;
    width:30px;
    font-size:10px;
    height:20px;

   }

   .success-bagde{
    width:42px;
    font-size:10px;
    height:20px;
    padding:0px !important;
    margin-right:8px;
   }

   .invoice-no{
    font-size:14px;
    text-decoration: none;
        color:black;
   }
    .invoice-user{
        font-weight: bold;
        text-decoration: none;
        color:black;

    }
    .route-link{
        text-decoration: none;
        color:black;
    }
</style>
