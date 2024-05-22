<?php

namespace App\Http\Controllers;

use App\Class\Filters\Filters;
use App\Models\Homeworks;
use Error;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    //funcion obtener datos
    public function index(Request $r){
        $u=(new Filters)->filterU($r);
        return response()->json(['status'=>200,'response'=>$u]);
    }

    //funcion crear/ actualizar tareas
    public function create_u(Request $r){

        DB::beginTransaction();
        try{
            $h= $r->id?Homeworks::find($r->id):new Homeworks;

            $h->fill([
                'id_user'=>$r->id_user,
                'homework'=>$r->homework,
                'details'=>$r->details,
                'status'=>$r->status?$r->status:0,
                ])->save();
         DB::commit();
         return response()->json(['status'=>200,'response'=>$h]);
        }catch(Error $e){
        DB::rollback();
        return response()->json(['status'=>500,'response'=>$e]);
        }
    }

    public function delete(Request $r){
        try{
            $h= Homeworks::find($r->id);
            $h->delete();
            return response()->json(['status'=>200,'response'=>'Done!']);
        }catch(Error $e){
            return response()->json(['status'=>500,'response'=>$e]);
        }
    }



}
