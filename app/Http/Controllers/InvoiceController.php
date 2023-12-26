<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Invoice;
use App\Models\InvoieItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DipositRequest;

class InvoiceController extends Controller
{

    public function invoiceList(){
        $invoices = Invoice::with('user')->orderBy('id', 'desc')->get();

        return $invoices;
    }

    public function storeInvoice(Request $request){

        $invoice_uid = Str::random(15);
        $data = [
            'invoice_no'            => $request->invoice_no,
            'invoice_uid'           => $invoice_uid,
            'user_id'               => $request->user_id,
            'purchase_order'        => $request->purchase_order,
            'issue_date'            => $request->issue_date,
            'due_date'              => $request->due_date,

            'subtotal'              => $request->subtotal, //
            'total'                 => $request->total, //
            'paid_amount'           => 0,
            'due_amount'            => $request->total, //

            'tax_title'             => $request->tax_title,
            'tax_percentage'        => $request->tax_percentage, //
            'tax_amount'            => $request->tax_amount, //
            'second_tax_title'      => $request->second_tax_title,
            'second_tax_percentage' => $request->second_tax_percentage, //
            'second_tax_amount'     => $request->second_tax_amount, //
        ];

        // Create New Invoice
        $invoice = Invoice::create($data);

        if($invoice){
           // $this->storeInvoiceItem($invoice->id,$request);
            return response([
                'message' => 'success',
                'uid' => $invoice_uid,
            ]);
        }else{
            return response([
                'message' => 'error',
            ]);
        }
    }

    public function storeInvoiceItem(Request $request){
        $message;
        $latest_invoice_id = Invoice::latest()->first('id');
        foreach($request->invoiceItems as $item){

            $items = [
                'invoice_id'    => $latest_invoice_id->id,
                'service_title' => $item['name'],
                'price'         => $item['price'],
                'quantity'      => $item['quantity'],
                'total_price'   => $item['totalAmount'],

            ];

            $message = InvoieItem::create($items);
        };

        if($message){
            return response([
                'message' => 'success',
            ]);
        }else{
            return response([
                'message' => 'error',
            ]);
        }

    }

    public function getSingleInvoice($uid){
        $invoice = Invoice::with(['invoice_items','user'])->where('invoice_uid',$uid)->first();
        return $invoice;
    }


    public function createDepositRequest($id,Request $request){
        $today = Carbon::now();

        $requestDate = $request->due_date;
        if ($requestDate <= $today) {
            $requestDate = $today->copy()->addDay()->format('Y-m-d');
        }

        if($request->diposit_amount > 0.00){
            $diposit_data = DipositRequest::create([
                'invoice_id' => $id,
                'diposit_amount' => $request->diposit_amount,
                'due_date' => Carbon::parse($requestDate)->format('Y-m-d'),
                //'due_date' => $requestDate,
            ]);


            $depositAmount = $diposit_data->diposit_amount;

            return response()->json([
                'message' => 'success',
                //'data' => $data,
            ]);
        }
        else{
            return response()->json([
                'message' => 'success',
            ]);
        }
    }


    public function showDepositRequest($id){
        $data = DipositRequest::where('invoice_id',$id)->first();
        if($data){
            return response()->json([
                'message' => 'success',
                'data' => $data,
            ]);
        }else{
            return response()->json([
                'message' => 'deposit request is not available for this invoice',
            ]);
        }

    }


    public function updateDepositRequest(Request $request, $id){
        //check date and validate it
        $today = Carbon::now();


        $requestDate = $request->due_date;
        if ($requestDate <= $today) {
            $requestDate = $today->copy()->addDay()->format('Y-m-d');
        }

        if($request->diposit_amount < 0.1){
            DipositRequest::where('invoice_id',$id)->delete();

        }

        //update diposite
        DipositRequest::where('invoice_id',$id)->update([
            'diposit_amount' => $request->diposit_amount,
            'due_date' => $requestDate,
        ]);

        //get updated data
        // $updatedData = DipositRequest::where('invoice_id', $id)->first();

        // $depositAmount = $updatedData['diposit_amount'];
        // $deposit_due_date = Carbon::parse($updatedData->due_date)->format('Y-m-d');


        // $data = [
        //     'amount' =>$depositAmount,
        //     'due_date' => $deposit_due_date,

        // ];

        return response()->json([
            'message' => 'success',
            // 'data' => $data,
        ]);
    }


}
