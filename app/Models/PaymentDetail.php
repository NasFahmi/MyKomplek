<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentDetailFactory> */
    use HasFactory;
    use HasUuids;

    // Di model HouseResident
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $guarded = ['id'];
    protected $fillable = [
        'fee_type_id',
        'payment_id',
        'amount',
    ];


    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    public function feeType()
    {
        return $this->belongsTo(FeeType::class, 'fee_type_id');
    }
}
