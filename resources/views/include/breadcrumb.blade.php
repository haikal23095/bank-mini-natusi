<div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
	<div class="breadcrumb-title pe-3">{{$title}}</div>
	<div class="ps-3">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb mb-0 p-0">
				<li class="breadcrumb-item"><a href="{{route('dashAdmin')}}"><i class="bx bx-home-alt"></i></a>
				</li>
				@if(isset($breadCrumb))
				@foreach($breadCrumb as $item)
					<li class="breadcrumb-item active" aria-current="page">{{$item}}</li>
				@endforeach
				@else
					<li class="breadcrumb-item active" aria-current="page">{{$title}}</li>
				@endif
			</ol>
		</nav>
	</div>
</div>