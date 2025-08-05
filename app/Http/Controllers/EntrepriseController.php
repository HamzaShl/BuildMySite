<?php

namespace App\Http\Controllers;

use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Mission;
use App\Models\Devis;

class EntrepriseController extends Controller
{
    public function index()
{
    $entreprise = Auth::guard('entreprise')->user();
    
    // ✅ TON STYLE - Simple et direct
    $devs = \App\Models\Dev::all();
    
    return view('entreprise.index', compact('entreprise', 'devs'));
}



    public function show(string $id)
    {
        $entreprise = Entreprise::findOrFail($id);
        return view('entreprise.show', compact('entreprise'));
    }

    public function edit(string $id)
    {
        $entreprise = Entreprise::findOrFail($id);
        return view('entreprise.edit', compact('entreprise'));
    }

    public function update(Request $request, string $id)
    {
        $entreprise = Entreprise::findOrFail($id);

        $request->validate([
            'nom_entreprise' => 'required|string|max:255',
            'email_entreprise' => 'required|email|unique:entreprise,email_entreprise,' . $entreprise->id_entreprise . ',id_entreprise',
            'password_entreprise' => 'nullable|string|min:6',
            'taille_entreprise' => 'nullable|string',
            'secteur_entreprise' => 'nullable|string',
            'type_freelance' => 'nullable|string',
        ]);

        $data = $request->except('password_entreprise');

        if ($request->filled('password_entreprise')) {
            // Utilisez Hash::make pour être cohérent avec le reste de l'application
            $data['password_entreprise'] = Hash::make($request->password_entreprise);
        }

        $entreprise->update($data);

        return redirect()->route('entreprises.index')->with('success', 'Compte modifié');
    }

    public function destroy(string $id)
    {
        $entreprise = Entreprise::findOrFail($id);
        $entreprise->delete();

        return redirect()->route('entreprises.index')->with('success', 'Compte supprimé');
    }
    public function listeDevis($mission_id)
{
    $entreprise = Auth::guard('entreprise')->user();
    
    // Vérifier si la mission existe encore
    $mission = Mission::with(['dev'])->find($mission_id);
    
    // Si mission supprimée (dev a refusé), rediriger vers INDEX ENTREPRISE avec message
    if (!$mission) {
        return redirect()->route('entreprises.index')
                        ->with('info', 'Le développeur a refusé votre mission. Vous pouvez choisir un autre développeur pour votre projet.');
    }
    
    // Vérifier que c'est bien la mission de cette entreprise
    if ($mission->id_entreprise !== $entreprise->id_entreprise) {
        abort(403);
    }
    
    // Chercher si un devis existe pour cette mission
    $devis = Devis::where('id_mission', $mission->id_mission)->first();
    
    return view('entreprise.devis', compact('mission', 'devis', 'entreprise'));
}
    public function updateDevisAcceptation(Request $request, string $devis_id)
{
    $entreprise = Auth::guard('entreprise')->user();
    $devis = Devis::with(['mission'])->findOrFail($devis_id);
    
    // Vérifier que c'est bien le devis de cette entreprise
    if ($devis->mission->id_entreprise !== $entreprise->id_entreprise) {
        abort(403, 'Ce devis ne vous appartient pas.');
    }

    $request->validate([
        'action' => 'required|in:accepter,refuser',
    ]);

    if ($request->input('action') === 'accepter') {
        // Accepter le devis
        $devis->update(['etat_devis' => 'accepte']);
        
        return redirect()->back()->with('success', 'Devis accepté ! Le développeur peut maintenant commencer le projet.');
        
    } else {
        // Refuser le devis = le supprimer (pour que le dev puisse en refaire un)
        $mission_id = $devis->id_mission;
        $devis->delete();
        
        return redirect()->route('entreprises.listeDevis', ['mission_id' => $mission_id])
                        ->with('info', 'Devis refusé. Le développeur peut maintenant créer un nouveau devis.');
    }
}
}
