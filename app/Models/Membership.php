<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Membership extends Model
{
    protected $fillable = [
        'user_id',
        'starts_at',
        'expires_at',
        'stripe_payment_id',
    ];

    protected $dates = [
        'starts_at',
        'expires_at',
        'created_at',
        'updated_at',
    ];

    public function isActive()
    {
        $now = Carbon::now();
        return $this->starts_at <= $now && $this->expires_at >= $now;
    }
}

