
<template>
    <div class="first-card">
        <div class="docuemnt-card">
            <Card>

                <template #title> Create Document </template>
                <template #content>
                    <div class="button-div">

                            <Button plain text raised class="create-invoice-button"><router-link to="/create-invoice" class="link-text"> <i class="fas fa-file-invoice"></i> Create Invoice </router-link></Button>


                        <Button plain text raised class="create-proposals-button">  <i class="fas fa-lightbulb proposals-icon"></i> Create Proposals </Button>
                    </div>


                </template>
            </Card>
            <div class="card-under-first-card">
                <div class="payment-card">
                    <Card>
                        <template #title> Total Payments Received </template>
                        <template #content>
                            <p class="m-0">
                                    <span class="big-amount">2,899.00 Lt</span>
                                </p>
                                <div>
                                    <li class="unpaid">Overdue <span class="amount-span">15 Invoices</span></li>
                                </div>
                        </template>
                    </Card>
                </div>

                <div class="month-card">
                    <Card>
                        <template #title> December Invoice Amount </template>
                        <template #content>
                            <div class="month-invoice">

                                <p class="m-0">
                                    <span class="big-amount">2,899.00 Lt</span>
                                    <span class="small-amount">
                                        <i class="fas fa-chart-line"></i>
                                        <i class="fas fa-arrow-down"></i>
                                        -70.03%
                                    </span>
                                </p>
                            </div>
                            <div class="amount-li">
                                <li class="paid">paid <span class="amount-span">TK9.00</span></li>
                                <li class="unpaid">unpaid <span class="amount-span">TK9.00</span></li>
                            </div>

                        </template>
                    </Card>
                </div>
            </div>

            <div class="">
                <Card>
                    <template #title> Simple Card </template>
                    <template #content>
                        <Chart type="line" :data="chartData" :options="chartOptions" class="h-30rem" />
                    </template>
                </Card>
            </div>
        </div>

        <div class="upgrade-card">
            <Card class="upgrade-card-1">
                <template #title> Update Document</template>
                <template #content>
                    <p class="m-0">
                        Send as many documents as you want by upgrading your plan.
                    </p>
                    <Button label="View Plan    " severity="success" outlined />
                </template>
            </Card>
            <Card>
                <template #title> Recent Activity </template>
                <template #content>
                    <p class="m-0">
                        No data
                    </p>
                </template>
            </Card>
        </div>
    </div>

</template>

<script setup>
import { ref, onMounted } from "vue";
import '../../../node_modules/@fortawesome/fontawesome-free/css/all.min.css';

import Card from 'primevue/card';
import Chart from 'primevue/chart';




onMounted(() => {
    chartData.value = setChartData();
    chartOptions.value = setChartOptions();
});

const chartData = ref();
const chartOptions = ref();

const setChartData = () => {
    const documentStyle = getComputedStyle(document.documentElement);

    return {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
        datasets: [
            {
                label: 'First Dataset',
                data: [65, 59, 80, 81, 56, 55, 40],
                fill: false,
                borderColor: documentStyle.getPropertyValue('--blue-500'),
                tension: 0.4
            },
            {
                label: 'Second Dataset',
                data: [28, 48, 40, 19, 86, 27, 90],
                fill: false,
                borderColor: documentStyle.getPropertyValue('--pink-500'),
                tension: 0.4
            }
        ]
    };
};
const setChartOptions = () => {
    const documentStyle = getComputedStyle(document.documentElement);
    const textColor = documentStyle.getPropertyValue('--text-color');
    const textColorSecondary = documentStyle.getPropertyValue('--text-color-secondary');
    const surfaceBorder = documentStyle.getPropertyValue('--surface-border');

    return {
        maintainAspectRatio: false,
        aspectRatio: 0.6,
        plugins: {
            legend: {
                labels: {
                    color: textColor
                }
            }
        },
        scales: {
            x: {
                ticks: {
                    color: textColorSecondary
                },
                grid: {
                    color: surfaceBorder
                }
            },
            y: {
                ticks: {
                    color: textColorSecondary
                },
                grid: {
                    color: surfaceBorder
                }
            }
        }
    };
}
</script>


<style>
.side-bar{
    width : 20%;

}
.sidebar-ul{
    margin-left:-40px;
}
.sidebar-ul li{
    list-style: none;

    font-size:16px;

    padding: 10px 10px;
}

.sidebar-ul li i{
    margin-right:20px;
    font-weight:bold;
    font-size:18px;
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

.first-card{
    display: flex;
    justify-content: space-between;
}

.docuemnt-card{
    width:70%;
}

.upgrade-card{
    width:28%;
}
.upgrade-card-1{
    margin-bottom:20px;
}

.card-under-first-card{
    display: flex;
    justify-content: space-between;
    margin:30px 0px;
}

.payment-card{
    width:47%;
}

.month-card{
    width:47%;
}

.create-invoice-button{
    font-size:18px;
    font-weight: 500;
    width : 48%;
}

.link-text{
    text-decoration: none;

}

.button-div{
    display: flex;
    justify-content: space-between;
}

.fa-file-invoice{
    color:rgba(29, 218, 221, 0.869);
    font-size: 28px;
    margin: 10px;
}

.create-proposals-button{
    font-size:18px;
    font-weight: 500;
    width : 48%;
}

.proposals-icon{
    color:rgba(29, 35, 221, 0.869);
    font-size: 28px;
    margin: 10px;
}

.big-amount{
    font-size:22px;
    font-weight: 600;
    margin-right:10px;
}

.small-amount{
    color:red;
}

.amount-li{
    display: flex;

}
.paid{
    color:green;
    margin-right:30px;
}
.unpaid{
    color:red
}
.amount-span{
    color:black;
    font-weight: 500;
}

</style>
