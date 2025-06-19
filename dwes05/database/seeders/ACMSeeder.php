<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\MascotaACM;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ACMSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Creamos los usuarios si no existen
        if (User::where('name','ACM1')->count()==0) {
            $u = new User;
            $u->name='ACM1';
            $u->email='ACM1@email.ACM';
            $u->password=Hash::make('ACM1');
            $u->email_verified_at=now();
            $u->save();
        }

        if (User::where('name','ACM2')->count()==0) {
            $u = new User;
            $u->name='ACM2';
            $u->email='ACM2@email.ACM';
            $u->password=Hash::make('ACM2');
            $u->email_verified_at=now();
            $u->save();
        }

        //Comprobamos que existen los usuarios
        if (User::where('name','ACM1')->count()==1) {
            $user_id = User::where('name','ACM1')->first()->id;//Obtenemos el id del usuario
            //Comprobamos que no existen las mascotas, y si no existe la creamos
            if (MascotaACM::where('nombre','Mascota1ACM1')->count()==0) {
                $m = new MascotaACM;
                $m->user_id=$user_id;
                $m->nombre='Mascota1ACM1';
                $m->descripcion='Descripcion de la mascota 1 del usuario ACM1';
                $m->tipo='Gato';
                $m->publica='Si';
                $m->save();
            }

            if (MascotaACM::where('nombre','Mascota2ACM1')->count()==0) {
                $m = new MascotaACM;
                $m->user_id=$user_id;
                $m->nombre='Mascota2ACM1';
                $m->descripcion='Descripcion de la mascota 2 del usuario ACM1';
                $m->tipo='Dragón';
                $m->publica='No';
                $m->save();
            }
        }

        if (User::where('name','ACM2')->count()==1) {
            $user_id = User::where('name','ACM2')->first()->id;
            if (MascotaACM::where('nombre','Mascota1ACM2')->count()==0) {
                $m = new MascotaACM;
                $m->user_id=$user_id;
                $m->nombre='Mascota1ACM2';
                $m->descripcion='Descripcion de la mascota 1 del usuario ACM2';
                $m->tipo='Serpiente';
                $m->publica='No';
                $m->save();
            }

            if (MascotaACM::where('nombre','Mascota2ACM2')->count()==0) {
                $m = new MascotaACM;
                $m->user_id=$user_id;
                $m->nombre='Mascota2ACM2';
                $m->descripcion='Descripcion de la mascota 2 del usuario ACM2';
                $m->tipo='Conejo';
                $m->publica='Si';
                $m->save();
            }
        }
    }
}
