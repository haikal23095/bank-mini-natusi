<script src="{{url('assets/js/bootstrap.bundle.min.js')}}"></script><!--bootstrapJS-->
<!--startPlugins-->
<script src="{{url('assets/js/jquery.min.js')}}"></script>
<script src="{{url('assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
<script src="{{url('assets/plugins/metismenu/js/metisMenu.min.js')}}"></script>
<script src="{{url('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js')}}"></script>
<script src="{{url('assets/js/pace.min.js')}}"></script>
{{-- <script src="{{url('assets/plugins/chartjs/js/Chart.min.js')}}"></script> --}}
{{-- <script src="{{url('assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js')}}"></script> --}}
{{-- <script src="{{url('assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js')}}"></script> --}}
{{-- <script src="{{url('assets/plugins/jquery.easy-pie-chart/jquery.easypiechart.min.js')}}"></script> --}}
{{-- <script src="{{url('assets/plugins/sparkline-charts/jquery.sparkline.min.js')}}"></script> --}}
{{-- <script src="{{url('assets/plugins/jquery-knob/excanvas.js')}}"></script> --}}
<!--endPlugins-->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script><!-- Select 2 -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script> <!-- Datepicker-->
<script src="{{url('assets/js/app.js')}}"></script><!--appJS-->
<script type="text/javascript">
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	})

	$(function() {
        $('#datepicker').datepicker();
    });
</script>
@stack('script')