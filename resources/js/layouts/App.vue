<template>
    <div>
        <!-- <router-link :to="{name: 'home'}">Home</router-link>
        <router-link :to="{name : 'about'}">About</router-link> -->
        <div class="card flex">
        <Sidebar v-model:visible="visible" header="GalliPi" class="side-bar">
            <p>Document</p>
            <ul class="sidebar-ul">
                <li> <i class="fas fa-dollar-sign"></i>Invoice</li>
                <li><i class="far fa-lightbulb side-bar-bulp"></i>Proposals</li>
                <li><i class="fas fa-pen"></i> eSing</li>
                <li>  <i class="fas fa-receipt"></i>Invoice</li>
                <li><i class="pi pi-shield"></i> Invoice</li>
            </ul>
        </Sidebar>

        <div class="nav-section">
            <h2><i class="pi pi-bars" @click="visible = true"></i> {{ this.$route.name == 'home' ? 'Dashboard' : 'Invoice' }}</h2>
            <div>
                AH Limited <Avatar label="A" class="ml-5" size="large" shape="circle" />
            </div>
        </div>

    </div>

        <router-view/>
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from "vue";
import Avatar from 'primevue/avatar';
import '../../../node_modules/@fortawesome/fontawesome-free/css/all.min.css';


import { useRoute } from 'vue-router';
const visible = ref(false);

</script>
