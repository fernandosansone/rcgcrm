<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'first_name','last_name','phone_1','phone_2',
        'email_1','email_2','company_name','created_by','updated_by'
    ];

    public function opportunities()
    {
        return $this->hasMany(Opportunity::class);
    }
}
