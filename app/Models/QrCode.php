<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class QrCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'restaurant_id', 'menu_id', 'code', 'scan_count', 'last_scanned_at'
    ];

    protected $casts = [
        'last_scanned_at' => 'datetime',
    ];

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function incrementScanCount()
    {
        $this->scan_count++;
        $this->last_scanned_at = Carbon::now();
        $this->save();
    }
}
