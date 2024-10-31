<?php

namespace TrafficSupply\TSAccountsLaravelPackage\Models;

use Illuminate\Database\Eloquent\Model;

class TsUser extends Model
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
