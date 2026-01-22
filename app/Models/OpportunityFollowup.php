<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OpportunityFollowup extends Model
{
    protected $fillable = [
        'opportunity_id','contact_date','contact_method','response',
        'next_contact_date','created_by'
    ];

    protected $casts = [
        'contact_date' => 'datetime',
        'next_contact_date' => 'datetime',
    ];

    public function opportunity()
    {
        return $this->belongsTo(Opportunity::class);
    }
}
