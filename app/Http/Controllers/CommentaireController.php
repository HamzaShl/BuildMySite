<?php

namespace App\Http\Controllers;

use App\Models\Commentaire;
use App\Models\Dev;
use App\Models\Mission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentaireController extends Controller
{
    /**
     * Afficher le formulaire pour créer un commentaire
     */
    public function create($dev_id)
    {
        $entreprise = Auth::guard('entreprise')->user();
        $dev = Dev::findOrFail($dev_id);
        
        // Vérifier qu'il y a eu une mission terminée entre cette entreprise et ce dev
        $missionTerminee = Mission::where('id_entreprise', $entreprise->id_entreprise)
                                ->where('id_dev', $dev_id)
                                ->where('etat_mission', 'terminee')
                                ->exists();
        
        if (!$missionTerminee) {
            return redirect()->back()->with('error', 'Vous ne pouvez laisser un avis que pour un développeur avec qui vous avez terminé un projet.');
        }
        
        // Vérifier qu'un avis n'existe pas déjà
        $avisExistant = Commentaire::where('id_entreprise', $entreprise->id_entreprise)
                                  ->where('id_dev', $dev_id)
                                  ->exists();
        
        if ($avisExistant) {
            return redirect()->back()->with('info', 'Vous avez déjà laissé un avis pour ce développeur.');
        }
        
        return view('entreprise.commentaire', compact('dev', 'entreprise'));
    }

    /**
     * Enregistrer le commentaire
     */
    public function store(Request $request)
    {
        $entreprise = Auth::guard('entreprise')->user();
        
        $request->validate([
            'titre_commentaire' => 'required|string|max:255',
            'contenu_commentaire' => 'required|string|max:1000',
            'id_dev' => 'required|exists:dev,id_dev'
        ]);
        
        // Vérifier encore une fois les conditions
        $missionTerminee = Mission::where('id_entreprise', $entreprise->id_entreprise)
                                ->where('id_dev', $request->id_dev)
                                ->where('etat_mission', 'terminee')
                                ->exists();
        
        if (!$missionTerminee) {
            return redirect()->back()->with('error', 'Action non autorisée.');
        }
        
        $avisExistant = Commentaire::where('id_entreprise', $entreprise->id_entreprise)
                                  ->where('id_dev', $request->id_dev)
                                  ->exists();
        
        if ($avisExistant) {
            return redirect()->back()->with('error', 'Vous avez déjà laissé un avis pour ce développeur.');
        }
        
        // Créer le commentaire
        Commentaire::create([
            'titre_commentaire' => $request->titre_commentaire,
            'contenu_commentaire' => $request->contenu_commentaire,
            'id_dev' => $request->id_dev,
            'id_entreprise' => $entreprise->id_entreprise
        ]);
        
        return redirect()->route('entreprises.index')->with('success', 'Votre avis a été publié avec succès !');
    }

    /**
     * Afficher les commentaires d'un développeur
     */
    public function show($dev_id)
    {
        $dev = Dev::findOrFail($dev_id);
        $commentaires = Commentaire::where('id_dev', $dev_id)
                                  ->with('entreprise')
                                  ->orderBy('created_at', 'desc')
                                  ->get();
        
        return view('commentaires.show', compact('dev', 'commentaires'));
    }
}