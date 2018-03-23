<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Channel extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'title', 'contacts_type_id'];

    /* Тип контактных данных, который необходим при отправке сообщения этим каналом */
    public function contactsType()
    {
        return $this->belongsTo('App\Models\ContactsType');
    }
    
}