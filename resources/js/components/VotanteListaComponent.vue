<template>
<div>
    <div class="modal fade" id="modal_censo" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class='modal-header'>
            <h5 class="modal-title">
              Datos Censo
            </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
          </div>
          <div class="modal-body table-responsive p-0">
            <div class="alert alert-warning alert-dismissible" v-if="!this.validaCenso">
             <h5><i class="icon fa fa-warning"></i> Alerta!</h5>
              El votante no tiene registro de censo
            </div>

            <table class="table" v-if="this.validaCenso">
                <tbody><tr>
                  <th style="width:50%">NUID:</th>
                  <td v-text="objCenso.nuid"></td>
                </tr>
                <tr>
                  <th>DEPARTAMENTO</th>
                  <td v-text="objCenso.departamento"></td>
                </tr>
                <tr>
                  <th>MUNICIPIO</th>
                  <td v-text="objCenso.municipio"></td>
                </tr>
                <tr>
                  <th>PUESTO</th>
                  <td v-text="objCenso.puesto"></td>
                </tr>
                <tr>
                  <th>DIRECCION</th>
                  <td v-text="objCenso.direccion"></td>
                </tr>
                <tr>
                  <th>MESA</th>
                  <td v-text="objCenso.mesa"></td>
                </tr>
                </tbody>
              </table>
          </div>
      </div>
    </div>
    </div>

    <div class="row">
      <div class="col-sm-6">
        <h3>Votantes</h3>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item">
            <router-link to="/nuevo-votante">
                Nuevo Votante
            </router-link>
          </li>
        </ol>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Listado de Votantes</h3>
          <div class="card-tools">
            <div class="input-group input-group-sm">
              <input type="text" class="form-control" placeholder="Buscar.." v-model="pagination.search" v-on:keyup="changeSearch()">
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
                <th>Telefono</th>
                <th>Direccion</th>
                <th>Barrio</th>
                <th>Publicidad en casa</th>
                <th>Lider</th>
                <th>Nombre Lider</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="lista in pagination.datafilter">
                <td>
                  <button type="button" class="btn btn-tool"><i class="fa fa-edit" style="font-size: 16px;"></i></button>
                  <button type="button" class="btn btn-tool"><i class="fa fa-eye" style="font-size: 16px;" v-on:click.prevent="openCenso(lista.documento)"></i></button>
                </td>
                <td v-text="lista.documento"></td>
                <td v-text="lista.nombre"></td>
                <td v-text="lista.telefono"></td>
                <td v-text="lista.direccion"></td>
                <td v-text="lista.nombre_barrio"></td>
                <td>
                  <span class="badge badge-info" v-if="lista.publicidad">SI</span>
                </td>
                <td><span class="badge badge-success" v-if="lista.lider"><i class="fa fa-check"></i></span></td>
                <td v-text="lista.nombre_lider"></td>
              </tr>
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <ul class="pagination pagination-sm m-0 float-right">
            <li class="page-item" v-bind:class="[pagination.page > 1 ? '' : 'disabled']">
              <a class="page-link" href="#" v-on:click.prevent="changePage(pagination.page-1)">«</a>
            </li>
            <li class="page-item" v-for="page in pagesNumbers" v-bind:class="[ page == isActived ? 'active' : '']">
              <a class="page-link" href="#" v-on:click.prevent="changePage(page)">
                <span v-text='page'></span>
              </a>
            </li>
            <li class="page-item" v-bind:class="[pagination.page < pagination.total_pages ? '' : 'disabled']">
              <a class="page-link" href="#"  v-on:click.prevent="changePage(pagination.page+1)">»</a>
            </li>
          </ul>
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
    this.getListaVotantes();
  },data: function () {
    return {
      baseUrl : '',
      listaVotantes:[],
      objCenso : {},
      validaCenso : false,
      pagination :{
        page : 0,
        per_page : 15,
        next_page : 0,
        total : 0,
        total_pages : 0,
        offset : 2,
        data : [],
        datafilter : [],
        search : '',
        keys : ["documento","nombre","telefono","direccion","nombre_barrio"]
      }
    }
  },methods : {
    getListaVotantes:function(){
      var url =this.baseUrl+'/votantes/lista';
      let inst=this;
      this.listaVotantes=[];
      axios.post(url,this.objVotante).then(response =>{
        //this.listaVotantes=response.data.listaVotantes;
        this.pagination.data =response.data.listaVotantes;
        this.changePage(1);
      }).catch(error =>{
      });
    },
    openCenso:function(documento){
      $('#modal_censo').modal('show');
      var url =this.baseUrl+'/votantes/censo';
      let inst=this;
      this.objCenso = {};
      this.validaCenso = false;
      axios.post(url,{documento:documento}).then(response =>{
        if(response.data.censo[0]){
          this.objCenso =response.data.censo[0];
          this.validaCenso = true;
        }
      }).catch(error =>{
      });
    },
    /*metodos de paginacion de tablas*/
    changePage : function (page){
        var data =this.filterData(this.pagination.search,this.pagination.keys,this.pagination.data)
        this.paginator(data,page,this.pagination.per_page);

    },
    changeSearch : function(){
        this.changePage(1);
    },
    paginator  : function (items, page, per_page) {

        var page = page || 1;
        var per_page = per_page || 10;
        var offset = (page - 1) * per_page;

        var paginatedItems = items.slice(offset).slice(0, per_page);
        var total_pages = Math.ceil(items.length / per_page);

        this.pagination.page=page;
        this.pagination.per_page=per_page;
        this.pagination.pre_page=page - 1 ? page - 1 : null;
        this.pagination.next_page= (total_pages > page) ? page + 1 : null;
        this.pagination.total=items.length;
        this.pagination.total_pages=total_pages;
        this.pagination.datafilter=paginatedItems;

    },
    filterData : function(search,keys,wines) {
        var lowSearch = search.toLowerCase();
        return wines.filter(function(wine){
            return keys.some( key =>
                String(wine[key]).toLowerCase().includes(lowSearch)
            );
        });
    }
  },
  computed : {
    isActived : function(){
        return this.pagination.page;
    },
    pagesNumbers : function(){
        if(this.pagination.total_pages <= 1){
            return [];
        }

        var from    =this.pagination.page - this.pagination.offset;
        if(from < 1){
            from = 1;
        }

        var to  = from + (this.pagination.offset * 2);
        if(to >= this.pagination.total_pages){
            to  = this.pagination.total_pages;
        }

        var pagesArray  = [];
        while(from <= to){
            pagesArray.push(from);
            from++;
        }

        return pagesArray;
    },
    msjTables : function(){
        var cantIni=1;
        var cantFin=1;
        if(this.pagination.page>1){
              cantIni=this.pagination.pre_page * this.pagination.per_page;
        }

        if(this.pagination.page ==this.pagination.total_pages){
            cantFin =this.pagination.total;
        }else{
            if(this.pagination.page>1){
                cantFin =cantIni + this.pagination.per_page;
            }else{
                cantFin =this.pagination.per_page;
            }

        }
        var mensaje="Mostrando "+cantIni+" a "+cantFin+" de "+this.pagination.total;
        return mensaje;
    }
  }
}
</script>
