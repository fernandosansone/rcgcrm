<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $fillable = [
        'opportunity_id','quote_number','issued_at','valid_until',
        'currency','total','pdf_path','status','created_by'
    ];

    protected $casts = [
        'issued_at' => 'date',
        'valid_until' => 'date',
        'total' => 'decimal:2',
    ];

    public function opportunity()
    {
        return $this->belongsTo(Opportunity::class);
    }

    public function items()
    {
        return $this->hasMany(QuoteItem::class);
    }
}
