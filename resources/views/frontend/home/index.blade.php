@extends('layouts.frontend')
@section('title', 'Home')

@section('content')
    <!-- Begin Featured
	================================================== -->
	<section class="featured-posts">
        <div class="section-title">
            <h2><span>Featured Villas</span></h2>
        </div>
        <div class="card-columns listfeaturedtag" id="featured-villa">

            {{-- loading text --}}
            <h4 class="text-muted font-weight-bold">Loading...</h4>
        </div>
	</section>
	<!-- End Featured
	================================================== -->
@endsection

@section('c_js')
    @include('_partials.cjs.ajaxPromise')

    <script>
        async function getFeaturedVilla() {
            try {
                const response = await HitData("{{ route('api.data.villa') }}", null, 'GET');
                const data = response.data;
                
                var html  = '';
                data.map((villa, i) => {
                    html += `<div class="card">
                            <div class="row">
                                <div class="col-md-5 wrapthumbnail">
                                    <a href="${"{{route('villa.detail', ':id')}}".replace(':id', villa.uuid)}">
                                        <div class="thumbnail" style="background-image:url(${villa.foto_path});">
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-7">
                                    <div class="card-block">
                                        <h2 class="card-title"><a href="${"{{route('villa.detail', ':id')}}".replace(':id', villa.uuid)}">${villa.nama_villa}</a></h2>
                                        <h4 class="card-text">${villa.deskripsi}</h4>
                                        <div class="metafooter">
                                            <div class="wrapfooter">
                                                
                                                <span class="author-meta">
                                                <span class="post-date font-weight-bold">${villa.harga_sewa}</span><span class="dot"></span><span class="post-read">Per malam.</span>
                                                </span>
                                                <span class="post-read-more"><a href="${"{{route('villa.detail', ':id')}}".replace(':id', villa.uuid)}" title="Detail villa"><svg class="svgIcon-use" width="25" height="25" viewbox="0 0 25 25"><path d="M19 6c0-1.1-.9-2-2-2H8c-1.1 0-2 .9-2 2v14.66h.012c.01.103.045.204.12.285a.5.5 0 0 0 .706.03L12.5 16.85l5.662 4.126a.508.508 0 0 0 .708-.03.5.5 0 0 0 .118-.285H19V6zm-6.838 9.97L7 19.636V6c0-.55.45-1 1-1h9c.55 0 1 .45 1 1v13.637l-5.162-3.668a.49.49 0 0 0-.676 0z" fill-rule="evenodd"></path></svg></a></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>`;
                })

                $('#featured-villa').html(html);
            } catch (error) {
                console.log(error);
            }
        }

        $(document).ready(()=>{
            getFeaturedVilla();
        });
    </script>
@endsection