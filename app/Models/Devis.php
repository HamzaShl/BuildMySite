<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Devis extends Model
{
    use HasFactory;

    protected $table = 'devis';
    protected $primaryKey = 'id_devis';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_devis',
        'titre_devis',
        'prix',
        'id_mission',
        'id_dev',
        'id_entreprise'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->id_devis)) {
                $model->id_devis = (string) Str::uuid();
            }
        });
    }

    // Relations
    public function mission()
    {
        return $this->belongsTo(Mission::class, 'id_mission', 'id_mission');
    }

    public function dev()
    {
        return $this->belongsTo(Dev::class, 'id_dev', 'id_dev');
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'id_entreprise', 'id_entreprise');
    }
}