<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use \Illuminate\Support\Facades\DB;
use Nette\Utils\Random;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class forgotPassword extends Controller
{
    public function index(){
        return view('auth.forgot-password');
    }
    // recieve email from  page forgotPassword
    public function forgotPassword(Request $request){
        try{
                    // dd($request);
        $request->validate([
            'email'=>'required|email'
        ]);
        $user = User::where(['email'=> $request->email,'role'=>'admin'])->first();

        if(!$user){
            return redirect()->route('ForgotPassword')->withErrors(['errors'=>"Désolé, nous n'avons pas pu trouver votre compte."]);
        }
        $token = str::Random(25);
        DB::table('password_resets')->insert([
            'email'=>$request->email,
            'token'=>$token,
            'created_at'=>Carbon::now()
        ]);
        Mail::send('auth.EmailContent',['token'=>$token] , function($message)use($request){
            $message->to($request->email);
            $message->subject('reset your password !');
        });
        return redirect()->route('ForgotPassword')->with(['success'=>'Vérifiez votre boîte email!']);
        }catch(\Exception $e){
            return redirect()->route('ForgotPassword')->withErrors(['errors'=>'Il y a un problème ,Vérifiez votre réseau']);
        }
    }


    public function resetPasswordView(){
        return view('auth.resetPasswordView');
    }



public function resetPassword(Request $request){
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|min:6',
        'passwordConfirme' => 'required|min:6|same:password'
    ]);
    $isExisteEmail = DB::table('password_resets')->where('email', $request->email)->exists();
    $token =  DB::table('password_resets')->select('token')->where('email', $request->email)->first();
    if (!$isExisteEmail) {
        return redirect()->back()->withErrors(['errors' =>"Vous avez saisi une adresse e-mail qui n'existe pas."]);
    } else {
        if ($request->password === $request->passwordConfirme) {
            User::where('email', $request->email)->update(['password'=>bcrypt($request->password)]);
            DB::table('password_resets')->where('email',$request->email)->delete();
            return redirect()->back()->with(['success'=>'Votre mot de passe a été mis à jour avec succès.']);
        } else {
            return redirect()->back()->withErrors(['errors'=>"Vous avez saisi un mot de passe incorrect"]);
        }
    }
}

}
