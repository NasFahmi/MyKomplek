<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /** @use HasFactory<\Database\Factories\PaymentFactory> */
    use HasFactory;
    use HasUuids;

    // Di model HouseResident
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'code',
        'resident_id',
        'house_id',
        'payment_date',
        'status',
        'description',
    ];
    protected $casts = [
        'payment_date' => 'datetime',
    ];
    protected $guarded = [
        'id',
    ];
    //payment->resident 
    public function resident()
    {
        return $this->belongsTo(Resident::class, 'resident_id');
    }

    public function house()
    {
        return $this->belongsTo(House::class, 'house_id');
    }
    public function paymentDetail()
    {
        return $this->hasMany(PaymentDetail::class, 'payment_id');
    }
}
