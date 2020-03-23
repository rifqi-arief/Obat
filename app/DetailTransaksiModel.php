<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DetailTransaksiModel extends Model
{
    use SoftDeletes;

    protected $table = 'transaksi';

}
