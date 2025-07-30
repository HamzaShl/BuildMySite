<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Commentaire extends Model
{
    use HasFactory;

    protected $table = 'commentaire';
    protected $primaryKey = 'id_commentaire';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_commentaire',
        'titre_commentaire',
        'contenu_commentaire',
        'id_dev',
        'id_entreprise'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->id_commentaire)) {
                $model->id_commentaire = (string) Str::uuid();
            }
        });
    }

    // Relations
    public function dev()
    {
        return $this->belongsTo(Dev::class, 'id_dev', 'id_dev');
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, 'id_entreprise', 'id_entreprise');
    }
}