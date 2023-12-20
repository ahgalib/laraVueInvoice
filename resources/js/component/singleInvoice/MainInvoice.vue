<template>
    <div class="top-section">
        <div>
            <p><router-link class="breadcrumb" to="/">Document / </router-link> <router-link class="breadcrumb" to="/invoices-list"> Invoice </router-link> / #invoice-2</p>
        </div>
        <div>
            <Button label="Send" severity="info" />
        </div>
    </div>
    <div class="main-page-div">
        <div class="main-section">

            <StaticInfo/>
            <ItemAndPrice/>
        </div>
        <div class="sidebar-section">
            
            <Sidebar/>
        </div>
    </div>
</template>

<script setup>
import StaticInfo from './StaticInfo.vue';
import ItemAndPrice from './PriceDetails.vue';
import Sidebar from './Sidebar.vue';
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
</style>
