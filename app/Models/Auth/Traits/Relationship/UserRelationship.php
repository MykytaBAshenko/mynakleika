<?php

namespace App\Models\Auth\Traits\Relationship;

use App\Models\Customer;
use App\Models\Manager;
use App\Models\System\Session;
use App\Models\Auth\SocialAccount;
use App\Models\Auth\PasswordHistory;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class UserRelationship.
 */
trait UserRelationship
{
    /**
     * @return mixed
     */
    public function providers()
    {
        return $this->hasMany(SocialAccount::class);
    }

    /**
     * @return mixed
     */
    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    /**
     * @return mixed
     */
    public function passwordHistories()
    {
        return $this->hasMany(PasswordHistory::class);
    }

    /**
     * @return HasOne
     */
    public function customer(): HasOne
    {
        return $this->hasOne(Customer::class);
    }

    /**
     * @return HasOne
     */
    public function manager(): HasOne
    {
        return $this->hasOne(Manager::class);
    }
}
