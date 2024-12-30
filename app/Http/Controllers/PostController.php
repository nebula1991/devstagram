<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;



class PostController extends Controller {
    
    public function __construct()
    {
        $this->middleware('auth')->except(['show', 'index']);
    }


    public function index(User $user)
    {
        // dd('Desde Muro');
        // dd(Auth::user());
         
        $posts = Post::where('user_id', $user->id)->latest()->paginate(20);

        

        return view('dashboard', [
            'user' => $user,
            'posts' => $posts
        ]);
    }

    public function create()
    {
       return view('posts.create');
    }

    public function store(Request $request)
    {

 
        // dd('Creando');

        $validated = $request->validate([
            'titulo' => 'required|max:255',
            'descripcion' => 'required',
            'imagen' => 'required'
        ]);

        // Post::create([
        //     'titulo' => $request->titulo,
        //     'descripcion' => $request->descripcion,
        //     'imagen' => $request->imagen,
        //     'user_id' => auth()->user()->id
        // ]);

           //Otra forma
        //    $post = new Post;
        //    $post->titulo = $request->titulo;
        //    $post->descripcion = $request->descripcion;
        //    $post->imagen = $request->imagen;
        //    $post->user_id = auth()->user()->id;


        $request->user()->posts()->create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' => auth()->user()->id
        ]);

        return redirect()->route('posts.index', auth()->user()->username);

     
    }

    public function show(User $user,Post $post)
    {
        return view('posts.show', [
            'post' => $post,
            'user' => $user
        ]);
    }

 
    public function destroy(Request $request,Post $post)
    {
        // dd('Eliminando', $post->id);

        // if($post->user_id === auth()->user()->id){
        //     dd('Si es la misma persona');
        // }else{
        //     dd('No es la misma persona');
        // }

        
        
            // $img_path = public_path('uploads/'. $post->imagen);
     
            // if(File::exists($img_path)) {
            //     unlink($img_path);
            // }

       
     
           
     
            // return redirect()->route('post.index', Auth::user()->username);
        
    }



   
        
}
