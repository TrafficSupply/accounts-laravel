<?php

namespace TrafficSupply\AccountsLaravel\Models;

use Illuminate\Database\Eloquent\Model;

class Accountsuser extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<string>
     */
    protected $fillable = [
        'name',
        'email',
        'locale',
        'theme',
    ];
}
