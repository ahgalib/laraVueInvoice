<template>

    <div class="main-sidebar-div">

        <table>
            <tbody>
                <tr class="total-row">
                    <td class="text-dark bold-text">Total</td>
                    <td class="text-end">4543 TK.</td>
                </tr>

                <tr>
                    <td class="text-dark bold-text">Paid</td>
                    <td class="text-end totalPaid">454 TK.</td>
                </tr>
            </tbody>
        </table>


        <table class="mb-2">
            <tbody class="font-bold">
                <tr>
                    <div>

                        <td class="text-dark ">
                            <div>
                                Deposit Request (
                                <span><span></span><span></span><span></span></span>
                                )
                            </div>
                        </td>
                        <td class="text-end"> <a href="javascript:void(0)" role="button"
                                class="text-warning editDepositButton"
                                data-bs-toggle="modal"
                                data-bs-target="#edit-deposit-request" >Edit</a>
                        </td>
                    </div>

                    <div>
                        <td class="text-dark">
                            <a href="javascript:void(0)"
                                >Request a deposit</a>
                        </td>
                    </div>
                </tr>

                <tr>
                    <td class="text-dark">
                        <a href="javascript:void(0)" role="button" class="text-warning text-decoration-underline" @click="openTransactionModal" data-bs-toggle="modal"
                            data-bs-target="#view-transaction">
                            View Transactions
                        </a>
                    </td>
                </tr>


                <tr>
                    <td class="text-dark py-2">
                        <a href="#" role="button"
                            class="text-warning text-decoration-underline" data-bs-toggle="modal"
                            data-bs-target="#paid-modal">Mark Paid</a>
                    </td>
                </tr>

            </tbody>
        </table>

    </div>

</template>

<script setup>

</script>

<style scoped>
.main-sidebar-div{
    background-color: white;
    padding:30px 10px;
}


table{
    width:100%;
}

.text-dark {
    color: #333; /* Adjust the color as needed */
    padding:10px 0px;
}

.text-end {
    text-align: right;

}
.bold-text{
    font-weight: bold;
}
</style>
