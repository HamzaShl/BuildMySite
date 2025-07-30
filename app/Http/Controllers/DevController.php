<?php

namespace App\Http\Controllers;

use App\Models\Dev;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DevController extends Controller
{
    public function index()
    {
        $dev = Auth::guard('dev')->user();
        
        return view('dev.index', compact('dev'));
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
        'niveau_experience' => 'required|in:junior,senior',
        'specialite_dev' => 'required|in:front,back,fullstack',
        'description' => 'nullable|string',
        'photo' => 'nullable|image|max:2048',
        'cv' => 'nullable|mimes:pdf,doc,docx|max:4096',
        'portfolio' => 'nullable|mimes:pdf,zip|max:8192',
    ]);

    $data = $request->except(['password_dev', 'photo', 'cv', 'portfolio']);

    // Gérer le mot de passe
    if ($request->filled('password_dev')) {
        $data['password_dev'] = Hash::make($request->password_dev);
    }

    // Gérer les fichiers
    if ($request->hasFile('photo')) {
        // Supprimer l'ancienne photo si elle existe
        if ($dev->photo) {
            \Storage::disk('public')->delete($dev->photo);
        }
        $data['photo'] = $request->file('photo')->store('photos', 'public');
    }

    if ($request->hasFile('cv')) {
        // Supprimer l'ancien CV si il existe
        if ($dev->cv) {
            \Storage::disk('public')->delete($dev->cv);
        }
        $data['cv'] = $request->file('cv')->store('cvs', 'public');
    }

    if ($request->hasFile('portfolio')) {
        // Supprimer l'ancien portfolio si il existe
        if ($dev->portfolio) {
            \Storage::disk('public')->delete($dev->portfolio);
        }
        $data['portfolio'] = $request->file('portfolio')->store('portfolios', 'public');
    }

    $dev->update($data);

    return redirect()->route('devs.index')->with('success', 'Profil mis à jour avec succès !');
}

    public function destroy(string $id)
    {
        $dev = Dev::findOrFail($id);
        $dev->delete();

        return redirect()->route('devs.index')->with('success', 'Développeur supprimé');
    }
}