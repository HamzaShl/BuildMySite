<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Dev;
use App\Models\Entreprise;
use App\Mail\WelcomeEmail;                   
use Illuminate\Support\Facades\Mail;  

class AuthController extends Controller
{
    public function showSignUp()
    {
        return view('auth.register');
    }

    public function showFormLogin()
    {
        return view('auth.login');
    }

    public function signUp(Request $request)
    {
        // Validation commune
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6|confirmed',
            'type' => 'required|in:dev,entreprise',
        ]);

        if ($request->input('type') === 'dev') {
            
            //données que l'utilisateur doit entrer
            $request->validate([
                'email' => 'required|email|unique:dev,email_dev',
                'password' => 'required|min:6|confirmed',
                'nom_dev' => 'required|string|max:255',
                'prenom_dev' => 'required|string|max:255',
                'niveau_experience' => 'required|in:junior,confirme,senior',
                'specialite_dev' => 'required|in:front,back,fullstack',
                'description' => 'nullable|string',
                'photo' => 'nullable|image|max:2048',
                'cv' => 'nullable|mimes:pdf,doc,docx|max:4096',
                'portfolio' => 'nullable|mimes:pdf,zip|max:8192',
            ]);

            // Upload des fichiers
            $photo = $request->file('photo') ? $request->file('photo')->store('photos', 'public') : null;
            $cv = $request->file('cv') ? $request->file('cv')->store('cvs', 'public') : null;
            $portfolio = $request->file('portfolio') ? $request->file('portfolio')->store('portfolios', 'public') : null;


            //eloquent Create qui va créer le dev en base
            $dev = Dev::create([
                'id_dev' => (string) Str::uuid(),
                'email_dev' => $request->input('email'),
                'password_dev' => Hash::make($request->input('password')),
                'nom_dev' => $request->input('nom_dev'),
                'prenom_dev' => $request->input('prenom_dev'),
                'niveau_experience' => $request->input('niveau_experience'),
                'specialite_dev' => $request->input('specialite_dev'),
                'description' => $request->input('description'),
                'photo' => $photo,
                'cv' => $cv,
                'portfolio' => $portfolio,
            ]);

            //envoie du mail de bienvenue
            Mail::to($dev->email_dev)->send(new WelcomeEmail([
            'name' => $dev->prenom_dev . ' ' . $dev->nom_dev,
            'email' => $dev->email_dev
        ]));
            //redirection vers la vue du dev enregistré en base
            Auth::guard('dev')->login($dev);
            return redirect()->route('devs.index')->with('success', 'Inscription développeur réussie');
        }

        if ($request->input('type') === 'entreprise') {

            $request->validate([
                'email' => 'required|email|unique:entreprise,email_entreprise',
                'password' => 'required|min:6|confirmed',
                'nom_entreprise' => 'required|string|max:255',
                'taille_entreprise' => 'required|string|max:255',
                'secteur_entreprise' => 'required|string|max:255',
                'type_freelance' => 'required|in:front,back,fullstack',
            ]);

            $entreprise = Entreprise::create([
                'id_entreprise' => (string) Str::uuid(),
                'email_entreprise' => $request->input('email'),
                'password_entreprise' => Hash::make($request->input('password')),
                'nom_entreprise' => $request->input('nom_entreprise'),
                'taille_entreprise' => $request->input('taille_entreprise'),
                'secteur_entreprise' => $request->input('secteur_entreprise'),
                'type_freelance' => $request->input('type_freelance'),
            ]);
             Mail::to($entreprise->email_entreprise)->send(new WelcomeEmail([
            'name' => $entreprise->nom_entreprise,
            'email' => $entreprise->email_entreprise
        ]));

            Auth::guard('entreprise')->login($entreprise);

            return redirect()->route('entreprises.index')->with('success', 'Inscription entreprise réussie');
        }

        return back()->withErrors(['type' => 'Type utilisateur invalide']);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Connexion dev
        $dev = Dev::where('email_dev', $request->input('email'))->first();
        if ($dev && Hash::check($request->input('password'), $dev->password_dev)) {
            Auth::guard('dev')->login($dev);
            return redirect()->route('devs.index');
        }

        // Connexion entreprise
        $entreprise = Entreprise::where('email_entreprise', $request->input('email'))->first();
        if ($entreprise && Hash::check($request->input('password'), $entreprise->password_entreprise)) {
            Auth::guard('entreprise')->login($entreprise);
            return redirect()->route('entreprises.index');
        }

        return back()->withErrors(['email' => 'Email ou mot de passe incorrect']);
    }

    public function logout()
    {
        if (Auth::guard('dev')->check()) {
            Auth::guard('dev')->logout();
        } elseif (Auth::guard('entreprise')->check()) {
            Auth::guard('entreprise')->logout();
        }

        return redirect('/login');
    }
}
