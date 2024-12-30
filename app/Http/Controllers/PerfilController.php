<?php

namespace App\Http\Controllers;

use App\Models\Post;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Laravel\Facades\Image;



class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        // dd('Aqui se muestra el formulario');

        return view('perfil.index');

    }

    public function store(Request $request)
    {
        // dd('Guardando cambios');
        
        $request->request->add(['username' => Str::slug($request->username)]);

        $request->validate( [
            'username' => ['required','unique:users,username,'.auth()->user()->id,'min:3','max:20','not_in:twitter,editar-perfil'],
        ]);

        if($request->imagen)
        {

            $manager = new ImageManager(new Driver());
            
            $imagen = $request->file('imagen');

            //Generar un id unico para las imagenes
            $nombreImagen = Str::uuid() . "." . $imagen->extension();
    
              //guardar la imagen al servidor
            $imagenServidor = $manager->read($imagen);
            //agregamos efecto a la imagen con intervention
            $imagenServidor->scale(1000,1000);
    
            //agregamos la imagen a la  carpeta en public donde se guardaran las imagenes
            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
            //Una vez procesada la imagen entonces guardamos la imagen en la carpeta que creamos
            $imagenServidor->save($imagenPath);
        }

        //Guardar cambios
        $usuario = User::find(auth()->user()->id);

        $usuario->username = $request->username;
        $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;

        $usuario->save();

        //Redireccionar
        return redirect()->route('posts.index', $usuario->username);
    }
}
