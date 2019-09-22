<nav class="main-header navbar navbar-expand border-bottom bg-primary main-header-fixed">
    <ul class="navbar-nav">
      <li class="nav-item">
          <a href="{{ url('/principal') }}">
            <!--<img id="logo-mainmenu" src="{{ URL::asset('img/logo2.jpg') }}" alt="AdminLTE Logo" class="brand-image ">-->
            <!--<span class="brand-text font-weight-light">{{ config('app.name') }}</span>-->
            <span class="brand-text font-weight-light"><strong>GESTION VOTANTES</strong></span>
          </a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#">
            <div class="user-block">
              <img class="img-circle img-bordered-sm"  src="{{ asset('img/logo.jpg') }}" alt="User avatar">
              <i class="fa fa-chevron-down" style="padding-top:10px;padding-left:10px;" ></i>
            </div>
          </a>
          <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

              <div class="card ">
                  <div class="card-body">
                    <h6 class="widget-user-desc" v-text='conexion_user.nombre'></h6>
                    <h6 class="widget-user-desc" v-text='conexion_user.ultimo_ingreso'></h6>
                    <h6 class="widget-user-desc" v-text='conexion_user.tiempo_uso'></h6>
                    <div class="row mt-3">
                      <div class="col-sm-6 border-right">
                          <button class="btn btn-block btn-outline-primary btn-sm" onclick="window.location.href='{{url('/perfil')}}'">
                            {{trans('backend.profile')}}
                          </button>
                      </div>
                      <!-- /.col -->
                      <div class="col-sm-6 border-right">
                          <button class="btn btn-block btn-outline-primary btn-sm" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{trans('backend.sign_off')}}
                          </button>

                          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                          </form>
                      </div>

                    </div>
                  </div>


                </div>
          </div>
        </li>
    </ul>

  </nav>
  <!-- /.navbar -->
