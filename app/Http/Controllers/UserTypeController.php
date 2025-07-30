<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserTypeController extends Controller
{
     public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:dev,entreprise',
        ]);

        if ($request->type === 'entreprise') {
            return redirect()->route('entreprises.create');
        } else {
            return redirect()->route('dev.create');  // À créer pour les développeurs
        }
}
}