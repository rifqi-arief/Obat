<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransaksiModel extends Model
{
    use SoftDeletes;

    protected $table = 'transaksi';

}
