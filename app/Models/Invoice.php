<?php

namespace App\Models;

use App\Models\InvoieItem;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoice_items()
    {
        return $this->hasMany(InvoieItem::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function depositRequest()
    {
        return $this->hasOne(DipositRequest::class);
    }

}
