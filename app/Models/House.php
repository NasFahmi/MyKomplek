<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    /** @use HasFactory<\Database\Factories\HouseFactory> */
    use HasFactory;
    use HasUuids;

    // Di model HouseResident
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'house_number',
        'status',
    ];
    protected $guarded = ['id'];

    // relasi houseResident -> house
    public function currentResident()
    {
        return $this->hasOne(HouseResident::class)->whereNull('date_of_exit');
    }
    public function houseResidents()
    {
        return $this->hasMany(HouseResident::class, 'house_id');
    }
}
