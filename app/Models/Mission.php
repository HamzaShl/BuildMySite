<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Mission extends Model
{
    use HasFactory;

    protected $table = 'mission';
    protected $primaryKey = 'id_mission';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_mission',
        'titre_mission',
        'etat_mission',
        'description_mission',
        'id_entreprise',
        'id_dev'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->id_mission)) {
                $model->id_mission = (string) Str::uuid();
            }
        });
    }

    // Relations
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'id_entreprise', 'id_entreprise');
    }

    public function dev()
    {
        return $this->belongsTo(Dev::class, 'id_dev', 'id_dev');
    }

    public function devis()
    {
        return $this->hasMany(Devis::class, 'id_mission', 'id_mission');
    }
}