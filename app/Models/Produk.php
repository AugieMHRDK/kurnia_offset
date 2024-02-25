<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Attachments;
use App\Models\Bahan;

class Produk extends Model
{
    use HasFactory;
    protected $table = 'produk';
    protected $guarded = ['id'];
    public $timestamps = false;
    
    public function attachments()
    {
        return $this->belongsTo(Attachments::class, 'id_gambar', 'uid');
    }
    
    public function bahan()
    {
        return $this->hasMany(Bahan::class, 'produk_id', 'id');
    }
}
