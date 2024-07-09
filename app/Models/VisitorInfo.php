<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorInfo extends Model
{
    use HasFactory;

    protected $table = 'visitor_infos';

    protected $fillable = [
        'ip',
        'port',
        'isp',
        'mac'
    ];
}
