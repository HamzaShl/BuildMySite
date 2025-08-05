<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Dev extends Authenticatable
{
    protected $table = 'dev';

    protected $primaryKey = 'id_dev';
    public $incrementing = false;
    protected $keyType = 'string';

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

   public function commentaires()
{
    return $this->hasMany(Commentaire::class, 'id_dev', 'id_dev');
}
}
