<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class Entreprise extends Authenticatable
{
    protected $table = 'entreprise'; // Indique bien le nom de ta table
    protected $primaryKey = 'id_entreprise';
    protected $fillable = [
        'id_entreprise',
        'nom_entreprise',
        'email_entreprise',
        'password_entreprise',
        'taille_entreprise',
        'secteur_entreprise',
        'type_freelance',
    ];


    public $incrementing = false;

    protected $keyType = 'string';

    public function commentaires()
    {
        return $this->hasMany(Commentaire::class, 'id_entreprise', 'id_entreprise');
    }
}