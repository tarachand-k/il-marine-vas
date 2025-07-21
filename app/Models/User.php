<?php

namespace App\Models;

use Abbasudo\Purity\Traits\Filterable;
use App\Enums\UserRole;
use Illuminate\Auth\Passwords\CanResetPassword as CanResetPasswordTrait;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Model implements CanResetPasswordContract
{
    use HasFactory, Notifiable, HasApiTokens, Filterable, CanResetPasswordTrait;

    public $filterFields = [
        "created_by_id",
        "customer_id",

        "name",
        "email",
        "mobile_no",
        "role"
    ];

    protected $fillable = [
        "created_by_id",
        "customer_id",

        'name',
        'email',
        'mobile_no',
        'password',
        'role',
        'status',
        'last_login_at'
    ];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, "created_by_id");
    }

    public function videos(): BelongsToMany
    {
        return $this->belongsToMany(Video::class, 'video_user');
    }

    public function presentations(): BelongsToMany
    {
        return $this->belongsToMany(Presentation::class, 'presentation_user');
    }

    public function mlceIndents(): BelongsToMany
    {
        return $this->belongsToMany(MlceIndent::class, 'mlce_indent_user');
    }

    public function sops(): BelongsToMany
    {
        return $this->belongsToMany(Sop::class, "sop_user");
    }

    public function createdVesselAssessments(): HasMany
    {
        return $this->hasMany(VesselAssessment::class, 'created_by_id');
    }

    public function assignedVesselAssessments(): HasMany
    {
        return $this->hasMany(VesselAssessment::class, 'assigned_to_id');
    }

    public function approvedVesselAssessments(): HasMany
    {
        return $this->hasMany(VesselAssessment::class, 'approved_by_id');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'role' => UserRole::class,
        ];
    }
}
