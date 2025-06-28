<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeeType extends Model
{
    /** @use HasFactory<\Database\Factories\FeeTypeFactory> */
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    // Di model HouseResident
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'name',
        'description',
        'amount',
        'is_active',
        'effective_date',
    ];
    protected $guarded = ['id'];

    public function paymentDetails()
    {
        return $this->hasMany(PaymentDetail::class, 'fee_type_id');
    }
}
