<template>
<div>
    <div class="row">
      <div class="col-sm-6">
        <h3>Estadisticas Compaña</h3>
      </div>
      <div class="col-sm-6">
      </div>
    </div>


    <div class="row">
      <div class="col-md-6">
      <div class="card">
          <div class="card-header no-border">
            <h3 class="card-title">Personas con Puesto de votacion vs Personas sin puesto de votacion</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-7">
                <div class="chart-responsive">
                  <div id="dash-grafcenso" style="height: 300px;"></div>
                </div>
                <!-- ./chart-responsive -->
              </div>
              <div class="col-md-5">
                <ul class="chart-legend clearfix">
                  <li>
                      <i class="fa fa-circle-o text-grey"></i>
                      Con puesto de votacion
                      <span class="float-right" v-text="this.infoCenso.censo"></span>
                  </li>
                  <li>
                      <i class="fa fa-circle-o text-grey"></i>
                      Sin puesto de votacion
                      <span class="float-right" v-text="this.infoCenso.sincenso"></span>
                  </li>
                  <li>
                      <i class="fa fa-circle-o text-grey"></i>
                      Total
                      <span class="float-right" v-text="this.infoCenso.total"></span>
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

      <div class="col-md-6">
      <div class="card">
          <div class="card-header no-border">
            <h3 class="card-title">Lideres vs Independientes</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-7">
                <div class="chart-responsive">
                   <div id="dash-graflid" style="height: 300px;"></div>
                </div>
                <!-- ./chart-responsive -->
              </div>
              <div class="col-md-5">
                <ul class="chart-legend clearfix">
                  <li>
                      <i class="fa fa-circle-o text-grey"></i>
                      Lideres
                      <span class="float-right" v-text="this.infoLid.lideres"></span>
                  </li>
                  <li>
                      <i class="fa fa-circle-o text-grey"></i>
                      Independientes
                      <span class="float-right" v-text="this.infoLid.independientes"></span>
                  </li>
                  <li>
                      <i class="fa fa-circle-o text-grey"></i>
                      Total
                      <span class="float-right" v-text="this.infoLid.total"></span>
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
      
      <div class="col-sm-6">
        <h4>Personas por comuna</h4>
      </div>
      
    
      <div class="col-md-12">
      <div class="card">
          <div class="card-header no-border">
            <h3 class="card-title">Personas Comuna 1</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-9">
                <div class="chart-responsive">
                  <div id="dash-comuna1"></div>
                </div>
                <!-- ./chart-responsive -->
              </div>
              <!-- /.col -->
              <div class="col-md-3">
                <ul class="chart-legend clearfix">
                  <li v-for="lista in this.dataComuna1">
                      <i class="fa fa-circle-o text-grey"></i>
                      <span v-text="lista.y"></span>
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

      <div class="col-md-12">
      <div class="card">
          <div class="card-header no-border">
            <h3 class="card-title">Personas Comuna 2</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-9">
                <div class="chart-responsive">
                  <div id="dash-comuna2"></div>
                </div>
                <!-- ./chart-responsive -->
              </div>
              <!-- /.col -->
              <div class="col-md-3">
                <ul class="chart-legend clearfix">
                  <li v-for="lista in this.dataComuna2">
                      <i class="fa fa-circle-o text-grey"></i>
                      <span v-text="lista.y"></span>
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

      <div class="col-md-12">
      <div class="card">
          <div class="card-header no-border">
            <h3 class="card-title">Personas Comuna 3</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-9">
                <div class="chart-responsive">
                  <div id="dash-comuna3"></div>
                </div>
                <!-- ./chart-responsive -->
              </div>
              <!-- /.col -->
              <div class="col-md-3">
                <ul class="chart-legend clearfix">
                  <li v-for="lista in this.dataComuna3">
                      <i class="fa fa-circle-o text-grey"></i>
                      <span v-text="lista.y"></span>
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

      <div class="col-md-12">
      <div class="card">
          <div class="card-header no-border">
            <h3 class="card-title">Personas Comuna 4</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-9">
                <div class="chart-responsive">
                  <div id="dash-comuna4"></div>
                </div>
                <!-- ./chart-responsive -->
              </div>
              <!-- /.col -->
              <div class="col-md-3">
                <ul class="chart-legend clearfix">
                  <li v-for="lista in this.dataComuna4">
                      <i class="fa fa-circle-o text-grey"></i>
                      <span v-text="lista.y"></span>
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

      <div class="col-md-12">
      <div class="card">
          <div class="card-header no-border">
            <h3 class="card-title">Personas Corregimientos</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-9">
                <div class="chart-responsive">
                  <div id="dash-comuna5"></div>
                </div>
                <!-- ./chart-responsive -->
              </div>
              <!-- /.col -->
              <div class="col-md-3">
                <ul class="chart-legend clearfix">
                  <li v-for="lista in this.dataComuna5">
                      <i class="fa fa-circle-o text-grey"></i>
                      <span v-text="lista.y"></span>
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


      <div class="col-sm-6">
        <h4>Informacion publicidad</h4>
      </div>

      <div class="col-md-12">
      <div class="card">
          <div class="card-header no-border">
            <h3 class="card-title">Publicidad por barrio</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <div class="row">
              <div class="col-md-9">
                <div class="chart-responsive">
                  <div id="dash-publicidad"></div>
                </div>
                <!-- ./chart-responsive -->
              </div>
              <!-- /.col -->
              <div class="col-md-3">
                <ul class="chart-legend clearfix">
                  <li v-for="lista in this.dataPublicidad">
                      <i class="fa fa-circle-o text-grey"></i>
                      <span v-text="lista.y"></span>
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
            infoCenso : {},
            infoLid : {},
            dataComuna1 :[],
            dataComuna2 :[],
            dataComuna3 :[],
            dataComuna4 :[],
            dataComuna5 :[],
            dataPublicidad : []
          }
        },methods : {
          getDashboard: function(){
            var url =this.baseUrl+'/votantes/getDashboard';
            let inst=this;
            axios.post(url,this.objVotante).then(response =>{
              console.log(response.data);
              this.drawGrafCenso(response.data.grafCenso);
              this.drawGrafLid(response.data.grafLideres);
              this.drawComunas(response.data.grafComunas);
              this.drawPublicidad(response.data.grafPublicidad);
            }).catch(error =>{
            });
          },
          drawGrafCenso : function (data){
              var total = parseInt(data.censados)+parseInt(data.sincenso);
              Morris.Donut({
                element: 'dash-grafcenso',
                data: [
                      {label: "Con Puesto de Votacion", value: data.censados},
                      {label: "Sin Puesto de Votacion", value: data.sincenso},
                ],
                colors: [
                      'green',
                      'blue',
                ],
                formatter: function (value, data) { 
                  return Math.floor(value/total*100) + '%'; 
                },
                resize : true
              });

              this.infoCenso ={
                'censo' : data.censados,
                'sincenso' : data.sincenso,
                'total' : total
              };
          },
          drawGrafLid : function (data){
            var total = parseInt(data.lideres)+parseInt(data.independientes);
            Morris.Donut({
              element: 'dash-graflid',
              data: [
                    {label: "Lideres", value: data.lideres},
                    {label: "Independientes", value: data.independientes},
              ],
              colors: [
                    'grey',
                    'blue',
              ],
              formatter: function (value, data) { 
                return Math.floor(value/total*100) + '%'; 
              },
              resize : true
            });

            this.infoLid ={
                'lideres' : data.lideres,
                'independientes' : data.independientes,
                'total' : total
            };
            
          },drawComunas : function (data){
            this.dataComuna1 = [];
            this.dataComuna2 = [];
            this.dataComuna3 = [];
            this.dataComuna4 = [];
            this.dataComuna5 = [];
            
            for(var i=0;i<data.length;i++){
              var obj = data[i];
              if(obj.comuna==1){
                this.dataComuna1.push({ y: obj.nombre, a: obj.cantidad});
              }
              if(obj.comuna==2){
                this.dataComuna2.push({ y: obj.nombre, a: obj.cantidad});
              }
              if(obj.comuna==3){
                this.dataComuna3.push({ y: obj.nombre, a: obj.cantidad});
              }
              if(obj.comuna==4){
                this.dataComuna4.push({ y: obj.nombre, a: obj.cantidad});
              }
              if(obj.comuna==5){
                this.dataComuna5.push({ y: obj.nombre, a: obj.cantidad});
              }
            }
           
            Morris.Bar({
              element: 'dash-comuna1',
              data: this.dataComuna1,
              xkey: 'y',
              ykeys: ['a'],
              labels: ['Series A'],
              horizontal: true,
              stacked: true,
              resize : true
            });

            Morris.Bar({
              element: 'dash-comuna2',
              data: this.dataComuna2,
              xkey: 'y',
              ykeys: ['a'],
              labels: ['Series A'],
              horizontal: true,
              stacked: true,
              resize : true
            });

            Morris.Bar({
              element: 'dash-comuna3',
              data: this.dataComuna3,
              xkey: 'y',
              ykeys: ['a'],
              labels: ['Series A'],
              horizontal: true,
              stacked: true,
              resize : true
            });

            Morris.Bar({
              element: 'dash-comuna4',
              data: this.dataComuna4,
              xkey: 'y',
              ykeys: ['a'],
              labels: ['Series A'],
              horizontal: true,
              stacked: true,
              resize : true
            });

            Morris.Bar({
              element: 'dash-comuna5',
              data: this.dataComuna5,
              xkey: 'y',
              ykeys: ['a'],
              labels: ['Series A'],
              horizontal: true,
              stacked: true,
              resize : true
            });
          },
          drawPublicidad : function (data){
            this.dataPublicidad = [];
            
            for(var i=0;i<data.length;i++){
              var obj = data[i];
              this.dataPublicidad.push({ y: obj.nombre, a: obj.cantidad});
            }
           
            Morris.Bar({
              element: 'dash-publicidad',
              data: this.dataPublicidad,
              xkey: 'y',
              ykeys: ['a'],
              labels: ['Series A'],
              horizontal: true,
              stacked: true,
              resize : true
            });
          }
        }
    }
</script>
