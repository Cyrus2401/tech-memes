<?php

namespace App\Http\Controllers;

use App\Models\Meme;
use App\Models\User;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

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

        $memes = Meme::where('statut', 1)->orderBy('updated_at', 'desc')->where('statut', 1)->paginate(10);

        return view('admin.home', ['memes' => $memes]);

    }

    public function admins(){
       $admins = User::whereIn('role', ['admin', 'sadmin'])->orderBy('created_at', 'desc')->get();

       return view('admin.admins', ['admins' => $admins]);
    }

    public function disableAdmin($id){
        if ($id == Auth::id()) {
            return redirect()->route('admins')->with('error', "Vous ne pouvez pas désactiver votre propre compte.");
        }

        $admin = User::find($id);

        $admin->update([
            'statut' => "0"
        ]);

        $success = "L'admin \"". $admin->pseudo  ." (". $admin->email . ")\" a été désactivé";
        
        return redirect()->route('admins')->with('success', $success);

    }

    public function ableAdmin($id){
        if ($id == Auth::id()) {
            return redirect()->route('admins')->with('error', "Vous ne pouvez pas activer votre propre compte.");
        }

        $admin = User::find($id);

        $admin->update([
            'statut' => "1"
        ]);

        $success = "L'admin \"". $admin->pseudo  ." (". $admin->email . ")\" a été activé";
        
        return redirect()->route('admins')->with('success', $success);

    }

    public function myPost(){

        $memes = Meme::where('user_id', Auth::user()->id)->orderBy('updated_at', 'desc')->where('statut', 1)->paginate(10);

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

        $postMeme = Meme::create([
            'title' => $title,
            'image' => '',
            'user_id' => Auth::user()->id
        ]);

        $extension = $image->getClientOriginalExtension();
        $fileName = $postMeme->id . '.' . $extension;
        $image->move(public_path('memes'), $fileName);

        $postMeme->update([
            'image' => 'memes/' . $fileName
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

        $meme = Meme::find($id);

        if ($meme->image) {
            $oldImagePath = public_path($meme->image);
            if (file_exists($oldImagePath)) {
                @unlink($oldImagePath);
            }
        }

        $extension = $image->getClientOriginalExtension();
        $fileName = $meme->id . '.' . $extension;
        $image->move(public_path('memes'), $fileName);

        $meme->update([
            'title' => $title,
            'image' => 'memes/' . $fileName,
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

    public function profile(){
        return view('admin.profile', ['user' => Auth::user()]);
    }

    public function updateProfile(Request $request){
        $user = Auth::user();
        
        $validation = $request->validate([
            'pseudo' => 'required|string|unique:users,pseudo,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
        ], [
            'pseudo.required' => 'Ce champ est requis !',
            'pseudo.string' => 'Pseudo invalide !',
            'pseudo.unique' => 'Ce pseudo existe déjà !',
            'email.required' => 'Ce champ est requis !',
            'email.email' => 'Veuillez entrer une adresse email valide !',
            'email.unique' => 'Cette adresse email est déjà utilisée !',
        ]);

        $user->update([
            'pseudo' => $request->pseudo,
            'email' => $request->email,
        ]);

        return back()->with('success_profile', 'Vos informations de profil ont été modifiées avec succès !');
    }

    public function updatePassword(Request $request){
        $user = Auth::user();

        $validation = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|different:current_password',
            'confirm_password' => 'required|string|same:new_password',
        ], [
            'current_password.required' => 'Ce champ est requis !',
            'new_password.required' => 'Ce champ est requis !',
            'new_password.min' => 'Le nouveau mot de passe doit faire au moins 6 caractères !',
            'new_password.different' => 'Le nouveau mot de passe doit être différent de l\'ancien !',
            'confirm_password.required' => 'Ce champ est requis !',
            'confirm_password.same' => 'La confirmation doit correspondre au nouveau mot de passe !',
        ]);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect !']);
        }

        $user->update([
            'password' => $request->new_password
        ]);

        return back()->with('success_password', 'Votre mot de passe a été modifié avec succès !');
    }

    public function toggleLike($id) {
        if (!Auth::check()) {
            return response()->json(['error' => 'auth_required'], 401);
        }

        $user = Auth::user();
        $meme = Meme::find($id);

        if (!$meme) {
            return response()->json(['error' => 'meme_not_found'], 404);
        }

        $like = Like::where('user_id', $user->id)->where('meme_id', $id)->first();

        if ($like) {
            $like->delete();
            $liked = false;
        } else {
            Like::create([
                'user_id' => $user->id,
                'meme_id' => $id
            ]);
            $liked = true;
        }

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'count' => $meme->likes()->count()
        ]);
    }

}


