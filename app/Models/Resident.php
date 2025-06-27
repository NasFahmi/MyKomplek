<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resident extends Model
{
    /** @use HasFactory<\Database\Factories\ResidentFactory> */
    use HasFactory, HasUuids;
    // Di model HouseResident
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = [
        'name',
        'identity_photo',
        'status', //enum ['tetap', 'kontrak']
        'phone_number',
        'resident_status', //boolean 
        'married_status',
    ];
    // cast status to boolean
    protected $casts = [
        'married_status' => 'boolean',
        'resident_status' => 'boolean',
    ];

    // Histori rumah yang pernah dihuni
    public function houseResidents()
    {
        return $this->hasMany(HouseResident::class, 'resident_id');
    }

    // Rumah saat ini (jika masih aktif tinggal)
    public function currentHouse()
    {
        return $this->hasOne(HouseResident::class, 'resident_id')
            ->whereNull('date_of_exit');
    }
}
