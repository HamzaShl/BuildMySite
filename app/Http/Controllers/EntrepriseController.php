<?php

namespace App\Http\Controllers;

use App\Models\Entreprise;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EntrepriseController extends Controller
{
    public function index()
    {
        $entreprise = Auth::guard('entreprise')->user();
        $devs = \App\Models\Dev::all(); // Récupère tous les développeurs
    
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
}
