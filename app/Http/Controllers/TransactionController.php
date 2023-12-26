<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\DipositRequest;

class TransactionController extends Controller
{


    public function getTransaction($id){
        $transData = Transaction::where('invoice_id',$id)->get();
        if($transData){

            return response([
                'message' => 'success',
                'data'  => $transData
            ]);
        }else{
            return response([
                'message' => 'error'
            ]);
        }
    }


    public function addTransaction(Request $request){


        //create transaction
        $transData = Transaction::create([
            'invoice_id' => $request->invoice_id,
            'paid_amount' => $request->paid_amount,
            'paid_date' => $request->paid_date,
            'payment_method' => $request->payment_method,
            'note' => $request->note,
        ]);

       // return "success";

        //get invoice table's value for total amount and currency
        $invoice_info = Invoice::where('id',$request->invoice_id)->first(['id','invoice_no','user_id','total']);
        // $currency = $invoice_info->currency;
        $total_amount = $invoice_info->total;


        //create invoice history
        // $user_name = $invoice_info->user->first_name.' '.$invoice_info->user->last_name;
        // $invoice_no = $invoice_info->invoice_no;

        // //create invoice history via invoiceHistory trait
        // $invoice_history = $this->createInvoiceHistory($invoice_info->id,$invoice_no.' to '.$user_name.' was paid');

        // $activity = $invoice_history->activity;
        // $date_time = $invoice_history->dateTime;



        //get total paid  amount
        $total_paid_amount= 0;
        $paid_amounts = Transaction::where('invoice_id',$request->invoice_id)->get(['paid_amount','paid_date']);

        if(count($paid_amounts) > 0){
            foreach($paid_amounts as $paid_amount){

                $total_paid_amount += $paid_amount->paid_amount;
            }
        }

        $due_amount = $total_amount - $total_paid_amount;



        $invoice_info->update([
            'paid_amount' => round($total_paid_amount,2),
            'due_amount' => round($due_amount,2),

        ]);


        $deposit = DipositRequest::where('invoice_id',$request->invoice_id)->first(['diposit_amount']);

        //check user has deposit or not
        if($deposit){
            $deposit_amount_value = $deposit->diposit_amount;
            if($due_amount < $deposit_amount_value){
                $diff_deposit_amount = $deposit_amount_value - $due_amount;
                $deposit_amount_value = $deposit_amount_value - $diff_deposit_amount;


                if($deposit_amount_value > 0){

                    DipositRequest::where('invoice_id',$request->invoice_id)->update(['diposit_amount' => $deposit_amount_value]);
                }else{
                    DipositRequest::where('invoice_id',$request->invoice_id)->delete();
                }
            }
           
        }

        if($transData){

            return response([
                'message' => 'success',
                'transData' => $transData,
            ]);
        }
        else{
            return response([
                'message' => 'error',

            ]);
        }

    }
    //

    public function deleteTransaction(Request $request){
        $get_transaction = Transaction::where('id',$request->id)->first();
        $transaction_amount = $get_transaction->paid_amount;

        $get_invoice = Invoice::where('id',$request->invoiceId)->first(['paid_amount','due_amount','total']);
        $invoice_paid_amount = $get_invoice->paid_amount;
        $invoice_due_amont = $get_invoice->due_amount;

        $updated_paid_amount = $invoice_paid_amount - $transaction_amount;
        $updated_due_amount = $invoice_due_amont + $transaction_amount;


        Invoice::where('id',$request->invoiceId)->update([
            'paid_amount' => $updated_paid_amount,
            'due_amount' => $updated_due_amount,

        ]);

        $get_transaction->delete();

        return response()->json([
            'message' => 'success',
            'paid_amount' => number_format($updated_paid_amount,2),
            'due_amount' => number_format($updated_due_amount,2),
            'total' => $get_invoice->total
        ]);
    }
}
