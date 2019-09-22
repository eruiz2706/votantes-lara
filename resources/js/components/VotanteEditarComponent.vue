<template>
<div>
    <div class="row">
      <div class="col-sm-6">
        <h3>Editar Votante</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            <router-link to="/votante">
                Ir atras
            </router-link>
          </li>
        </ol>
      </div>
    </div>

    <div class="row">
      <div class="col-sm-12">
        <div class="card">
            <div class="card-header">
              <h3 class="card-title">Votante</h3>
            </div>
            <!-- /.card-header -->
            
            <div class="card-body">
              <div class="callout callout-info">
                <p>
                  <i class="fa fa-fw fa-info"></i>Los campos marcados en <code>*</code> son obligatorios
                </p>
              </div>
                    
              <div class="form-group">
                <label>Documento <code>*</code></label>
                <input type="number" min="1" pattern="^[0-9]+" class="form-control " v-model='objVotante.documento'>
                <span class="text-danger" v-if="errores.documento" v-text='errores.documento[0]'></span>
              </div>

              <div class="form-group">
                <label>Nombre <code>*</code></label>
                <input type="text" class="form-control" v-model='objVotante.nombre'>
                <span class="text-danger" v-if="errores.nombre" v-text='errores.nombre[0]'></span>
              </div>

              <div class="form-group">
                <label>Telefono</label>
                <input type="number" min="1" pattern="^[0-9]+" class="form-control" v-model='objVotante.telefono'>
                <span class="text-danger" v-if="errores.telefono" v-text='errores.telefono[0]'></span>
              </div>

              <div class="form-group">
                <label>Direccion</label>
                <input type="text" class="form-control" v-model='objVotante.direccion'>
                <span class="text-danger" v-if="errores.direccion" v-text='errores.direccion[0]'></span>
              </div>

              <div class="form-group">
                <label>Barrio <code>*</code></label>
                <select  class='form-control' v-model='objVotante.barrio'>
                  <option value="">Seleccion el barrio</option>
                  <option v-bind:value="lista.id" v-for="lista in listaBarrios"><span v-text="lista.nombre"></span></option>
                </select>
                <span class="text-danger" v-if="errores.barrio" v-text='errores.barrio[0]'></span>
              </div>

              <div class="form-group">
                <label>Tiene Publicidad</label>
                <input type="checkbox" value="lider" v-model='objVotante.publicidad'>
              </div>

              <hr>
              <div class="form-group">
                <label>Lider</label>
                <input type="checkbox" value="lider" v-model='objVotante.lider'>
                <select  class='form-control' v-model='objVotante.idlider' v-if='!objVotante.lider'>
                  <option value="">Seleccion el lider</option>
                  <option v-bind:value="lista.id" v-for="lista in listaLideres"><span v-text="lista.nombre+' - '+lista.documento"></span></option>
                </select>
              </div>
              <hr>
              
              <div class="card ">
                <div class="card-header" style="padding: 0.2rem 1.25rem;">
                  <h5 class="card-title" >
                    Lugar de votacion
                  </h5>
                </div> 
                <div class="card-body">
                  <div class="form-group">
                    <label>Puesto</label>
                    <select  class='form-control' v-model='objVotante.puesto_id' @change="cargaMesas(objVotante.puesto_id)">
                      <option value="">Seleccion el Puesto</option>
                      <option v-bind:value="lista.id" v-for="lista in listaPuestos"><span v-text="lista.nombre"></span></option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label>Mesa</label>
                    <select  class='form-control' v-model='objVotante.mesa'>
                      <option value="">Seleccion la mesa</option>
                      <option v-bind:value="lista.id" v-for="lista in listaMesas"><span v-text="lista.nombre"></span></option>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <!-- /.card-body -->

              <div class="card-footer">
                <button type="button" class="btn btn-outline btn-primary" :disabled="loaderGuardar" v-on:click.prevent='actualizar()'>
                  Actualizar
                  <i style='font-size:20px' class="fa fa-spinner fa-spin fa-loader" v-if="loaderGuardar"></i>
                </button>
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
    this.getLideres();
    this.getBarrios();
    this.getPuestos();
    this.getVotante(this.$route.params.id);
  },data: function () {
    return {
      baseUrl : '',
      loaderGuardar :false,
      objVotante:{'documento':'','nombre':'','telefono':'','direccion':'','barrio':'','lider':false,'idlider':'','publicidad':false,'puesto_id':'','mesa':''},
      errores:[],
      listaLideres:[],
      listaBarrios:[],
      listaPuestos:[],
      listaMesas:[],
    }
  },methods : {
    actualizar:function(){
      this.loaderGuardar=true;
      var url =this.baseUrl+'/votantes/actualizar';
      let inst=this;
      axios.post(url,this.objVotante).then(response =>{
        this.loaderGuardar=false;
        this.errores=[];
        this.objVotante={'documento':'','nombre':'','telefono':'','direccion':'','barrio':'','lider':false,'idlider':'','publicidad':false,'puesto_id':'','mesa':''};
        swal({
            title:response.data.message,
            text:response.data.message2,
            type: "success"
        },function(){
          inst.volver();
        });
      }).catch(error =>{
        this.loaderGuardar=false;
        this.errores=[];

        if(error.response.data.errors){
          this.errores=error.response.data.errors;
          console.log(this.errores);
        }
        if(error.response.data.error){
          toastr.error(error.response.data.error,'',{
            "timeOut": "3500"
          });
        }
      });
    },
    volver:function(){
        this.$router.push({
          name: "votante"
        });
    },
    getVotante:function(id){
      var url =this.baseUrl+'/votantes/editarvotante';
      let inst=this;
      this.listaLideres=[];
      axios.post(url,{id:id}).then(response =>{
        //this.listaLideres=response.data.listaLideres;
        this.cargaMesas(response.data.votante.puesto_id);
        this.objVotante=response.data.votante;
      }).catch(error =>{
      });
    },
    getLideres:function(){
      var url =this.baseUrl+'/votantes/lideres';
      let inst=this;
      this.listaLideres=[];
      axios.post(url,this.objVotante).then(response =>{
        this.listaLideres=response.data.listaLideres;
      }).catch(error =>{
      });
    },
    getBarrios:function(){
      var url =this.baseUrl+'/votantes/barrios';
      let inst=this;
      this.listaBarrios=[];
      axios.post(url,{}).then(response =>{
        this.listaBarrios=response.data.listaBarrios;
      }).catch(error =>{
      });
    },
    getPuestos:function(){
      var url =this.baseUrl+'/votantes/puestos';
      let inst=this;
      this.listaPuestos=[];
      axios.post(url,{}).then(response =>{
        this.listaPuestos=response.data.listaPuestos;
      }).catch(error =>{
      });
    },
    cargaMesas:function(idpuesto){

      this.objVotante.mesa='';
      var url =this.baseUrl+'/votantes/mesas';
      let inst=this;
      this.listaMesas=[];
      axios.post(url,{id:idpuesto}).then(response =>{
        this.listaMesas=response.data.listaMesas;
      }).catch(error =>{
      });
    }
  }
}
</script>
