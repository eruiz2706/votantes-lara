<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Validator;
use Log;
class VotantesController extends Controller
{

  public function __construct(){
    
  }

  /*Informacion Estadisticas de campaña*/
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
                                  where puesto_id is not null
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

    $dataMesas = DB::select("select
                              sum(convotacion) as convotacion,sum(totalmesas) as totalmesas
                              from( 
                                select
                                  count(v.id) as convotacion,0 as totalmesas
                                from(
                                  select p.id,v.mesa
                                  from votantes v
                                  inner join puestos p on(v.puesto_id=p.id)
                                  where v.puesto_id is not null
                                  group by p.id,v.mesa
                                ) as v
                                union
                                select 0 as convotantes,sum(p.mesas) as totalmesas
                                from puestos p
                              ) as f");

    $convotantes = 0;                           
    $sinvotantes = 0;
    if(!empty($dataMesas)){
      $convotantes = $dataMesas[0]->convotacion;                           
      $sinvotantes = $dataMesas[0]->totalmesas - $dataMesas[0]->convotacion;
    }

    
   $dataCenso = DB::select("select
                                  id,nombre,sum(cantidad) as cantidad
                                  from(
                                    select p.id,p.nombre as nombre,count(v.id) as cantidad
                                    from votantes v
                                    left join puestos p on(v.puesto_id=p.id)
                                    where v.puesto_id is not null
                                    group by p.id,p.nombre
                                  ) as v
                                  group by id,nombre  
                                  order by sum(cantidad) desc");
    return response()->json([
        'grafCenso' => $dataCenso,
        'grafMesas' => [
          'convotantes' => $convotantes,
          'sinvotantes' => $sinvotantes
        ]
    ]);
  }

  //listado de lideres
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

  //listado de barrios
  public function getBarrios(Request $request){
    $listaBarrios   =DB::select("select id,nombre,comuna
                                  from barrios
                                  order by nombre asc");

    return response()->json([
        'listaBarrios' => $listaBarrios,
    ]);
  }

  //listado de puestos
  public function getPuestos(Request $request){
    $listaPuestos   =DB::select("select id,nombre,mesas
                                  from puestos
                                  order by nombre asc");

    return response()->json([
        'listaPuestos' => $listaPuestos,
    ]);
  }

  //listado de puestos
  public function getMesas(Request $request){
    $resultado = DB::select("select mesas
                          from puestos
                          where id=:id",['id'=>$request->id]);
        
    $mesas = 0;
    if(!empty($resultado)){
      $mesas = $resultado[0]->mesas;    
    }
    
    $listaMesas= [];
    if($mesas > 0){
      for($contador=1;$contador<=$mesas;$contador++){
        $listaMesas[]=['id'=>$contador,'nombre'=>'Mesa '.$contador];
      }
    }

    return response()->json([
      'listaMesas' => $listaMesas,
    ]);
  }
  
  //guardar un nuevo votante
  public function guardar(Request $request){
    
    $validator =Validator::make($request->all(),[
        'documento' =>'required|integer|unique:votantes',
        'nombre' =>'required|min:5',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->messages(),
        ], 400);
    }
    
    
    DB::beginTransaction();
    try{

      $idlider = ($request->lider) ? null : $request->idlider;
      $puesto_id = ($request->puesto_id=='') ? null : $request->puesto_id;
      
      $idvotante=DB::table('votantes')->insertGetId([
        'documento'=>$request->documento,
        'nombre'=>$request->nombre,
        'telefono'=>$request->telefono,
        'direccion'=>$request->direccion,
        'barrio_id'=>$request->barrio,
        'lider'=>$request->lider,
        'idlider'=>$idlider,
        'publicidad'=>$request->publicidad,
        'puesto_id'=>$puesto_id,
        'mesa'=>$request->mesa
      ]);
     
      DB::commit();
      return response()->json([
          'message' => 'Registro creado correctamente!',
          'message2' => 'Click para continuar!'
      ]);
    }
    catch(\Exception $e){
        //Log::info('creacion votante : '.$e->getMessage());
        DB::rollback();
        return response()->json([
            'error' =>'Hubo una inconsistencias al intentar crear el registro'
        ], 400);
    }
  }

  //mesas que hacen parte de un puesto de votacion con votantes
  public function getVotacionPuesto(Request $request){
        $dataPuesto = DB::select("select 
                                  v.mesa,count(v.id) as cantidad
                                  from votantes v
                                  where v.puesto_id=:puesto_id
                                  group by v.mesa
                                  order by v.mesa
                                  ",['puesto_id'=>$request->id]);
      return response()->json([
        'dataPuesto' => $dataPuesto,
      ]);
  }

  //listado de votantes
  public function getListaVotantes(Request $request){
    $votantes   =DB::select("select
                              v.id,v.documento,v.nombre,v.telefono,v.direccion,b.nombre as nombre_barrio,v.lider,v.idlider,l.nombre as nombre_lider,v.publicidad,p.nombre as puesto,v.mesa
                              from votantes v
                              left join barrios b on(v.barrio_id=b.id)
                              left join votantes l on(v.idlider=l.id)
                              left join puestos p on(v.puesto_id=p.id)");

    return response()->json([
        'listaVotantes' => $votantes,
    ]);
  }

  //lista de lideres
  public function getListaLideres(Request $request){
    $listaLideres   =DB::select("select
                                    l.documento,l.nombre,l.telefono,l.direccion,l.nombre_barrio,
                                    sum(cantidadvotantes) as cantidadvotantes,sum(cantpublicidad) as cantpublicidad,id,sum(cantcenso) as cantcenso
                                  from(
                                    select
                                      'votantes_lider' as tipo,l.documento,l.nombre,l.telefono,l.direccion,b.nombre as nombre_barrio,
                                      count(v.id) as cantidadvotantes,sum(case when v.publicidad=true then 1 else 0 end) as  cantpublicidad,l.id,
                                      sum(case when v.puesto_id is null then 0 else 1 end) as cantcenso
                                    from votantes l
                                    left join votantes v on(l.id=v.idlider)
                                    left join barrios b on(l.barrio_id=b.id)
                                    where l.lider = :lider
                                    group by 
                                    l.documento,l.nombre,l.telefono,l.direccion,b.nombre,l.id
                                    union
                                    select 
                                      'lider' as tipo,l.documento,l.nombre,l.telefono,l.direccion,b.nombre as nombre_barrio,
                                      count(l.id) as cantidadvotantes,sum(case when l.publicidad=true then 1 else 0 end) as cantpublicidad,l.id,
                                      sum(case when l.puesto_id is null then 0 else 1 end) as cantcenso
                                    from votantes l
                                    left join barrios b on(l.barrio_id=b.id)
                                    where l.lider = :lider
                                    group by 
                                    l.documento,l.nombre,l.telefono,l.direccion,b.nombre,l.id
                                  ) as l
                                  group by l.documento,l.nombre,l.telefono,l.direccion,l.nombre_barrio,l.id",
                                  ['lider'=>true]);

    return response()->json([
        'listaLideres' => $listaLideres
    ]);
  }

  public function getVotantesLider(Request $request){
    $dataVotantes  =DB::select("select v.id,v.documento,v.nombre,v.telefono,v.direccion,b.nombre as barrio,p.nombre as puesto,v.mesa
                          from votantes v
                          left join barrios b on(v.barrio_id=b.id)
                          left join puestos p on(v.puesto_id=p.id)
                          where v.idlider = :idlider or v.id = :idlider
                          order by idlider desc",['idlider'=>$request->id]);

    return response()->json([
      'dataVotantes' => $dataVotantes
    ]);
  } 

  public function getVotantesSinPuesto(Request $request){
    $dataSinpuesto  =DB::select("select v.id,v.documento,v.nombre,v.telefono
                                from votantes v
                                where v.puesto_id is null
                                ");
    return response()->json([
      'dataSinpuesto' => $dataSinpuesto
    ]);
  }

  public function deleteVotante(Request $request){
   
    ############guardar datos ########
    DB::beginTransaction();
    try{
      DB::table('votantes')->where('idlider',$request->id)->update([
        'idlider'=>null
      ]);

      DB::table('votantes')->where('id','=',$request->id)->delete();

      DB::commit();
      return response()->json([
          'message' => 'Se elimino el votante correctamente!',
          'message2' => 'Click para continuar!'
      ]);
    }
    catch(\Exception $e){
        DB::rollback();
        return response()->json([
            'error' =>'Hubo una inconsistencias al intentar realizar el proceso'
        ], 400);
    }
  }

  public function editarVotante(Request $request){
    $votante   =DB::select("select 
                            id,documento,nombre,telefono,direccion,lider,publicidad,idlider,barrio_id as barrio,puesto_id,mesa
                            from votantes
                            where id = :id",
                          ['id'=>$request->id])[0];
    return response()->json([
      'votante' => $votante
    ]);
  }

  public function actualizar(Request $request){
    
    $validator =Validator::make($request->all(),[
        'nombre' =>'required|min:5',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->messages(),
        ], 400);
    }

    $validaDocum = DB::select("select id
                              from votantes 
                              where documento =:documento and id<>:id
                          ",['documento'=>$request->documento,'id'=>$request->id]);
    if(!empty($validaDocum)){
      return response()->json([
        'error' => 'El documento ya se encuentra registrado a otro votante'
    ], 400);
    }
    
    DB::beginTransaction();
    try{

      $idlider = ($request->lider) ? null : $request->idlider;
      $puesto_id = ($request->puesto_id=='') ? null : $request->puesto_id;
      
      DB::table('votantes')->where('id',$request->id)->update([
        'documento'=>$request->documento,
        'nombre'=>$request->nombre,
        'telefono'=>$request->telefono,
        'direccion'=>$request->direccion,
        'barrio_id'=>$request->barrio,
        'lider'=>$request->lider,
        'idlider'=>$idlider,
        'publicidad'=>$request->publicidad,
        'puesto_id'=>$puesto_id,
        'mesa'=>$request->mesa
      ]);

     
      DB::commit();
      return response()->json([
          'message' => 'Registro actualizado correctamente!',
          'message2' => 'Click para continuar!'
      ]);
    }
    catch(\Exception $e){
        DB::rollback();
        return response()->json([
            'error' =>'Hubo una inconsistencias al intentar crear el registro'.$e->getMessage()
        ], 400);
    }
  }

  public function getVotantesconMesas(Request $request){
    $dataMesas   =DB::select("select
                                p.id,p.nombre as puesto,v.mesa,count(v.id) as cantidad
                                from votantes v
                                inner join puestos p on(v.puesto_id=p.id)
                                where v.puesto_id is not null
                                group by p.id,p.nombre,v.mesa
                                order by p.nombre,v.mesa asc");
    return response()->json([
      'dataMesas' => $dataMesas
    ]);
  }
}
