<template>
    <div class="main-card">
        <div class="header-info">
            <p class="focus-text">Debuggers Studio</p>
            <div class="address-info">
                <p class="focus-text">Invoice</p>
                <p class="focus-text">Debuggers Studio</p>
                <p>Sector 3, Uttara </p>
                <p>Dhanmondi 12</p>
                <p>Gulshan-3</p>
                <p>Dhaka</p>
                <p>Bangladesh</p>
            </div>
        </div>

        <div class="billar-info">
            <div class="customer-info">
                <p>BILL TO</p>
                <p>Galib</p>
                <p>Tax Reg No. : 3534535</p>
                <p>asadullahalgalib783@gmail.com</p>
            </div>
            <div class="invoice-info">
                <div class="th-name">
                    <p>Invoice #</p>
                    <p>Date</p>
                    <p>Due date</p>
                </div>
                <div class="td-name">
                    <p>Invoice-12</p>
                    <p>16 Oct 2023</p>
                    <p>23 Oct 2023</p>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>

</script>

<style  scoped>
.main-card{
    color:black;
    background-color: white;

}

.header-info{
    display: flex;
    justify-content: space-between;
    padding:15px 30px;
}

.focus-text{
    font-size:19px;
    font-weight: 600;
}
.address-info{
    text-align:right
}

.billar-info{
    display: flex;
    justify-content: space-between;
    background-color: #F0F3F4;
    padding:15px 30px;

}

.customer-info{
    width:60%;

}

.invoice-info{
    display: flex;
    justify-content: space-between;
    width:50%;

}

.th-name{
    width:50%;
    font-weight: bold;

}

.td-name{
    width:50%;

}
</style>
