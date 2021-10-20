<?php

namespace Capmega\UserCRUD;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use OwenIt\Auditing\Contracts\Auditable;

class User extends Authenticatable implements Auditable
{
    use \OwenIt\Auditing\Auditable;

    protected $hidden = ['password', 'created_at', 'updated_at'];

    /*
     * A user belongs to one Center
     */
    public function center(){
        return $this->belongsTo('App\Center');
    }

    /*
     * A user has one role
     */
    public function role(){
        return $this->belongsTo('App\Role');
    }

    /*
     * Belongs to a client
     */
    public function client(){
        return $this->belongsTo('App\Client');
    }

    /**
     * A user has many Inventory Changes
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function inventoryChanges(){
        return $this->hasMany('App\InventoryChange', 'user_id', 'id');
    }

    /*
     * A user created many clients
     */
    public function clientsCreated(){
        return $this->belongsTo('App\User', 'created_by');
    }

    /*
     * Does a user have an specific role?
     * Return true or false
     */
    public function hasRole($role){
        return $this->role->seoname == $role;
    }

    /*
     * A User can create many Tracking(s)
     */
    public function trackings(){
        return $this->hasMany('App\Tracking', 'responsable_id', 'id');
    }

    /*
     * Return user with a specific role
     */
    public function scopeWithRole($query, $role_name){
        return $query->whereHas('role', function($q) use(&$role_name){
            return $q->where('seoname', $role_name);
        });
    }

    /*
     *
     */
    public function seller_quotations(){
      return $this->hasMany('App\Quotation', 'seller_id', 'id');
    }

    /*
     *
     */
    public function authored_quotations(){
      return $this->hasMany('App\Quotation', 'author_id', 'id');
    }

    /*
     *
     */
    public function authored_sales(){
      return $this->hasMany('App\Sale', 'author_id', 'id');
    }

    /*
     * Messages relationship
     */
    public function messages(){
        return $this->hasMany('App\Message', 'user_id', 'id');
    }

    /*
     * Messages relationship
     */
    public function systemMessages(){
        return $this->hasMany('App\SystemMessage', 'created_by', 'id');
    }

    /*
     * A user creates notifications
     */
    public function createdNotifications(){
        return $this->hasMany('App\Notification', 'created_by', 'id');
    }

    /*
     * A user has notifications
     */
    public function notifications(){
        return $this->hasMany('App\Notification', 'user_id', 'id');
    }

    /*
     * A user can approve many reservations
     */
    public function reservations() {
        return $this->hasMany('App\Reservation', 'user_id', 'id');
    }
}
