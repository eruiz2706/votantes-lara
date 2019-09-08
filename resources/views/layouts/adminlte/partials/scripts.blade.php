
<script src="{{ asset('plugins/jquery/jquery1.9.min.js') }}"></script>
<script src="{{ asset('plugins/morris/raphael-min.js') }}"></script>
<script src="{{ asset('plugins/morris/morris.min.js') }}"></script>
<script src="{{ asset('plugins/morris/morris-horizontal.min.js') }}"></script>

<script src="{{ asset('plugins/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('plugins/slimScroll/jquery.slimscroll.min.js') }}"></script>
<script src="{{ asset('plugins/fastclick/fastclick.js') }}"></script>
<script src="{{ asset('plugins/toastr/toastr.js') }}"></script>
<script src="{{ asset('plugins/sweetalert/sweetalert.min.js') }}"></script>
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/fullcalendar/fullcalendar.min.js') }}"></script>
<script src="{{ asset('plugins/vue/vue.js') }}"></script>
<script src="{{ asset('plugins/axios/axios.js') }}"></script>
<script src="{{ asset('rsc/js/adminlte.js') }}"></script>


<!--<script src="{{ URL::asset('js/translation.js') }}"></script>-->
<script src="{{ asset('plugins/chartjs/Chart.min.js') }}"></script>

<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script>
window.onload = function() {
  loaders = document.getElementById('loader-body');
  loaders.style.display = "none";
};
var base_url = '<?php echo url('/'); ?>';
/*$.getJSON({url:base_url+"/trans",async: false},function(result){
  window.translations =result;
});*/



</script>
<script src="{{ asset('js/app.js') }}"></script>
