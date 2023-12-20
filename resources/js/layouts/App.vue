<template>
    <div class="invoice-layouts">

        <div class="invoice-sidebar">
            <p class="soft-name">Rechnung </p>
            <p class="dashboard"><i class="pi pi-fw pi-chart-bar"></i> Dashboard</p>
            <p class="document">Document</p>
            <ul class="sidebar-ul">
                <router-link to="/invoices-list" class="invoice-router"> <li class="invoice-list"> <i class="fas fa-dollar-sign"></i>Invoice</li></router-link>
                <li><i class="far fa-lightbulb side-bar-bulp"></i>Proposals</li>
                <li><i class="fas fa-pen"></i> eSing</li>
                <li>  <i class="fas fa-receipt"></i>Invoice</li>
                <li><i class="pi pi-shield"></i> Invoice</li>
            </ul>

        </div>

        <div class="invoice-body">
            <div class="nav-section">
                <div class="nav-invoice-button-section">
                    <h2><i class="pi pi-bars" @click="visible = true"></i> {{ this.$route.name == 'home' ? 'Dashboard' : 'Invoice' }}</h2>

                    <div class="create-invoice-button-div">
                        <router-link to="/create-invoice"><Button type="button" label="Create" icon="pi pi-plus" severity="warning" size="small" /></router-link>
                    </div>

                </div>

                <div>
                    AH Limited <Avatar label="A" class="ml-5" size="large" shape="circle" />
                </div>
            </div>

            <router-view/>
        </div>


    </div>
</template>

<script setup>
import { ref, onMounted, watch } from "vue";
import Avatar from 'primevue/avatar';
import '../../../node_modules/@fortawesome/fontawesome-free/css/all.min.css';


import { useRoute } from 'vue-router';
const visible = ref(false);

</script>

<style>


.nav-invoice-button-section{
    display: flex;
}
.create-invoice-button-div{
    margin-left:40px;
    margin-top:20px;
}

.invoice-layouts{
    display: flex;

}

.invoice-body{
    width:85%;
    padding-left:20px;
}

.invoice-sidebar{
    width:15%;
    background-color: white;
    height:100vh;
    position: sticky;
    top: 0;
    overflow-y: auto;
}


.sidebar-ul li:hover{
    background-color:#efeded;
    font-weight:bold;


}

.fa-dollar-sign {
    color:rgb(11, 176, 213);

}

.side-bar-bulp{
    color:rgb(38, 110, 254);
}

.nav-section{
    display:flex;
    justify-content: space-between;
}

.pi-bars{
    font-size:20px;
    margin-right: 30px;
}

.nav-section h2{
    font-size:30px;
}


.sidebar-ul {
        list-style: none;
        padding: 0;
        margin: 0;
}

.sidebar-ul li {
    display: flex;
    align-items: center;
    padding: 10px;
}

.sidebar-ul li i {
    margin-right: 20px;
}

.invoice-router {
    text-decoration: none;
    color: inherit;
}

.soft-name{
    font-size:27px;
    font-weight: 700;
    font-family: Lato, sans-serif;


}

.dashboard{
    font-weight: bold;
}

.pi-fw{
    font-weight: bold;
    margin-right:10px;
    padding-left:10px;
}

.document{
    padding-left:10px;
    font-weight: bold;
    color:#9ca3af;
    margin-top:30px;
}
</style>
