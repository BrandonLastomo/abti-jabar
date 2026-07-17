<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'prenominal_title',
        'postnominal_title',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function generalProfile()
    {
        return $this->hasOne(GeneralProfile::class);
    }

    public function identityDocument()
    {
        return $this->hasOne(IdentityDocument::class);
    }

    public function educationDocument()
    {
        return $this->hasOne(EducationDocument::class);
    }

    public function integrityDocuments()
    {
        return $this->hasMany(IntegrityDocument::class);
    }

    public function userTeamExperiences()
    {
        return $this->hasMany(UserTeamExperience::class);
    }

    public function eventExperiences()
    {
        return $this->hasMany(EventExperience::class);
    }

    public function userCertifications()
    {
        return $this->hasMany(UserCertification::class);
    }

    /**
     * Get the documents uploaded by this user.
     */
    public function documents()
    {
        return $this->hasMany(UserDocument::class);
    }

    public function mutationProposals()
    {
        return $this->hasMany(MutationProposal::class);
    }
}
