<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HouseResident extends Model
{
    /** @use HasFactory<\Database\Factories\HouseResidentFactory> */
    use HasFactory;
    use HasUuids;
    use SoftDeletes;

    // Di model HouseResident
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'house_id',
        'resident_id',
        'date_of_entry',
        'date_of_exit',
    ];
    protected $dates = ['date_of_entry', 'date_of_exit'];
    protected $guarded = ['id'];
    // relasi Houseresident -> house
    public function house()
    {
        return $this->belongsTo(House::class);
    }

    // relasi Houseresident -> Resident
    public function resident()
    {
        return $this->belongsTo(Resident::class);
    }
}
