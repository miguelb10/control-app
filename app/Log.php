<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $dateFormat = 'M j Y h:i:s';
    protected $fillable = ['user_id', 'page', 'description', 'Total_Descargas'];
}
