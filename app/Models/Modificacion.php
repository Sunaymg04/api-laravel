<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modificacion extends Model
{
    use HasFactory;
    protected $table = 'modificacion';
    protected $fillable = [
        'version_id',
        'nombre',
        'plan_origen_id',
        'plan_modificado_id',
        'estado',
        'resumen_cambios',
        'estructura_snapshot',
    ];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'resumen_cambios' => 'array',
        'estructura_snapshot' => 'array',
    ];

    public function version()
    {
        return $this->belongsTo(Version::class, 'version_id');
    }

    public function planOrigen()
    {
        return $this->belongsTo(PlanEstudio::class, 'plan_origen_id');
    }

    public function planModificado()
    {
        return $this->belongsTo(PlanEstudio::class, 'plan_modificado_id');
    }
}
