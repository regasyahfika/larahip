<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format('d-M-Y H:i:s');
    }
}
