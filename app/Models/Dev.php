<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

//extend de Authenticatable pour hériter les fonctionnalités d'authentification
class Dev extends Authenticatable
{
    //cherche la table dev, la clé primaire id_dev, le type string car uuid = string
    protected $table = 'dev';
    protected $primaryKey = 'id_dev';
    public $incrementing = false;
    protected $keyType = 'string';

    //liste des champs modifiables
    protected $fillable = [
        'id_dev',
        'email_dev',
        'password_dev',
        'nom_dev',
        'prenom_dev',
        'niveau_experience',
        'specialite_dev',
        'description',
        'photo',
        'cv',
        'portfolio',
    ];

    //relation eloquent : 
    // un dev reçoit un à plusieurs commentaires
    public function commentaires()
    {
        return $this->hasMany(Commentaire::class, 'id_dev', 'id_dev');
    }

    //relation mission : un dev reçoit une à plusieurs missions
    public function missions()
    {
        return $this->hasMany(Mission::class, 'id_dev', 'id_dev');
    }

    //relation devis : un dev peut créer un à plusieurs devis
    public function devis()
    {
        return $this->hasMany(Devis::class, 'id_dev', 'id_dev');
    }
}
