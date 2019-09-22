<template>
<div>
    <div class="modal fade" id="modal_puestos" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class='modal-header'>
                <h5 class="modal-title" v-text="modalMesaTitulo"></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              </div>
              <div class="modal-body table-responsive p-0" style="height:450px;overflow-y: auto;">
                <table class="table table-striped table-valign-middle">
                    <thead>
                    <tr>
                      <th>Mesa</th>
                      <th>Votantes</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="puesto in this.dataPuesto">
                      <td v-text="'# '+puesto.mesa"></td>
                      <td align="right" v-text="puesto.cantidad"></td>
                    </tr>
                    </tbody>
                  </table>
              </div>
          </div>
        </div>
    </div>

    <div class="modal fade" id="modal_mesas" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class='modal-header'>
                <h5 class="modal-title">Votantes Mesas</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              </div>
              <div class="modal-body table-responsive p-0" style="height:450px;overflow-y: auto;">
                <table class="table table-striped table-valign-middle">
                    <thead>
                    <tr>
                      <th>Puesto</th>
                      <th>Mesa</th>
                      <th>Votantes</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="mesa in this.dataMesas">
                      <td v-text="mesa.puesto"></td>
                      <td v-text="'# '+mesa.mesa"></td>
                      <td align="right" v-text="mesa.cantidad"></td>
                    </tr>
                    </tbody>
                  </table>
              </div>
          </div>
        </div>
    </div>


    <div class="row">
      <div class="col-sm-6">
        <h3>Estadisticas Votacion</h3>
      </div>
      <div class="col-sm-6">
      </div>
    </div>

    <div class="row">
        <div class="col-md-6">
          <div class="card">
              <div class="card-header no-border">
                <h3 class="card-title">Mesas con Votantes vs Mesas sin Votantes</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="row">
                  <div class="col-md-7">
                    <div class="chart-responsive">
                      <div id="dash2-grafmesas" style="height: 300px;"></div>
                    </div>
                    <!-- ./chart-responsive -->
                  </div>
                  <div class="col-md-5">
                    <ul class="chart-legend clearfix">
                      <li>
                          <i class="fa fa-circle-o text-grey"></i>
                          Con votantes <a href="#" v-on:click.prevent="votacionMesas()">(ver)</a>  
                          <span class="float-right" v-text="this.infoMesas.convotantes"></span>
                      </li>
                      <li>
                          <i class="fa fa-circle-o text-grey"></i>
                          Sin votantes  <span class="float-right" v-text="this.infoMesas.sinvotantes"></span>
                      </li>
                      <li>
                          <i class="fa fa-circle-o text-grey"></i>
                          Total  <span class="float-right" v-text="this.infoMesas.total"></span>
                      </li>
                    </ul>
                  </div>
                  <!-- /.col -->
                  
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- /.card-body -->
            </div>
          </div>

        <div class="col-md-12">
        <div class="card">
          <div class="card-header no-border">
            <h3 class="card-title">Votantes x Puesto</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-8">
                <div class="chart-responsive">
                  <div id="dash2-censo"></div>
                </div>
                <!-- ./chart-responsive -->
              </div>
              <!-- /.col -->
              <div class="col-md-4">
                <ul class="chart-legend clearfix">
                  <li v-for="lista in this.dataCenso" >
                      <i class="fa fa-circle-o text-grey"></i>
                      <span v-text="lista.y"></span>
                      <a href="#" v-on:click.prevent="votacionPuesto(lista.id,lista.y)">(ver)</a>
                      <span class="float-right" v-text="lista.a"></span>
                  </li>
                </ul>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
          </div>
          <!-- /.card-body -->
        </div>
      </div>
    </div>
</div>
</template>

<script>
    export default {
        mounted() {
          console.log('Component mounted.');
          this.getDashboard();
        },created : function(){
          this.baseUrl=base_url;
        },data: function () {
          return {
            baseUrl : '',
            dataCenso : [],
            dataPuesto: [],
            modalMesaTitulo:'',
            infoMesas:[],
            dataMesas: []
          }
        },methods : {
          getDashboard: function(){
            var url =this.baseUrl+'/votantes/getDashboard2';
            let inst=this;
            axios.post(url,this.objVotante).then(response =>{
              console.log(response.data);
              this.drawCenso(response.data.grafCenso);
              this.drawGrafMesas(response.data.grafMesas);
            }).catch(error =>{
            });
          },
          drawCenso : function (data){
            this.dataCenso = [];
            
            for(var i=0;i<data.length;i++){
              var obj = data[i];
              this.dataCenso.push({ id:obj.id,y: obj.nombre, a: obj.cantidad,mesas:obj.mesas});
            }
           
            Morris.Bar({
              element: 'dash2-censo',
              data: this.dataCenso,
              xkey: 'y',
              ykeys: ['a'],
              labels: ['Votantes'],
              horizontal: true,
              stacked: true,
              resize : true
            });
          },
          drawGrafMesas : function (data){
              var total = parseInt(data.convotantes)+parseInt(data.sinvotantes);
              
              Morris.Donut({
                element: 'dash2-grafmesas',
                data: [
                      {label: "Mesas con Votantes", value: data.convotantes},
                      {label: "Mesas sin Votantes", value: data.sinvotantes},
                ],
                colors: [
                      'green',
                      'blue',
                ],
                formatter: function (value, data) { 
                  return Math.floor(total>0 ? value/total*100 : 0) + '%'; 
                },
                resize : true
              });

              this.infoMesas ={
                'convotantes' : data.convotantes,
                'sinvotantes' : data.sinvotantes,
                'total' : total
              };
          },
          votacionPuesto:function(idpuesto,nombre){
            $('#modal_puestos').modal('show');
            var url =this.baseUrl+'/votantes/votacionpuesto';
            let inst=this;
            this.modalMesaTitulo=nombre;
            this.dataPuesto=[];
            axios.post(url,{id:idpuesto}).then(response =>{
              console.log(response.data.dataPuesto);
              this.dataPuesto=response.data.dataPuesto;
            }).catch(error =>{
            });
          },
          votacionMesas:function(){
            $('#modal_mesas').modal('show');
            var url =this.baseUrl+'/votantes/votconmesas';
            let inst=this;
            this.dataMesas=[];
            axios.post(url,{}).then(response =>{
              this.dataMesas=response.data.dataMesas;
            }).catch(error =>{
            });
          }
        }
    }
</script>