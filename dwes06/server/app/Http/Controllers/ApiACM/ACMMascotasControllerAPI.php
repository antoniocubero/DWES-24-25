<?php

namespace App\Http\Controllers\ApiACM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiACM\Auth;
use App\Models\MascotaACM;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;


class ACMMascotasControllerAPI extends Controller
{
    //Metodo para obtener el listado de mascotas
    public function listarMascotasACM(Request $request): JsonResponse{
        $mascotas = $request->user()->mascotas()->select('id','nombre','descripcion','tipo','publica','megusta')->get();
        return response($mascotas);//Laravel lo transforma a json automaticamente por lo que no hay que aplicarle json()
    }

    //Metodo para validar y crear una mascota nueva
    public function crearMascotaACM(Request $request): JsonResponse{
        //Creamos un validator y le establecemos los parametros para la validacion
        $validator = Validator::make($request->all(),
            ['nombre' => 'required|string|max:50',
            'descripcion' => 'required|string|max:250',
            'publica' => 'required|string|in:Si,No',
            'tipo' => 'required|string|in:Perro,Gato,Pájaro,Dragón,Conejo,Hamster,Tortuga,Pez,Serpiente'
            ],//Establecemos los errores personalizados
            ['nombre.required'=>'El campo nombre es requerido',
            'nombre.max'=>'El nombre no puede tener mas de 50 caracteres',
            'descripcion.required'=>'El campo descripcion es requerido',
            'descripcion.max'=>'El descripcion no puede tener mas de 250 caracteres',
            'publica.required'=>'El campo publica es requerido',
            'publica.in'=>'El valor de publica no es valido',
            'tipo.required'=>'El campo tipo es requerido',
            'tipo.in'=>'El valor del tipo de mascota no es valido',
            ]
        );

        //Si el validator no valida los datos devuelve el codigo 400 con los errores que hubiese
        if($validator->fails()){
            return response()->json([
                'mensaje'=>'Datos incorrectos',
                'errores'=>$validator->errors()->all()
            ], 400);
        }

        //Si se validan los datos creamos una mascota y la guardamos en la base de datos
        if ($validator->passes()) {
            $m = new MascotaACM;
            $m->user_id=auth()->id();
            $m->nombre=$request['nombre'];
            $m->descripcion=$request['descripcion'];
            $m->tipo=$request['tipo'];
            $m->publica=$request['publica'];
            $m->save();
            
            //una vez guardada la mascota, devolvemos un json con el id de la mascota, mi nombre y el codigo 200 en la respuesta
            return response()->json([
                'id_mascota'=>$m->id,
                'implementador'=>'Antonio Cubero Martinez'],
                200);
        }
    }

    //Metodo para modificar una masctoa
    public function cambiarMascotaACM(int $mascota, Request $request): JsonResponse{

        //Comprobamos que recibimos un json y si no devolvemos un error con el codigo 400
        if(!$request->isJson()){
            return response()->json([
                'mensaje'=>'Datos incorrectos',
                'errores'=>['Los datos recibidos no son formato JSON']
            ],400);
        }

        //Convertimos los datos a array
        $datos = $request->json()->all();

        try {
            // Busca la mascota y si no la encuentra lanzara el 404 pero lo capturamos en el trycatch y le añadimos un mensaje
            $m = MascotaACM::findOrFail($mascota);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'mensaje' => 'Mascota no encontrada'
            ], 404);
        }

        //Si el id del usuario de la mascota no es el mismo que el del usuario logeado lanza el 403
        if($m->user_id!=auth()->user()->id){
            return response()->json([
                'mensaje'=>'No puedes modificar una mascota que no es tuya'
            ],403);
        }

        //Creamos un validator para validar los datos pasados
        $validator = Validator::make($request->all(),
            ['descripcion' => 'required|string|max:250',
            'publica' => 'required|string|in:Si,No',
            ],
            ['descripcion.required'=>'El campo descripción es requerido',
            'descripcion.max'=>'El descripción no puede tener mas de 250 caracteres',
            'publica.required'=>'El campo pública es requerido',
            'publica.in'=>'El valor de pública no es válido',
            ]);

        //Si falla la validacion devolvemos los errores y el codigo 400
        if($validator->fails()){
            return response()->json([
                'mensaje'=>'Datos incorrectos',
                'errores'=>$validator->errors()->all()
            ],400);
        }

        //Esto no se especifica en la tarea, pero en la captura de HTTPie se muestra esto, asi que lo he añadido
        if ($m->descripcion==$datos['descripcion'] && $m->publica==$datos['publica']) {
            return response()->json([
                'mensaje'=>'No se ha modificado la mascota, los datos son los mismos'
            ],200);
        }

        //Actualizamos los datos
        $m->update($datos);

        //Devolvemos el codigo 200 y un mensaje de que los datos han sido validados correctamente
        return response()->json([
            'mensaje'=>'Datos cambiados correctamente'
        ],200);
    }

    public function borrarMascotaACM($mascota){
        //Comprobamos que sea de tipo numerico
        if (!is_numeric($mascota)) {
            return response()->json([
                'error'=>'El id de la mascota debe ser un número entero'
            ],400);
        }

        try {
            // Busca la mascota y si no la encuentra lanzara el 404 pero lo capturamos en el trycatch y le añadimos un mensaje devolviendo el codigo 200
            $m = MascotaACM::findOrFail($mascota);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => 'No se ha eliminado ninguna mascota'
            ], 200);
        }

        //Comprobamos que la mascota es del usuario logeado y si no lo es devolvemos el codigo 200
        if($m->user_id!=auth()->user()->id){
            return response()->json([
                'error'=>'No se ha eliminado ninguna mascota'
            ],200);
        }

        //Borramos la mascota y devolvemos el mensaje de mascota eliminada con el codigo 200
        $m->delete();
        return response()->json([
            'mensaje'=>'Mascota eliminada correctamente'
        ],200);
    }
}
