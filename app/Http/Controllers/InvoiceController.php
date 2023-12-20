<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoieItem;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{

    public function invoiceList(){
        $invoices = Invoice::with('user')->orderBy('id', 'desc')->get();

        return $invoices;
    }

    public function storeInvoice(Request $request){

        $data = [
            'invoice_no'            => $request->invoice_no,
            'invoice_uid'           => Str::random(15),
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
}
