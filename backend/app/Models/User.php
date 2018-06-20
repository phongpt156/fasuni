<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Model implements
    JWTSubject,
    AuthenticatableContract,
    AuthorizableContract
{
    use Authenticatable, Authorizable;

    protected $fillable = ['name', 'first_name', 'last_name', 'email', 'password', 'gender','living_city_id', 'avatar', 'cover', 'facebook_id', 'facebook_name', 'facebook_access_token', 'api_token', 'google_id', 'google_name', 'google_id_token'];
    protected $hidden = [
        'password', 'remember_token', 'api_token'
    ];

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function likedProducts()
    {
        return $this->belongsToMany(Product::class, 'product_likers');
    }

    public function customer()
    {
        return $this->hasOne(Customer::class, 'id', 'user_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function ward()
    {
        return $this->belongsTo(Ward::class);
    }
}
