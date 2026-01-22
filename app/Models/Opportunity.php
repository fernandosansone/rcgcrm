<?php

namespace App\Models;

use App\Enums\OpportunityStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Opportunity extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'contact_id','assigned_user_id','detail','quantity','unit','amount',
        'status','opened_at','closed_at','created_by','updated_by'
    ];

    protected $casts = [
        'opened_at' => 'date',
        'closed_at' => 'date',
        'status' => OpportunityStatus::class,
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    public function followups()
    {
        return $this->hasMany(OpportunityFollowup::class);
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class);
    }
}
