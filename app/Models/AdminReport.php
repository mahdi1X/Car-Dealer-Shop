<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id',
        'manager_id',
        'manager_note',
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }
}

