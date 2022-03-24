@extends('layouts.frontend')
@section('title', $villa->nama_villa)

@section('content')
    <!-- Begin Article
================================================== -->
<div class="container">
	<div class="row">

		<!-- Begin Fixed Left Share -->
		<div class="col-md-2 col-xs-12">
			<div class="share">
				<p class="font-weight-bold">
					Sewa villa
				</p>
				<ul>
					@if (!Auth::check())
						<li>
							<a href="{{route('login.socialite.redirect', 'google')}}">
								<i class="fab fa-google"></i>
							</a>
						</li>
					@else
						<li>
							<a href="{{route('booking.villa', $villa->uuid)}}">
								<i class="fas fa-receipt"></i>
							</a>
						</li>
					@endif
				</ul>
			</div>
		</div>
		<!-- End Fixed Left Share -->

		<!-- Begin Post -->
		<div class="col-md-8 col-md-offset-2 col-xs-12">
			<div class="mainheading">

				<h1 class="posttitle">{{$villa->nama_villa}}</h1>
				<p>
					Detail
					<ul style="list-style-type: none;">
						<li>
							Harga sewa: Rp. {{number_format($villa->harga_sewa, 0, ',', '.')}} / malam.
						</li>
						@php
							$pathsewa = route('login.socialite.redirect', 'google');
							if(Auth::check()){
								$pathsewa = route('booking.villa', $villa->uuid);
							}
						@endphp
						<li>
							<a href="{{$pathsewa}}" class="btn btn-outline-success">Sewa sekarang</a>
						</li>
					</ul>
				</p>
			</div>

			<!-- Begin Featured Image -->
			<img class="featured-image img-fluid" src="{{ asset('/uploads/images/villas/' . $villa->foto) }}" alt="{{ $villa->nama_villa }}">
			<!-- End Featured Image -->

			<!-- Begin Post Content -->
			<div class="article-post" id="editor">
                {!! $villa->deskripsi !!}
            </div>
			<!-- End Post Content -->

		</div>
		<!-- End Post -->

	</div>
</div>
<!-- End Article
================================================== -->

<div class="hideshare"></div>
@endsection

@section('c_js')
	<script>
		BalloonEditor.create(document.querySelector("#editor"), {
		}).then((editor) => {
			// make read only
			editor.isReadOnly = true;
		})
		.catch((error) => {
			console.error(error);
		});
	</script>
@endsection