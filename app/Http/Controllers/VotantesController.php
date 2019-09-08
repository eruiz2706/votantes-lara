<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Validator;
use Log;

class VotantesController extends Controller
{
  //guardar un nuevo votante
  public function guardar(Request $request){
    
    $validator =Validator::make($request->all(),[
        'documento' =>'required|integer|unique:votantes',
        'nombre' =>'required|min:5',
        'telefono' =>'required|min:5',
        'direccion' =>'required|min:5'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->messages(),
        ], 400);
    }
    
    
    DB::beginTransaction();
    try{

      $idlider = ($request->lider) ? null : $request->idlider;
      
      $idvotante=DB::table('votantes')->insertGetId([
        'documento'=>$request->documento,
        'nombre'=>$request->nombre,
        'telefono'=>$request->telefono,
        'direccion'=>$request->direccion,
        'barrio_id'=>$request->barrio,
        'lider'=>$request->lider,
        'idlider'=>$idlider
      ]);

     
      DB::commit();
      return response()->json([
          'message' => 'Registro creado correctamente!',
          'message2' => 'Click para continuar!'
      ]);
    }
    catch(\Exception $e){
        Log::info('creacion votante : '.$e->getMessage());
        DB::rollback();
        return response()->json([
            'error' =>'Hubo una inconsistencias al intentar crear el registro'.$e->getMessage()
        ], 400);
    }
  }

  public function getLideres(Request $request){
    $lideres   =DB::select("select
                            nombre,id,documento
                            from votantes
                            where lider = :lider
                            order by nombre",
                ['lider'=>true]);

    return response()->json([
        'listaLideres' => $lideres,
    ]);
  }

  public function getListaVotantes(Request $request){
    $votantes   =DB::select("select
                              v.documento,v.nombre,v.telefono,v.direccion,b.nombre as nombre_barrio,v.lider,v.idlider,l.nombre as nombre_lider,v.publicidad
                              from votantes v
                              left join barrios b on(v.barrio_id=b.id)
                              left join votantes l on(v.idlider=l.id)");

    return response()->json([
        'listaVotantes' => $votantes,
    ]);
  }

  public function getListaLideres(Request $request){
    $listaLideres   =DB::select("select
                                  l.documento,l.nombre,l.telefono,l.direccion,l.nombre_barrio,
                                  sum(cantidadvotantes) as cantidadvotantes,sum(cantpublicidad) as cantpublicidad
                                  from(
                                  select
                                  'votantes_lider' as tipo,l.documento,l.nombre,l.telefono,l.direccion,b.nombre as nombre_barrio,
                                  count(v.id) as cantidadvotantes,sum(case when v.publicidad=true then 1 else 0 end) as  cantpublicidad
                                  from votantes l
                                  left join votantes v on(l.id=v.idlider)
                                  left join barrios b on(l.barrio_id=b.id)
                                  where l.lider = :lider
                                  group by 
                                  l.documento,l.nombre,l.telefono,l.direccion,b.nombre
                                  union
                                  select 
                                  'lider' as tipo,l.documento,l.nombre,l.telefono,l.direccion,b.nombre as nombre_barrio,
                                  count(l.id) as cantidadvotantes,sum(case when l.publicidad=true then 1 else 0 end) as cantpublicidad
                                  from votantes l
                                  left join barrios b on(l.barrio_id=b.id)
                                  where l.lider = :lider
                                  group by 
                                  l.documento,l.nombre,l.telefono,l.direccion,b.nombre
                                  ) as l
                                  group by l.documento,l.nombre,l.telefono,l.direccion,l.nombre_barrio
                                  ",
                ['lider'=>true]);

    return response()->json([
        'listaLideres' => $listaLideres
    ]);
  }

  public function getListaBarrios(Request $request){
    $listaBarrios   =DB::select("select id,nombre,comuna
                                  from barrios
                                  order by nombre asc");

    return response()->json([
        'listaBarrios' => $listaBarrios,
    ]);
  }

  public function getCenso(Request $request){
    $censo  =DB::select("select nuid,departamento,municipio,puesto,direccion,mesa
                          from censo
                          where
                          nuid =:nuid"
                     ,['nuid'=>$request->documento]);

    /*if(empty($censo)){
      return view('layouts.errors.not_page');
    }*/

    return response()->json([
      'censo' => $censo
    ]);
    
  }

  public function getInfoGrafLider(Request $request){
    $votantesInd = DB::select("select count(v.id) as independientes
                          from votantes v
                          where idlider is null and lider=false");
                        
    if(empty($votantesInd)){
      $votantesInd =0;
    }else{
      $votantesInd = $votantesInd[0]->independientes;
    }

    $votantesTotales = DB::select("select count(v.id) as totales
                                  from votantes v");

    if(empty($votantesTotales)){
      $votantesTotales =0;
    }else{
      $votantesTotales = $votantesTotales[0]->totales;
    }

    return response()->json([
        'votantesInd' => 10,
        'votantesTotales' => 15,
    ]);
  }

  public function getDashboard(Request $request){
    $dataLideres = DB::select("select
                                sum(lideres) as lideres,sum(totales) as totales
                                from(
                                  select count(v.id) as lideres,0 as totales
                                  from votantes v
                                  where v.lider=true or idlider is not null
                                  union
                                  select 0 as lideres,count(v.id) as totales
                                  from votantes v
                              ) as v");
        
    $lideres = 0;                           
    $independientes = 0;
    if(!empty($dataLideres)){
      $lideres = $dataLideres[0]->lideres;                           
      $independientes = $dataLideres[0]->totales - $dataLideres[0]->lideres;
    }

    $dataCenso = DB::select("select
                              sum(censo) as censo,sum(totales) as totales
                              from(
                                select count(v.id) as censo,0 as totales
                                from votantes v
                                  inner join censo c on(v.documento=c.nuid)
                                union
                                select 0 as censo,count(v.id) as totales
                                from votantes v
                              ) as v");

    $censo = 0;                           
    $sincenso = 0;
    if(!empty($dataCenso)){
      $censo = $dataCenso[0]->censo;                           
      $sincenso = $dataCenso[0]->totales - $dataCenso[0]->censo;
    }

    $dataComuna = DB::select("select 
                                  nombre,comuna,cantidad
                                from(
                                  select b.nombre,b.comuna,count(v.id) as cantidad
                                  from votantes v
                                  right join barrios b on(v.barrio_id=b.id)
                                  group by
                                  b.nombre,b.comuna
                                ) as v
                                order by comuna,cantidad desc");

    $dataPublicidad = DB::select("select 
                                    nombre,cantidad
                                  from(
                                    select b.nombre,sum(case when v.publicidad=true then 1 else 0 end) as cantidad
                                    from votantes v
                                    left join barrios b on(v.barrio_id=b.id)
                                    group by
                                    b.nombre,v.publicidad
                                  ) as v
                                  where cantidad>0
                                  order by cantidad desc,nombre");


    return response()->json([
        'grafCenso' => [
          'censados' => $censo,
          'sincenso' => $sincenso
        ],
        'grafLideres' => [
          'lideres' => $lideres,
          'independientes' => $independientes
        ],
        'grafComunas' => $dataComuna,
        'grafPublicidad' => $dataPublicidad
    ]);
  }

  public function getDashboard2(Request $request){
    
   $dataCenso = DB::select("select
                                  nombre,sum(cantidad) as cantidad
                                  from(
                                    select c.puesto as nombre,count(v.id) as cantidad
                                    from votantes v
                                    inner join censo c on(v.documento=c.nuid)
                                    group by c.puesto
                                  ) as v
                                  group by nombre  
                                  order by sum(cantidad) desc
                              ");

    foreach($dataCenso as $data){

      $dataMesas = DB::select("select 
                                  c.puesto,c.mesa,count(v.id) as cantidad
                                from votantes v
                                inner join censo c on(v.documento=c.nuid)
                                where c.puesto=:puesto
                                group by c.puesto,c.mesa
                                order by count(v.id) desc
                        ",['puesto'=>$data->nombre]);
      $data->mesas=$dataMesas;
    } 

    return response()->json([
        'grafCenso' => $dataCenso
    ]);
  }
   
}
