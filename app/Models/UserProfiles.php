<?php

namespace App\Models;

use App\Enums\EducationSystem;
use App\Enums\UserGender;
use App\Enums\UserType;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserProfiles extends Model
{
    use CrudTrait;
    use HasFactory;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'user_profiles';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'user_id',
        'code',
        'birth_date',
        'gender',
        'phone_number',
        'academic_degree_id',
        'class_id',
        'type',
    ];

    protected $hidden = [];

    protected $casts = [
        'gender' => UserGender::class,
        'type' => UserType::class,
        'education_system' => EducationSystem::class,
    ];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function academicDegree(): BelongsTo
    {
        return $this->belongsTo(AcademicDegrees::class, 'academic_degree_id');
    }

    public function userClasses(): HasMany
    {
        return $this->hasMany(UserClasses::class, 'user_id', 'user_id');
    }

    public function userOrganizations(): HasMany
    {
        return $this->hasMany(UserOrganizations::class, 'user_id', 'user_id');
    }

    public function userPositions(): HasMany
    {
        return $this->hasMany(UserPosition::class, 'user_id', 'user_id');
    }

    public function organizations(): BelongsToMany
    {
        return $this->belongsToMany(Organizations::class, 'user_organizations', 'user_id', 'organization_id');
    }

    public function positions(): BelongsToMany
    {
        return $this->belongsToMany(Positions::class, 'user_positions', 'user_id', 'position_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    public function getGenderAttribute($value): string
    {
        $gender = UserGender::from(strtolower($value));
        $language = app()->getLocale();

        return $language === 'en' ? $gender->toEN() : $gender->toVN();
    }

    public function getTypeAttribute($value): string
    {
        $type = UserType::from(strtolower($value));
        $language = app()->getLocale();

        return $language === 'en' ? $type->toEN() : $type->toVN();
    }

    public function getEducationSystemAttribute($value): string
    {
        $educationSystem = EducationSystem::from(strtoupper($value));
        $language = app()->getLocale();

        return $language === 'en' ? $educationSystem->toEN() : $educationSystem->toVN();
    }
    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */

    public function setGenderAttribute($value): void
    {
        $this->attributes['gender'] = UserGender::from(strtolower($value))->value;
    }

    public function setTypeAttribute($value): void
    {
        $this->attributes['type'] = UserType::from(strtolower($value))->value;
    }

    public function setEducationSystemAttribute($value): void
    {
        $this->attributes['education_system'] = EducationSystem::from(strtoupper($value))->value;
    }
}
