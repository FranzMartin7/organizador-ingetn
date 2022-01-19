<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function datosUser(Request $request)
    {
        
        switch ($request->dato) {
            case 'docentes':   //obsoleto            
                $resultado = User::join('titulos','titulos.id','users.titulo_id')
                ->selectRaw("users.*,
                concat(titulos.tituloAbrev,' ',users.apPaterno) as docAbrev,
                concat(titulos.tituloAbrev,' ',users.name,' ',users.apPaterno,' ',users.apMaterno) as docCompleto")
                ->whereIn('nivele_id', [2,3])
                ->orderBy('titulos.id')
                ->orderBy('users.apPaterno')
                ->get();
                return response()->json($resultado);
                break;
            case 'estudiantes':  //obsoleto             
                $resultado = User::selectRaw("users.*,
                concat(users.apPaterno,' ',users.name) as estAbrev,
                concat(users.apPaterno,' ',users.apMaterno,' ',users.name) as estCompleto")
                ->whereIn('nivele_id', [3,4])
                ->orderBy('users.apPaterno')
                ->orderBy('users.apMaterno')
                ->orderBy('users.name')
                ->get();
                return response()->json($resultado);
                break;
            default:
                # code...
                break;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombres'=> 'required',
            'apellido_paterno'=> 'required',
            'apellido_materno'=> 'required',
            'nivel'=> 'required',
            'email'=> 'required|email||unique:users,email',
            'contraseña'=> 'required',
            'estado'=> 'required',
            'titulo'=> 'required',
        ]);
        $respuesta = User::create([
            'name'=>request('nombres'),
            'apPaterno'=>request('apellido_paterno'),
            'apMaterno'=>request('apellido_materno'),
            'nivele_id'=>request('nivel'),
            'email'=>request('email'),
            'password'=>bcrypt(request('contraseña')),
            'estado_id'=>request('estado'),
            'titulo_id'=>request('titulo'),
        ])->assignRole(Role::find(request('nivel'))->name);
        return response()->json($respuesta);
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $users = User::join('titulos','titulos.id','users.titulo_id')
        ->join('estados','estados.id','users.estado_id')
        ->join('roles','roles.id','users.nivele_id')  
        ->selectRaw("
            concat(users.ApPaterno,' ',users.ApMaterno,' ',users.name) as nombreCompleto,
            users.*,
            roles.name as nivelUsuario,
            estados.estado as estadoUsuario,
            titulos.titulo as tituloUsuario
            ")
        ->orderBy('users.ApPaterno','asc')
        ->orderBy('users.ApMaterno','asc')
        ->orderBy('users.name','asc')
        ->get();
        return response()->json($users);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombres'=> 'required',
            'apellido_paterno'=> 'required',
            'apellido_materno'=> 'required',
            'nivel'=> 'required',
            'email'=> 'required|email',
            /* 'contraseña'=> 'required', */
            'estado'=> 'required',
            'titulo'=> 'required',
        ]);
        User::find($id)->roles()->detach();
        User::find($id)->assignRole(Role::find($request->nivel)->name);
        $respuesta = User::find($id);
        $respuesta->name = request('nombres');
        $respuesta->apPaterno = request('apellido_paterno');
        $respuesta->apMaterno = request('apellido_materno');
        $respuesta->nivele_id = request('nivel');
        $respuesta->estado_id = request('estado');
        $respuesta->titulo_id = request('titulo');
        $respuesta->email = request('email');
        if(!empty(request('contraseña'))){
            $respuesta->password = bcrypt(request('contraseña'));
        }
        $respuesta->save();
        return response()->json($respuesta);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->roles()->detach();
        $respuesta = User::find($id);
        $respuesta->delete();
        return response()->json($id);
    }
}
