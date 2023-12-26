<template>
    <div class="top-section">
        <div>
            <p><router-link class="breadcrumb" to="/">Document / </router-link> <router-link class="breadcrumb" to="/invoices-list"> Invoice </router-link> / #{{ singleInvoiceData.invoice_no }}</p>

        </div>
        <div>
            <Button label="Send" severity="info" />
        </div>
    </div>

    <div class="loading-div" v-if="loading == true">
        <i class="pi pi-spin pi-cog"></i>
         <p class="loading-p">Loading...</p>
    </div>
    <div class="main-page-div" v-if="loading == false">
        <div class="main-section">


            <StaticInfo :userData="userData" :invoiceData="singleInvoiceData"/>
            <ItemAndPrice :invoiceData="singleInvoiceData"/>
        </div>
        <div class="sidebar-section">

            <Sidebar/>
        </div>
    </div>
</template>

<script setup>
import StaticInfo from './StaticInfo.vue';

import Sidebar from './Sidebar.vue';
import ItemAndPrice from './PriceDetails.vue';

import {useInvoiceStore} from '../../store/Invoice'
import {onMounted, ref, reactive} from 'vue';
import {storeToRefs} from 'pinia';
import { useRoute } from 'vue-router';

const store = useInvoiceStore();
const {getSingleInvoice} = store;
const {userData, singleInvoiceData, loading} =storeToRefs(store);

const route = useRoute();
const routeId = ref('');

routeId.value = route.params.uid;

onMounted(async ()=>{
    await getSingleInvoice(routeId.value)
})

</script>

<style  scoped>
.main-page-div{
    display: flex;
    justify-content: space-between;
}

.main-section{
    width:70%;
    background-color: white;
    margin-bottom:10px;

}

.sidebar-section{
    width:28%;


}

.top-section{
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}
.breadcrumb{
    text-decoration: none;
}

.loading-div{
    position:relative;
}
.pi-cog{
    font-size: 8rem;

    position:fixed;
    top:40%;
    left:50%;
}
.loading-p{
    top:60%;
    left:50%;
    position:fixed;
    font-size: 1.6rem;
    font-weight: bold;
}
</style>
