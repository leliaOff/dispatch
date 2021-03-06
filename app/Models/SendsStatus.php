<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SendsStatus extends Model
{
    protected $fillable = ['send_id', 'status'];

    /* Данный отправки */
    public function send()
    {
        return $this->belongsTo('App\Models\Send');
    }
}
