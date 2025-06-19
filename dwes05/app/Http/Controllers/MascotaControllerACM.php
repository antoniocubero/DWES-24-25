<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\MascotaACM;


class MascotaControllerACM extends Controller
{
    //Controlador para mostrar el formulario de nueva mascota
    public function mostrarFormularioNuevaMascotaACM(){
        return view('privada.formmascotaACM');
    }

    //Controlador para validar los datos de la mascota
    public function validarNuevaMascotaACM(Request $request){
        $datosvalidados = $request->validate([//Validamos los datos que recibimos
            'nombre' => 'required|string|max:50',
            'descripcion' => 'required|string|max:250',
            'publica' => 'required|string|in:Si,No',
            'tipo' => 'required|string|in:Perro,Gato,Pájaro,Dragón,Conejo,Hamster,Tortuga,Pez,Serpiente'
        ],[//Creamos el texto personalizado para cada error
            'nombre.required'=>'El campo nombre es requerido',
            'nombre.max'=>'El nombre no puede tener mas de 50 caracteres',
            'descripcion.required'=>'El campo descripcion es requerido',
            'descripcion.max'=>'El descripcion no puede tener mas de 250 caracteres',
            'publica.required'=>'El campo publica es requerido',
            'publica.in'=>'El valor de publica no es valido',
            'tipo.required'=>'El campo tipo es requerido',
            'tipo.in'=>'El valor del tipo de mascota no es valido',
        ]);

        //Creamos la mascota y le añadimos los datos y la guardamos en la base de datos
        $m = new MascotaACM;
        $m->user_id=auth()->id();
        $m->nombre=$datosvalidados['nombre'];
        $m->descripcion=$datosvalidados['descripcion'];
        $m->tipo=$datosvalidados['tipo'];
        $m->publica=$datosvalidados['publica'];
        $m->save();

        //Mostramos la vista de mascota creada devolviendo la mascota
        return view('privada.mascotacreada', ['mascota'=>$m]);
    }


    //Controlador para cambiar la privacidad de la mascota
    public function cambiarPrivacidadACM(Request $request){
        $idvalidado = $request->validate([//Validamos el id y comprobamos que existe en la base de datos
            'id'=>'required|exists:mascotas,id'
        ]);

        //Obtenemos la mascota que tenga el id pasado por el input hidden y le añadimos un filtro para comprobar que esa mascota tiene el user_id igual al del usuario autenticado, asi evitamos que no se puedan cambiar la privacidad de las mascotas de otros usuarios
        $mascota = MascotaACM::where('id',$idvalidado['id'])->where('user_id', auth()->id())->first();

        //Comprobamos que se ha obtenido una mascota
        if (!$mascota) {
            //Si no se ha obtenido volvemos a la zona privada y devolvemos el error de que no puede modificar la mascota de otro usuario
            return redirect(route('zonaprivada'))->withErrors([
                'error'=>'No puedes modificar la privacidad de esta mascota'
            ]);
        }

        //Cambiamos la privacidad de la mascota con un simple ternario y la actualizamos con save()
        $mascota->publica = $mascota->publica == 'Si' ? 'No' : 'Si';
        $mascota->save();

        //Cargamos la vista de que se ha completado y devolvemos la mascota cambiada
        return view('privada.mascotaprivacidadcambiada',['mascota'=>$mascota]);

    }
}
