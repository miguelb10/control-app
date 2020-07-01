<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $dateFormat = 'M j Y h:i:s';
    protected $fillable = ['ccod_traba', 'page', 'description', 'Total_Descargas'];
}
