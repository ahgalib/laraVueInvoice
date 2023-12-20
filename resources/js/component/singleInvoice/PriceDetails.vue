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
            <tr class="invoice-tr">
                <td>Shuvro Geche Bone sdfsdf sdf sd</td>
                <td class="quan-td">5</td>
                <td class="price-td"> 56495 TK. </td>

                <td class="total-info">TK.54344</td>
            </tr>
            <tr class="invoice-tr">
                <td>Book</td>
                <td class="quan-td">5</td>
                <td class="price-td"> 56d45  TK.</td>

                <td class="total-info">TK.54354</td>
            </tr>

            </tbody>
        </table>
        <Divider/>

        <div class="all-amount-div">
            <div class="heading-price">
                <div class="subtotal-div">
                    <p>subTatal</p>
                    <p>TAX included(70%)</p>
                    <p>visiting tax included(60%)</p>

                </div>
                <div class="price-div">
                    <p>4564895 TK.</p>
                    <p>5564895 TK.</p>
                    <p class="visit-tax-amount">9564895 TK.</p>

                </div>
            </div>

            <div class="divider"></div>

            <div class="heading-price">
                <div class="subtotal-div">
                    <p>Tatal</p>
                </div>
                <div class="price-div">
                    <p>4564895 TK.</p>
                </div>
            </div>

            <div class="divider"></div>

            <div class="heading-price">
                <div class="subtotal-div">
                    <p>Paid on 20 Dec 2023</p>
                </div>
                <div class="price-div">
                    <p>4564895 TK.</p>
                </div>
            </div>

            <div class="divider"></div>

            <div class="heading-price">
                <div class="subtotal-div">
                    <p>Amount Due</p>
                </div>
                <div class="price-div">
                    <p>764895 TK.</p>
                </div>
            </div>

            <div class="bottom-main-amount">
                <p>Deposit due | 21 Dec 2023</p>
                <p class="main-amount-show">45643 TK.</p>
            </div>

        </div>


    </div>

</template>

<script setup>
import Divider from 'primevue/divider';
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
