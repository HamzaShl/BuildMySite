<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\Dev;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Mail\MissionRecue;
use Illuminate\Support\Facades\Mail; 

class MissionController extends Controller
{
    public function index()
    {
        $entreprise = Auth::guard('entreprise')->user(); // ✅ CHANGER
        $missions = Mission::where('id_entreprise', $entreprise->id_entreprise) // ✅ CHANGER
                          ->with(['dev'])
                          ->latest()
                          ->get();
        
        return view('entreprise.my-missions', compact('missions'));
    }

    public function create(Request $request)
    {
        $dev = Dev::findOrFail($request->dev_id);
        return view('entreprise.create-mission', compact('dev'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'titre_mission' => 'required|string|max:255',
            'description_mission' => 'required|string',
            'id_dev' => 'required|exists:dev,id_dev',
        ]);

        $entreprise = Auth::guard('entreprise')->user(); // ✅ AJOUTER

        $mission = Mission::create([
            'id_mission' => Str::uuid(),
            'titre_mission' => $request->titre_mission,
            'description_mission' => $request->description_mission,
            'etat_mission' => 'en_cours',
            'id_entreprise' => $entreprise->id_entreprise, // ✅ CHANGER
            'id_dev' => $request->id_dev,
        ]);
        $dev = Dev::findOrFail($request->id_dev);
        Mail::to($dev->email_dev)->send(new MissionRecue($mission, $dev));
    return redirect()->route('entreprises.listeDevis', ['mission_id' => $mission->id_mission])
                    ->with('success', 'Mission envoyée au développeur ! Vous serez notifié dès qu\'il aura créé son devis.');    }
public function show(string $id)
{
    // Trouver la mission par son ID
    $mission = Mission::with(['entreprise', 'dev'])->findOrFail($id);
    
    // Vérifier que c'est bien le dev connecté
    $dev = Auth::guard('dev')->user();
    if ($mission->id_dev !== $dev->id_dev) {
        abort(403, 'Cette mission ne vous est pas destinée.');
    }
    
    return view('dev.missions', compact('mission'));
}
    
}