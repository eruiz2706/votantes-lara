<template>
<div>
    <div class="row mb-2">
      <div class="col-sm-6">
        <h3>Lideres</h3>
      </div>
      <div class="col-sm-6">
      </div>
    </div>

    <div class="row">

      <div class="col-md-12">
        <div class="card">
                  <div class="card-header">
                    <h3 class="card-title">Listado de Lideres</h3>
                    <div class="card-tools">
                      <div class="input-group input-group-sm">
                        <input type="text" class="form-control" placeholder="">
                        <div class="input-group-append">
                          <div class="btn btn-primary">
                            <i class="fa fa-search"></i>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body table-responsive p-0">
                    <table class="table table-hover">
                      <thead>
                        <tr>
                          <th>Acciones</th>
                          <th>Documento</th>
                          <th>Nombre</th>
                          <th>Votantes</th>
                          <th>Categoria Votantes</th>
                          <th>Votantes Censo</th>
                          <th>Categoria Censo</th>
                          <th>Maneja Publicidad.</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="lista in listaLideres">
                          <td>ver votantes</td>
                          <td v-text="lista.documento"></td>
                          <td v-text="lista.nombre"></td>
                          <td v-text="lista.cantidadvotantes"></td>
                          <td>
                            <p class="text-success text-xl" v-if="lista.cantidadvotantes>=21"><i class="fa fa-square"></i></p>
                            <p class="text-warning text-xl" v-if="lista.cantidadvotantes>=11 && lista.cantidadvotantes<=20"><i class="fa fa-square"></i></p>
                            <p class="text-danger text-xl"><i class="fa fa-square" v-if="lista.cantidadvotantes<=10"></i></p>
                          </td>
                          <td >.</td>
                          <td >.</td>
                          <td v-text="lista.cantpublicidad"></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <!-- /.card-body -->
      </div>
      </div>

        <div class="col-md-4">
          <div class="card">
                <div class="card-header no-border">
                  <h3 class="card-title">Categorias lideres</h3>
                </div>
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                    <p class="text-success text-xl">
                      <i class="fa fa-square"></i>
                    </p>
                    <p class="d-flex flex-column text-right">
                      <span class="font-weight-bold">
                        21 votantes en adelante
                      </span>
                      <span class="text-muted">Lider</span>
                    </p>
                  </div>
                  <!-- /.d-flex -->
                  <div class="d-flex justify-content-between align-items-center border-bottom mb-3">
                    <p class="text-warning text-xl">
                      <i class="fa fa-square"></i>
                    </p>
                    <p class="d-flex flex-column text-right">
                      <span class="font-weight-bold">
                        11 a 20 votantes
                      </span>
                      <span class="text-muted">Colaborador</span>
                    </p>
                  </div>
                  <!-- /.d-flex -->
                  <div class="d-flex justify-content-between align-items-center mb-0">
                    <p class="text-danger text-xl">
                      <i class="fa fa-square"></i>
                    </p>
                    <p class="d-flex flex-column text-right">
                      <span class="font-weight-bold">
                        1 a 10 votantes
                      </span>
                      <span class="text-muted">Amigos</span>
                    </p>
                  </div>
                  <!-- /.d-flex -->
                </div>
              </div>
        </div>
      </div> 
</div>
</template>

<script>
export default {
  mounted() {
    
  
  },created : function(){
    this.baseUrl=base_url;
    this.getListaLideres();
  },data: function () {
    return {
      baseUrl : '',
      listaLideres:[],
      votosLideres : 0,
      votosIndependientes : 0
    }
  },methods : {
    getGrafLider: function(){
      var url =this.baseUrl+'/votantes/infografLider';
      let inst=this;
      this.listaLideres=[];
      axios.post(url,this.objVotante).then(response =>{
        console.log(response.data);
        this.listaLideres= response.data.listaLideres;
      }).catch(error =>{
      });
    },
    getListaLideres:function(){
      var url =this.baseUrl+'/votantes/listadoLideres';
      let inst=this;
      this.listaLideres=[];
      axios.post(url,this.objVotante).then(response =>{
        console.log(response.data);
        this.listaLideres= response.data.listaLideres;
      }).catch(error =>{
      });
    },
    getInfo:function(){
      var url =this.baseUrl+'/votantes/listadoLideres';
      let inst=this;
      this.listaLideres=[];
      axios.post(url,this.objVotante).then(response =>{
        this.listaLideres=response.data.listaLideres;
      }).catch(error =>{
      });
    },
  }
}
</script>
