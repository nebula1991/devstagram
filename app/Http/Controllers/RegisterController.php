<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index() 
    {
    return view('auth.register');
    }

    public function store(Request $request){

        // dd('Post...'); /**Función de imprimir lo que pases entre parentesis y para la ejecución */
        // dd(request()); /*Comprovar lo que envia el formulario*/ 
        // dd($request->get('username'));

        //Modificar el Request
        $request->request->add(['username' => Str::slug($request->username)]);


        //Validacion
        $request->validate( [
            'name' => 'required|max:30',
            'username' => 'required|unique:users|min:3|max:20',
            'email' => 'required|unique:users|email|max:60',
            'password' => 'required|confirmed|min:6',
             
        ]);


        // dd('Creando Usuario');

        User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        
        //Autenticar un Usuario
        // Auth::attempt([
        //     'email' => $request->email,
        //     'password' => $request->password
        // ]);

        //***Otra forma de autenticar***
        Auth::attempt($request->only('email','password'));

        //Redireccionar al usuario
        return redirect()->route('posts.index');
    }
    
}