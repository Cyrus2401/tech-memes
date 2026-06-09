<?php

namespace App\Http\Controllers;

use App\Models\Meme;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class myController extends Controller
{
    public function becomeAdmin(){

        return view('auth.register');

    }

    public function register(Request $request){

        $pseudo = $request->pseudo;
        $email = $request->email;
        $password = $request->password;
        $confirm_password = $request->confirm_password;

        $error = "";
        $success = "";

        $validation = $request->validate([

            'pseudo' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|min:6',
            'confirm_password' => 'required|string|min:6',

        ], [
            'pseudo.required' => 'Ce champ est requis !',
            'pseudo.string' => 'Champ invalide !',

            'email.required' => 'Ce champ est requis !',
            'email.email' => 'Champ invalide ! Entrer une adresse mail valide !',

            'password.required' => 'Ce champ est requis !',
            'password.string' => 'Champ invalide !',
            'password.min' => 'Entrer au moins 6 caractères !',

            'confirm_password.required' => 'Ce champ est requis !',
            'confirm_password.string' => 'Champ invalide !',
            'confirm_password.min' => 'Entrer au moins 6 caractères !',
        ]);

        if($password != $confirm_password){
            $error = "Les mots de passes entrés ne sont pas identiques !";
            return back()->with('error', $error)->with('success', $success);
        }

        $checkIfEmailExist = User::where('pseudo', $pseudo)->first();

        if($checkIfEmailExist != null){

            $error = "Ce pseudo existe déjà ! Veuillez en choisir un autre s'il vous plaît !";

        }else{
            
            $admin = User::create([
                        'pseudo' => $pseudo,
                        'email' => $email,
                        'password' => $password
                    ]);

            $success = "Félicitation ! Vous êtes désormais un Admin. Vous pouvez donc alimenter le contenu de notre site.";

        }

        return back()->with('error', $error)->with('success', $success);

    }

    public function loginVue(){

        return view('auth.login');

    }

    public function login(Request $request){

        $pseudo = $request->pseudo;
        $password = $request->password;

        $error = "";

        $validation = $request->validate([
            'pseudo' => 'required|string',
            'password' => 'required|string',
        ], [
            'pseudo.required' => 'Ce champ est requis !',
            'pseudo.string' => 'Champ invalide !',

            'password.required' => 'Ce champ est requis !',
            'password.string' => 'Champ invalide !',
        ]);

        $fieldType = filter_var($pseudo, FILTER_VALIDATE_EMAIL) ? 'email' : 'pseudo';
        $isConnect = Auth::attempt([$fieldType => $pseudo, 'password' => $password]);

        if($isConnect){

            return redirect()->route('adminHome');

        }else{

            $error = "Les identifiants entrés sont incorrects !";
            return back()->with('error', $error);

        }

    }

    public function adminHome(){

        $memes = Meme::where('statut', 1)->orderBy('updated_at', 'desc')->where('statut', 1)->paginate(5);

        return view('admin.home', ['memes' => $memes]);

    }

    public function admins(){
       $admins = User::where('role', 'admin')->orderBy('created_at', 'desc')->get();

       return view('admin.admins', ['admins' => $admins]);
    }

    public function disableAdmin($id){

        $admin = User::find($id);

        $admin->update([
            'statut' => "0"
        ]);

        $success = "L'admin \"". $admin->pseudo  ." (". $admin->email . ")\" a été désactivé";
        
        return redirect()->route('admins')->with('success', $success);

    }

    public function ableAdmin($id){

        $admin = User::find($id);

        $admin->update([
            'statut' => "1"
        ]);

        $success = "L'admin \"". $admin->pseudo  ." (". $admin->email . ")\" a été sactivé";
        
        return redirect()->route('admins')->with('success', $success);

    }

    public function myPost(){

        $memes = Meme::where('user_id', Auth::user()->id)->orderBy('updated_at', 'desc')->where('statut', 1)->paginate(5);

        return view('admin.myPost', ['memes' => $memes]);

    }

    public function postMemeView(){

        return view('admin.postMeme');

    }

    public function postMeme(Request $request){

        $title = $request->title;
        $image = $request->file;

        $validate = $request->validate([
            'file' => 'required|mimes:png,jpeg,jpg,gif|max:2048'
        ]);

        $imagePath = $image->store('memes', 'public');

        $postMeme = Meme::create([
            'title' => $title,
            'image' => $imagePath,
            'user_id' => Auth::user()->id
        ]);

        $success = "Meme posté avec succès !";

        return back()->with('success', $success);
    }

    public function updateMeme($id){
        $meme = Meme::find($id);

        return view('admin.updateMeme', ['meme' => $meme]);
    }

    public function updateMemePost(Request $request, $id){

        $title = $request->title;
        $image = $request->file;

        $validate = $request->validate([
            'file' => 'required|mimes:png,jpeg,jpg,gif|max:2048'
        ]);

        $imagePath = $image->store('memes', 'public');

        $meme = Meme::find($id);

        Storage::disk('public')->delete($meme->image);

        $meme->update([

            'title' => $title,
            'image' => $imagePath,
            'user_id' => Auth::user()->id

        ]);
 
        $success = "Modification éffectuée avec succès !";

        return redirect()->route('adminHome')->with('success', $success);
    }

    public function deletePost($id){

        $meme = Meme::find($id);

        $meme->update([
            'statut' => "0"
        ]);

        $success = "Suppression éffectuée avec succès !";

        return back()->with('success', $success);

    }

}


