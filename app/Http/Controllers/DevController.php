<?php

namespace App\Http\Controllers;

use App\Models\Dev;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Mission;
use App\Models\Devis;

class DevController extends Controller
{
   public function index()
{
    $dev = Auth::guard('dev')->user();
    
    if (!$dev) {
        return redirect()->route('login');
    }

    // ✅ TON STYLE - Simple et direct
    $missions = Mission::where('id_dev', $dev->id_dev)
                     ->where('etat_mission', 'en_cours')  // Seulement les missions en cours
                     ->get();

    return view('dev.index', compact('dev', 'missions'));
}

    public function create()
    {
        return view('dev.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nom_dev' => 'required|string|max:255',
            'prenom_dev' => 'required|string|max:255',
            'email_dev' => 'required|email|unique:dev,email_dev',
            'password_dev' => 'required|string|min:6',
            'niveau_experience' => 'required|in:junior,confirme,senior',
            'specialite_dev' => 'required|in:front,back,fullstack',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'cv' => 'nullable|mimes:pdf,doc,docx|max:4096',
            'portfolio' => 'nullable|mimes:pdf,zip|max:8192',
        ]);

        $data = $request->all();
        $data['id_dev'] = Str::uuid();
        $data['password_dev'] = bcrypt($request->password_dev);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('dev_photos', 'public');
        }

        if ($request->hasFile('cv')) {
            $data['cv'] = $request->file('cv')->store('dev_cvs', 'public');
        }

        if ($request->hasFile('portfolio')) {
            $data['portfolio'] = $request->file('portfolio')->store('dev_portfolios', 'public');
        }

        Dev::create($data);

        return redirect()->route('devs.index')->with('success', 'Développeur créé avec succès !');
    }

    public function show(string $id)
    {
        $dev = Dev::findOrFail($id);
        return view('dev.show', compact('dev'));
    }

    public function edit(string $id)
    {
        $dev = Dev::findOrFail($id);
        return view('dev.edit', compact('dev'));
    }

    public function update(Request $request, string $id)
    {
        $dev = Dev::findOrFail($id);

        $request->validate([
            'nom_dev' => 'required|string|max:255',
            'prenom_dev' => 'required|string|max:255',
            'email_dev' => 'required|email|unique:dev,email_dev,' . $dev->id_dev . ',id_dev',
            'password_dev' => 'nullable|string|min:6',
            'niveau_experience' => 'required|in:junior,confirme,senior',
            'specialite_dev' => 'required|in:front,back,fullstack',
            'description' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'cv' => 'nullable|mimes:pdf,doc,docx|max:4096',
            'portfolio' => 'nullable|mimes:pdf,zip|max:8192',
        ]);

        $data = $request->except('password_dev');

        if ($request->filled('password_dev')) {
            $data['password_dev'] = bcrypt($request->password_dev);
        }

        if ($request->hasFile('photo')) {
            if ($dev->photo) {
                Storage::disk('public')->delete($dev->photo);
            }
            $data['photo'] = $request->file('photo')->store('dev_photos', 'public');
        }

        if ($request->hasFile('cv')) {
            if ($dev->cv) {
                Storage::disk('public')->delete($dev->cv);
            }
            $data['cv'] = $request->file('cv')->store('dev_cvs', 'public');
        }

        if ($request->hasFile('portfolio')) {
            if ($dev->portfolio) {
                Storage::disk('public')->delete($dev->portfolio);
            }
            $data['portfolio'] = $request->file('portfolio')->store('dev_portfolios', 'public');
        }

        $dev->update($data);

        return redirect()->route('devs.show', $dev->id_dev)->with('success', 'Profil mis à jour avec succès !');
    }

    public function destroy(string $id)
    {
        $dev = Dev::findOrFail($id);

        if ($dev->photo) {
            Storage::disk('public')->delete($dev->photo);
        }
        if ($dev->cv) {
            Storage::disk('public')->delete($dev->cv);
        }
        if ($dev->portfolio) {
            Storage::disk('public')->delete($dev->portfolio);
        }

        $dev->delete();

        return redirect()->route('devs.index')->with('success', 'Développeur supprimé avec succès !');
    }

    public function updateAcceptation(Request $request, string $id)
{
    $mission = Mission::findOrFail($id);
    $dev = Auth::guard('dev')->user();
    
    if ($mission->id_dev !== $dev->id_dev) {
        abort(403);
    }

    $request->validate([
        'action' => 'required|in:accepter,refuser',
    ]);

    if ($request->input('action') === 'accepter') {
        $mission->update(['etat_mission' => 'en_cours']);
        
        // ✅ REDIRECTION VERS CRÉATION DE DEVIS
        return redirect()->route('devis.create', ['mission_id' => $mission->id_mission])
                        ->with('success', 'Mission acceptée ! Veuillez créer votre devis ci-dessous.');
                        
    } else {
        // ✅ SUPPRIMER LA MISSION SI REFUSÉE
        $mission->delete();
        
        return redirect()->route('devs.index')
                        ->with('success', 'Mission refusée et supprimée.');
    }
}
public function gestionMission(string $mission_id)
{
    $dev = Auth::guard('dev')->user();
    $mission = Mission::with(['entreprise'])->findOrFail($mission_id);
    
    // Vérifier que c'est bien la mission du dev
    if ($mission->id_dev !== $dev->id_dev) {
        abort(403, 'Cette mission ne vous appartient pas.');
    }
    
    // Récupérer le devis s'il existe
    $devis = Devis::where('id_mission', $mission->id_mission)->first();
    
    return view('dev.gestion-mission', compact('mission', 'devis'));
}

/**
 * Mettre à jour l'état d'une mission
 */
public function updateEtatMission(Request $request, string $id)
{
    $mission = Mission::findOrFail($id);
    $dev = Auth::guard('dev')->user();
    
    if ($mission->id_dev !== $dev->id_dev) {
        abort(403);
    }

    $request->validate([
        'etat_mission' => 'required|in:en_cours,terminee'
    ]);

    $mission->update(['etat_mission' => $request->etat_mission]);

    return redirect()->back()->with('success', 'État de la mission mis à jour !');
}
}