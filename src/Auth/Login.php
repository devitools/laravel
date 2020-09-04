<?php

declare(strict_types=1);

namespace Devitools\Auth;

use Dyrynda\Database\Support\GeneratesUuid as HasBinaryUuid;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Throwable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 *
 * @package Source\Domains\Admin
 * @property string uuid
 * @property string id
 * @property string name
 * @property string password
 * @property boolean active
 * @property ProfileInterface profile
 * @method static Login where(string $column, mixed $value)
 * @method static Login whereRaw(string $column, mixed $value)
 * @method Login firstOrFail()
 * @method Login first()
 */
class Login extends User implements JWTSubject
{
    /**
     * @see Notifiable
     */
    use Notifiable;

    /**
     * @see HasBinaryUuid
     */
    use HasBinaryUuid;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'binary';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'uuid' => 'uuid',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'profileId',
        'id',
        'uuid',
        'password',
        'remember_token',
    ];

    /**
     * @return BelongsTo
     */
    public function profile(): BelongsTo
    {
        return $this->belongsTo(config('auth.providers.users.profile'), 'profileId', 'uuid');
    }

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

    /**
     * Get the primary key for the model.
     *
     * @return string
     */
    public function getKeyName()
    {
        return 'id';
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        try {
            return $this->profile->getReference();
        } catch (Throwable $error) {
            // silent is gold
        }
        return 'unknown';
    }

    /**
     * @return Collection
     */
    public function getPermissions(): Collection
    {
        try {
            return $this->profile->getPermissions();
        } catch (Throwable $error) {
            // silent is gold
        }
        return new Collection();
    }
}
