<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attachments;
use App\Models\Bahan;
use App\Models\Produk;
use App\Models\TrackingStatus;
use App\Models\User;

class Pemesanan extends Model
{
    use HasFactory;
    protected $table = 'pemesanan';
    protected $guarded = ['id'];
    public $timestamps = false;
    
    public function attachments()
    {
        return $this->belongsTo(Attachments::class, 'id_gambar', 'uid');
    }
    
    public function bahan()
    {
        return $this->belongsTo(Bahan::class, 'bahan_id', 'id');
    }
    
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id', 'id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function tracking()
    {
        return $this->hasMany(TrackingStatus::class, 'pemesanan_id', 'id');
    }
}
