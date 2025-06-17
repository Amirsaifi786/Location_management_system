<?php

namespace App\Models;
use App\Models\Country;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{


    protected $fillable=['state_name','country_id'];
    
public function country() {
    return $this->belongsTo(Country::class);
}
public function cities() {
    return $this->hasMany(City::class);
}
}
