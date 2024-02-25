<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pemesanan;

class TrackingStatus extends Model
{
    use HasFactory;
    protected $table = 'tracking_status';
    protected $guarded = ['id'];
    public $timestamps = false;
    
    public function pemesanan()
    {
        return $this->belongsTo(Pemesanan::class, 'pemesanan_id', 'id');
    }
}
