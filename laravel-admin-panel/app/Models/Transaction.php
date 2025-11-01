<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transactions';
    protected $guarded = [];

    public function getStatusAttribute($status)
    {
        switch ($status) {
            case '0':
                $status = 'ناموفق';
                break;
            case '1':
                $status = 'موفق';
                break;
        }
        return $status;
    }

    public function scopeGetData($query, $month, $status)
    {
        $verta = verta()->startMonth()->subMonths($month - 1);
        return $query->where('created_at', '>', $verta->toCarbon())->where('status', $status)->get();
    }
}
