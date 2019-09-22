<template>
<div>
    <div class="modal fade" id="modal_votantes" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class='modal-header'>
                <h5 class="modal-title" v-text="modalVotantesTitulo"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              </div>
              <div class="modal-body table-responsive p-0" style="height:450px;overflow-y: auto;">
                <table class="table table-striped table-valign-middle">
                    <thead>
                    <tr>
                      <th>Documento</th>
                      <th>Nombre</th>
                      <th>Telefono</th>
                      <th>Direccion</th>
                      <th>Barrio</th>
                      <th>Puesto</th>
                      <th>Mesa</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for ="votante in dataVotantes">
                      <td v-text="votante.documento"></td>
                      <td v-text="votante.nombre"></td>
                      <td v-text="votante.telefono"></td>
                      <td v-text="votante.direccion"></td>
                      <td v-text="votante.barrio"></td>
                      <td v-text="votante.puesto"></td>
                      <td v-text="votante.mesa"></td>
                    </tr>
                    </tbody>
                  </table>
              </div>
          </div>
        </div>
    </div>


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
                          <th>Votantes</th>
                          <th>Categoria Votantes</th>
                          <th>Votantes Censo</th>
                          <th>Categoria Censo</th>
                          <th>Maneja Publicidad.</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="lista in pagination.datafilter">
                          <td>
                            <button type="button" class="btn btn-tool"><i class="fa fa-list-alt" style="font-size: 16px;" v-on:click.prevent="votantesLider(lista.id,lista.nombre)"></i></button>
                          </td>
                          <td v-text="lista.documento"></td>
                          <td v-text="lista.nombre"></td>
                          <td v-text="lista.cantidadvotantes"></td>
                          <td>
                            <p class="text-success text-xl" v-if="lista.cantidadvotantes>=21"><i class="fa fa-square"></i></p>
                            <p class="text-warning text-xl" v-if="lista.cantidadvotantes>=11 && lista.cantidadvotantes<=20"><i class="fa fa-square"></i></p>
                            <p class="text-danger text-xl"><i class="fa fa-square" v-if="lista.cantidadvotantes<=10"></i></p>
                          </td>
                          <td v-text="lista.cantcenso"></td>
                          <td>
                            <p class="text-success text-xl" v-if="lista.cantcenso>=21"><i class="fa fa-square"></i></p>
                            <p class="text-warning text-xl" v-if="lista.cantcenso>=11 && lista.cantcenso<=20"><i class="fa fa-square"></i></p>
                            <p class="text-danger text-xl"><i class="fa fa-square" v-if="lista.cantcenso<=10"></i></p>
                          </td>
                          <td v-text="lista.cantpublicidad"></td>
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
      votosIndependientes : 0,
      modalVotantesTitulo : '',
      dataVotantes : [],
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
        keys : ["documento","nombre"]
      }
    }
  },methods : {
    getListaLideres:function(){
      var url =this.baseUrl+'/votantes/listadoLideres';
      let inst=this;
      this.listaLideres=[];
      axios.post(url,this.objVotante).then(response =>{
        //this.listaLideres= response.data.listaLideres;
        this.pagination.data =response.data.listaLideres;
        this.changePage(1);
      }).catch(error =>{
      });
    },
    votantesLider:function(idlider,nombre){
            $('#modal_votantes').modal('show');
            var url =this.baseUrl+'/votantes/votanesLider';
            let inst=this;
            this.modalVotantesTitulo=nombre;
            this.dataVotantes=[];
            axios.post(url,{id:idlider}).then(response =>{
              console.log(response.data.dataVotantes);
              this.dataVotantes=response.data.dataVotantes;
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
