<template>
<div>
    <div class="row">
      <div class="col-sm-6">
        <h3>Estadisticas Votacion</h3>
      </div>
      <div class="col-sm-6">
      </div>
    </div>

    <div class="row">
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
                  <div id="dash2-censo"></div>
                </div>
                <!-- ./chart-responsive -->
              </div>
              <!-- /.col -->
              <div class="col-md-3">
                <ul class="chart-legend clearfix">
                  <li v-for="lista in this.dataCenso">
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
          <div class="card-footer bg-white p-0">
                <ul class="nav nav-pills flex-column">
                  <li class="nav-item" v-for="lista in this.dataCenso">
                    <a href="#" class="nav-link" style="font-size:18px">
                      <strong v-text="lista.y"></strong>
                      <span class="float-right text-danger" v-text="lista.a"></span>
                    </a>
                    <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Mesa</th>
                        <th>Cantidad</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="mesas in lista.mesas">
                        <td v-text="mesas.mesa"></td>
                        <td v-text="mesas.cantidad"></td>
                      </tr>
                    </tbody>
                  </table>
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
          console.log('Component mounted.');
          this.getDashboard();
        },created : function(){
          this.baseUrl=base_url;
        },data: function () {
          return {
            baseUrl : '',
            dataCenso : []
          }
        },methods : {
          getDashboard: function(){
            var url =this.baseUrl+'/votantes/getDashboard2';
            let inst=this;
            axios.post(url,this.objVotante).then(response =>{
              console.log(response.data);
              this.drawCenso(response.data.grafCenso);
            }).catch(error =>{
            });
          },
          drawCenso : function (data){
            this.dataCenso = [];
            
            for(var i=0;i<data.length;i++){
              var obj = data[i];
              this.dataCenso.push({ y: obj.nombre, a: obj.cantidad,mesas:obj.mesas});
            }
           
            Morris.Bar({
              element: 'dash2-censo',
              data: this.dataCenso,
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