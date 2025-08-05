<?php

namespace App\Http\Controllers;

use App\Models\Devis;
use App\Models\Mission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Mail\DevisPret;
use Illuminate\Support\Facades\Mail;

class DevisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Liste des devis du développeur connecté
        $dev = Auth::guard('dev')->user();
        $devis = Devis::whereHas('mission', function($query) use ($dev) {
            $query->where('id_dev', $dev->id_dev);
        })->with(['mission.entreprise'])->latest()->get();
        
        return view('dev.devis-list', compact('devis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // Renvoie le formulaire de création
        $mission = Mission::with(['entreprise'])->findOrFail($request->mission_id);
        $dev = Auth::guard('dev')->user();
        
        // Vérifier que c'est bien la mission du dev
        if ($mission->id_dev !== $dev->id_dev) {
            abort(403, 'Cette mission ne vous appartient pas.');
        }
        
        // Vérifier si un devis existe déjà
        $devis = Devis::where('id_mission', $mission->id_mission)->first();
        
        return view('dev.create-devis', compact('mission', 'devis'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // Validation
    $request->validate([
        'titre_devis' => 'required|string|max:255',
        'description_devis' => 'required|string',
        'prix' => 'required|numeric|min:0',
        'delai' => 'required|string',
        'id_mission' => 'required|exists:mission,id_mission',
    ]);

    $mission = Mission::findOrFail($request->input('id_mission'));
    $dev = Auth::guard('dev')->user();

    // Créer le devis
    $devis = Devis::create([
        'id_devis' => Str::uuid(),
        'titre_devis' => $request->input('titre_devis'),
        'description_devis' => $request->input('description_devis'),
        'prix' => $request->input('prix'),
        'delai' => $request->input('delai'),
        'etat_devis' => 'en_attente',
        'id_mission' => $request->input('id_mission'),
        'id_dev' => $dev->id_dev,
        'id_entreprise' => $mission->id_entreprise,
    ]);
    $entreprise = $mission->entreprise;
    Mail::to($entreprise->email_entreprise)->send(new DevisPret($devis, $entreprise));
    
    return redirect()->back()->with('success', 'Devis créé avec succès !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Trouver le devis par son ID
        $devis = Devis::findOrFail($id);
        
        // Récupérer la mission liée à ce devis
        $mission = $devis->mission;
        
        // Renvoie la vue
        return view('dev.show-devis', compact('devis', 'mission'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Trouver le devis par son ID
        $devis = Devis::findOrFail($id);
        $dev = Auth::guard('dev')->user();
        
        if ($devis->mission->id_dev !== $dev->id_dev) {
            abort(403);
        }
        
        // Renvoie la vue
        return view('dev.edit-devis', compact('devis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Trouver le devis à modifier
        $devis = Devis::findOrFail($id);
        $dev = Auth::guard('dev')->user();
        
        if ($devis->mission->id_dev !== $dev->id_dev) {
            abort(403);
        }

        if ($devis) {
            $devis->update([
                'titre_devis' => $request->input('titre_devis'),
                'description_devis' => $request->input('description_devis'),
                'prix' => $request->input('prix'),
                'delai' => $request->input('delai'),
            ]);
        }

        // Renvoie de la vue
        return redirect()->back()->with('success', 'Devis modifié avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Trouver le devis à supprimer
        $devis = Devis::findOrFail($id);
        $dev = Auth::guard('dev')->user();
        
        if ($devis->mission->id_dev !== $dev->id_dev) {
            abort(403);
        }
        
        // Supprimer avec la méthode Eloquent delete()
        $devis->delete();
        
        // Faire une redirection dans la même page
        return redirect()->back()->with('success', 'Devis supprimé avec succès');
    }
}