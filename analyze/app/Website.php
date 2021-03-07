<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

/**
 * Class Website
 *
 * @mixin Builder
 * @package App
 */
class Website extends Model
{
    /**
     * @param Builder $query
     * @param $value
     * @return Builder
     */
    public function scopeSearchURL(Builder $query, $value)
    {
        return $query->where('url', 'like', '%' . $value . '%');
    }

    public function user()
    {
        return $this->belongsTo('App\User')->where('id', $this->user_id)->withTrashed();
    }

    /**
     * @param Builder $query
     * @param $value
     * @return Builder
     */
    public function scopeUserId(Builder $query, $value)
    {
        return $query->where('user_id', '=', $value);
    }

    /**
     * @param Builder $query
     * @param $value
     * @return Builder
     */
    public function scopeSearchGlobal(Builder $query, $value)
    {
        return $query->where('user_id', '=', 0);
    }

    /**
     * Get the visitors count for a specific date range
     *
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|object|null
     */
    public function visitors()
    {
        return $this->hasMany('App\Stat', 'website_id', 'id')
            ->where('name', '=', 'visitors');
    }

    /**
     * Get the pageviews count for a specific date range
     *
     * @return Model|\Illuminate\Database\Eloquent\Relations\HasMany|object|null
     */
    public function pageviews()
    {
        return $this->hasMany('App\Stat', 'website_id', 'id')
            ->where('name', '=', 'pageviews');
    }

    public function stats()
    {
        return $this->hasMany('App\Stat')->where('website_id', $this->id);
    }

    public function recents()
    {
        return $this->hasMany('App\Recent')->where('website_id', $this->id);
    }

    /**
     * Encrypt the website's password
     *
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Crypt::encryptString($value);
    }

    /**
     * Decrypt the website's password
     *
     * @param $value
     * @return string
     */
    public function getPasswordAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return null;
        }
    }
}
