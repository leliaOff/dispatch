<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContactsType extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'title'];

    /* Каналы, в котором используется этот тип */
    public function channels()
    {
        return $this->hasMany('App\Models\Channel');
    }

}
