<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="Applikasi sewa villa berbasis web.">
<meta name="author" content="Muhamad Nizar">
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="icon" href="{{ asset('/frontend') }}/assets/img/favicon.ico">
<title>{{config('app.name')}} - @yield('title')</title>
<!-- Bootstrap core CSS -->
<link href="{{ asset('/frontend') }}/assets/css/bootstrap.min.css" rel="stylesheet">
<!-- Fonts -->
<link rel="stylesheet" href="{{ asset('/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}"
        type="text/css">
<link href="https://fonts.googleapis.com/css?family=Righteous" rel="stylesheet">
<!-- Custom styles for this template -->
<link href="{{ asset('/frontend') }}/assets/css/mediumish.css" rel="stylesheet">
<!-- fullCalendar -->
<link rel="stylesheet" href="{{asset('/assets/plugins/fullcalendar/main.css')}}">
<script src="https://cdn.ckeditor.com/ckeditor5/33.0.0/balloon-block/ckeditor.js"></script>
{{-- Snackbar --}}
<link rel="stylesheet" href="{{ asset('/assets/css//snackbar.min.css') }}">
<script src="{{ asset('/assets/js/snackbar.min.js') }}"></script>
<!-- DataTables -->
<link rel="stylesheet" href="{{ asset('/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
<link rel="stylesheet" href="{{ asset('/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
</head>
<body>

<!-- Begin Nav
================================================== -->
<nav class="navbar navbar-toggleable-md navbar-light bg-white fixed-top mediumnavigation">
<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
<span class="navbar-toggler-icon"></span>
</button>
<div class="container">
	<!-- Begin Logo -->
	<a class="navbar-brand" href="/">
	<img src="{{ asset('/frontend') }}/assets/img/logo.png" alt="{{config('app.name')}}">
	</a>
	<!-- End Logo -->
	<div class="collapse navbar-collapse" id="navbarsExampleDefault">
		<!-- Begin Menu -->
		<ul class="navbar-nav ml-auto">
			<li class="nav-item active">
			<a class="nav-link" href="/">Villas <span class="sr-only">(current)</span></a>
			</li>
			<li class="nav-item">
			<a class="nav-link" href="{{route('booking.list')}}">Daftar sewa</a>
			</li>

			@if (Auth::check())
				<form action="{{route('logout')}}" method="POST">
					@csrf
					<button class="btn btn-outline-danger my-2 my-sm-0" type="submit">Logout</button>
				</form>
			@endif
		</ul>
		<!-- End Menu -->
		<!-- Begin Search -->
		{{-- <form class="form-inline my-2 my-lg-0">
			<input class="form-control mr-sm-2" type="text" placeholder="Search">
			<span class="search-icon"><svg class="svgIcon-use" width="25" height="25" viewbox="0 0 25 25"><path d="M20.067 18.933l-4.157-4.157a6 6 0 1 0-.884.884l4.157 4.157a.624.624 0 1 0 .884-.884zM6.5 11c0-2.62 2.13-4.75 4.75-4.75S16 8.38 16 11s-2.13 4.75-4.75 4.75S6.5 13.62 6.5 11z"></path></svg></span>
		</form> --}}
		<!-- End Search -->
	</div>
</div>
</nav>
<!-- End Nav
================================================== -->

<!-- Begin Site Title
================================================== -->
<div class="container">
	<div class="mainheading">
		<h1 class="sitetitle">{{config('app.name')}}</h1>
		<p class="lead">
			 Applikasi sewa villa.
		</p>
	</div>
<!-- End Site Title
================================================== -->

	@yield('content')

	<!-- Begin Footer
	================================================== -->
	<div class="footer">
		<p class="pull-left">
			 Copyright &copy; {{date('Y') . ' ' . config('app.name')}}
		</p>
		<p class="pull-right">
			 {{config('app.name')}} Theme by <a target="_blank" href="https://www.wowthemes.net">WowThemes.net</a>
		</p>
		<div class="clearfix">
		</div>
	</div>
	<!-- End Footer
	================================================== -->

</div>
<!-- /.container -->

<!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="{{ asset('/frontend') }}/assets/js/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="{{ asset('/frontend') }}/assets/js/bootstrap.min.js"></script>
<script src="{{ asset('/frontend') }}/assets/js/ie10-viewport-bug-workaround.js"></script>
<!-- fullCalendar 2.2.5 -->
<script src="{{asset('/assets/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('/assets/plugins/fullcalendar/main.js')}}"></script>
{{-- sweetalert --}}
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
	@if (Session::has('success'))
		Snackbar.show({
		text: "{{ session('success') }}",
		backgroundColor: '#28a745',
		actionTextColor: '#212529',
	})
	@elseif (Session::has('error'))
		Snackbar.show({
		text: "{{ session('error') }}",
		backgroundColor: '#dc3545',
		actionTextColor: '#212529',
	})
	@elseif (Session::has('info'))
		Snackbar.show({
		text: "{{ session('info') }}",
		backgroundColor: '#17a2b8',
		actionTextColor: '#212529',
		})
	@endif;
</script>
@yield('c_js')
</body>
</html>
