<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NmLndocumento extends Model
{
    //
    protected $fillable = [
        'id_cbdocumentos','dfch_descarga', 'cpc_descarga'
    ];
    const UPDATED_AT = null;
    const CREATED_AT = null;
}
