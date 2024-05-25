<?php

namespace App\Traits;

use App\Models\Scopes\AccountScope;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

// Assuming your User model namespace

trait Blameable
{
    /**
     * Boot the blameable trait for a model.
     *
     * @return void
     */
    public static function bootBlameable()
    {
        // Add event listeners for creating and updating the model
        static::creating(function ($model) {
            $model->setCreatedBy();
        });

        static::updating(function ($model) {
            $model->setUpdatedBy();
        });
    }

    /**
     * Get the system user.
     *
     * @return \App\Models\User
     */
    protected function getSystemUser()
    {
        return User::where('email', config('productship.system_user_email'))->first();
    }

    /**
     * Set the created_by field value.
     *
     * @return void
     */
    public function setCreatedBy()
    {
        $user = Auth::user();
        $this->created_by = $user ? $user->id : $this->getSystemUser()?->id;
    }

    /**
     * Set the updated_by field value.
     *
     * @return void
     */
    public function setUpdatedBy()
    {
        $user = Auth::user();
        $this->updated_by = $user ? $user->id : $this->getSystemUser()?->id;
    }

    /**
     * Get the user who created the model.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who updated the model.
     */
    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
