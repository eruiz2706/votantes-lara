@extends('layouts.adminlte.app')

@section('content')
<div class="row">
    <div class="col-md-3">
        <!-- Profile Image -->
        <div class="card card-primary card-outline card-nav-user">
        <div class="card-body box-profile">
            <div class="text-center">
            <a href="#" v-on:click.prevent="setRedirect('perfil')">
                <img class="profile-user-img img-fluid img-circle"
                    src="{{ URL::asset('img/logo.jpg') }}"
                    alt="User avatar">
            </a>
            </div>

            <h3 class="profile-username text-center">
            <a href="#" style='color:#6c757d!important' v-on:click.prevent="setRedirect('perfil')">
                <span>Consuelo Ospina</span>
            </a>
            </h3>
            <!--<p class="text-muted text-center" style="margin-top:-10px">
            <a href="#" style='color:#6c757d!important' v-on:click.prevent="setRedirect('perfil')">AJ132550</a>
            </p>-->

            <ul class="nav nav-pills flex-column">
                <li class="nav-item active">
                    <router-link to="/home" class="nav-link">
                    <i class="fa fa-bar-chart"></i>
                    <span>Estadisticas Compana</span>
                    </router-link>
                </li>
                <li class="nav-item active">
                    <router-link to="/home2" class="nav-link">
                    <i class="fa fa-bar-chart"></i>
                    <span>Estadisticas Votacion</span>
                    </router-link>
                </li>
                <li class="nav-item ">
                    <router-link to="/votante" class="nav-link">
                        <i class="fa fa-users"></i>
                        <span>Votantes</span>
                    </router-link>
                </li>
                <li class="nav-item ">
                    <router-link to="/lideres" class="nav-link">
                        <i class="fa fa-user"></i>
                        <span>Lideres</span>
                    </router-link>
                </li>
                <li class="nav-item ">
                    <a class="dropdown-item nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                        <i class="fa fa-sign-out"></i> <span>Cerrar Session</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
        <!-- /.card-body -->
        </div>
        <!-- /.card -->

        <div class="card card-widget card-nav-user">
              <div class="card-body">
                <img class="img-fluid pad" src="{{ URL::asset('img/marcacion.jpg') }}" alt="Photo">
              </div>
              
            </div>
    </div>

    <div class="col-md-9" style='padding-top:0px;'>
        <transition name="slide-fade">
            <router-view></router-view>
        </transition>
    </div>
</div>
@endsection
