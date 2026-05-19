<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserAppAccess extends Model
{
    public const APPLICATION_GESTION_ROLES = 'gestion_roles';

    public const ROLES = [
        'admin',
        'vicedecano_docente',
        'decano',
        'jefe_departamento',
    ];

    protected $table = 'user_app_access';

    protected $fillable = [
        'username',
        'application_code',
        'role',
        'facultad_id',
        'departamento_id',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
        'facultad_id' => 'integer',
        'departamento_id' => 'integer',
    ];
}
