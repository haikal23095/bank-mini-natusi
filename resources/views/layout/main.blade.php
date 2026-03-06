<!doctype html>
<html class="color-sidebar sidebarcolor1" lang="en">
<head>
	<!--requiredMetaTags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{csrf_token()}}"><!--csrfToken-->
	<title>{{ $title }} | Bank Mini</title>
	@include('include.style')<!--importCSS-->
	<style>
		.sidebar-header {
			height: 80px !important;
			background: #656649 !important;
			/* margin-top: -50px !important; */
		}

		.sidebar-wrapper .metismenu {
			margin-top: 0px !important;
		}
		
		.wrapper {
			color: black;
		}

		.header-image {
			position: absolute;
			margin-top: 0px;	
		}

		.header-text {
			position: absolute;
			margin-top: 0px;
			margin-left: 70px;
		}

		.menu-title {
			color: #000;
		}

		.mm-active {
			background: #4C4C4C;
		}
		
		.sidebar-header-profile {
			margin-top: 100px;
		}
		/* .simplebar-content-wrapper {
			background: #FFFFFF !important;
			color: #000;
		} */
	</style>
</head>

<body>
	<!--startWrapper-->
	<div class="wrapper">
		@include('include.sidebar')<!--importSidebar-->

		@include('include.header')<!--importHeader-->

		<div class="page-wrapper">
			@yield('content')<!--includeContent-->
		</div>

		<div class="overlay toggle-icon"></div><!--overlay-->

		<a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a><!--backToTopButton-->

		@include('include.footer')<!--importFooter-->
	</div>
	<!--endWrapper-->

	@include('include.script') <!--importJavaScript-->
</body>

</html>