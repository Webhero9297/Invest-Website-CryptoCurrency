<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserVerifiedCurrencyDetails extends Model
{
    //
    protected $table = 'user_verified_currency_details';
    public $primaryKey = 'detail_id';
    public $timestamps = false;

    public function users() {
        $this->belongsTo(User::class);
    }
}
