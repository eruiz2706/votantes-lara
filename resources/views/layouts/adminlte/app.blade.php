<!DOCTYPE html>
<html  lang="{{ app()->getLocale() }}">
    @section('htmlheader')
        @include('layouts.adminlte.partials.htmlheader')
    @show

<body class="hold-transition sidebar-collapse">
<div >
    <div  id="loader-body" class="loader-wrapper loader1">
        <div class="loader"></div>
    </div>

    <div class="wrapper" id="v-app">
    <!--aqui va mainheader-->

    <div class="img-bannerhome" style="background-image: url('{{ URL::asset('img/counter_background.jpg') }}');"></div>


    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" id="app">


        <!-- Content Header (Page header) -->
        <div class="content-header" style="top:100px">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">@yield('tittlecontent')</h1>
                    </div><!-- /.col -->

                    <div class="col-sm-6">
                        @yield('breadcrumb')
                    </div>

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid" >
                @yield('content')
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    @include('layouts.adminlte.partials.footer')

  </div>
  <!-- ./wrapper -->
  @section('scripts')
      @include('layouts.adminlte.partials.scripts')
  @show
</div>
</body>
</html>
