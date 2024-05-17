<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\establishment;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EmploiStrictureModel;
use App\Models\main_emploi;
use Illuminate\Support\Facades\Session;

class auth_controller extends Controller

{
    public function index()
    {
        return view('auth.create-account');
    }

    // create an  account
    public function create_account(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'required',
            'user_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required',
            'name_establishment' => 'required'
        ]);
        $establishment = Establishment::create([
            'name_establishment' => $validatedData['name_establishment']
        ]);
        $user = User::create([
            'id' => $validatedData['id'],
            'user_name' => $validatedData['user_name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'role' => $validatedData['role'],
            'establishment_id' => $establishment->id // Assigning the establishment's ID to the user's establishment_id
        ]);
        Setting::create([
            'userId'      => $validatedData['id'],
            'typeSession' => false,
            'module'      => false,
            'formateur'   => false,
            'salle'       => false,
            'typeSalle'   => false
        ]);
        EmploiStrictureModel::create([
            'user_id' => $validatedData['id'],
            'groupe' => '1',
            'formateur' => "1",
            'toutFormateur' => "1",
            'toueGroupe' => "1"
        ]);

        if ($user) {
            return redirect()->route('login')->with('success', 'Account created successfully');
        } else {
            return redirect()->route('create-account')->with('error', 'Failed to create account');
        }
    }
    // login
    public function login(Request $request)
    {
        // Validate request data
        $credentials = $request->validate([
            'id' => ['required'],
            'password' => ['required'],
        ]);

        // Remove extra spaces from 'id' key to ensure consistency
        $credentials['id'] = trim($credentials['id']);

        // Attempt authentication for admin role
        if (Auth::attempt(['id' => $credentials['id'], 'password' => $credentials['password'], 'role' => 'admin'])) {
            $request->session()->regenerate();
            // store id in session
            $user = auth::user();
            
            session(
                [
                    'user_name' => $user->user_name,
                    'user_id' => $user->id,
                    'establishment_id' => $user->establishment_id
                ]
            );
            $lastEmploiCreated = main_emploi::where('establishment_id', $user->establishment_id)
                ->latest()
                ->first();

            if (!empty($lastEmploiCreated)) {
                session(['id_main_emploi' => $lastEmploiCreated->id]);
            }

            return redirect()->route('dashboardAdmin');
        }
        // Attempt authentication for formateur role
        elseif (Auth::attempt(['id' => $credentials['id'], 'password' => $credentials['password'], 'role' => 'formateur'])) {
            $user = Auth::user();
            if ($user->status == 'active') {
                $request->session()->regenerate();
                // store id in session
                session(['user_id' => $user->id, 'establishment_id' => $user->establishment_id]);
                
                return redirect()->route('dashboard_formateur');
            } else {
                return redirect()->back()->withErrors(['errors' => 'Votre compte est suspendu, veuillez contacter le directeur']);
            }
        }
        // Authentication failed
        else {
            return back()->withErrors([
                'id' => 'The provided credentials do not match our records.',
            ])->onlyInput('id');
        }
    }

    // logout

    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();

        // Redirect to the home page or any other desired page
        return redirect('/');
    }
}
