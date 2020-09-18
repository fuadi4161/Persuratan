@extends('layouts.app')

@section('content')
<div class="row">
<div class="col-md-12 ">
	<div class="card text-left">
		<div class="card-body">
			<ul class="nav nav-tabs" id="myIconTab" role="tablist">
			<h3 class="" style="margin: 0 20px 0px 0px;padding: 5px;">Surat Masuk</h3>
			</ul>
			@include('layouts.alert', ['$errors' => $errors])
				<a href="/tenant/buatsurat"><li  class="btn btn-danger btn-sm mt-2" width="10%" >Buat Surat</li></a>
			<div class="tab-content" id="myIconTabContent" style="padding: 1rem 0 !important; ">
				<div class="tab-pane fade show active" id="homeIcon" role="tabpanel" aria-labelledby="home-icon-tab">
					<table class="display table" id="masuk" style="width:100%">
						<thead>
							<tr>
							<th width="65%">Surat</th>
							<th width="15%">Kategori</th>
							<th width="15%">Tanggal</th>
							<th width="5%">Action</th>
							</tr>
						</thead>
						<tbody>
						@foreach($disposisi as $d)
						@if ( $d->inkubator_id == Auth::user()->inkubator_id )
							@if ( $d->user_id == Auth::user()->id )
							
							<tr>
								<td>
								<a href="/tenant/suratmasuk/{{ $d->surat->id }}">
										<strong>{{ $d->surat->title }}</strong>
										<p>{{ str_limit($d->surat->perihal, $limit = 80, $end = '') }}</p>
								</a>
								</td>
								<td><a class="badge badge-primary m-2 p-2" href="#">{{ $d->surat->jenis_surat }}</a></td>
								<td>{{ $d->surat->created_at }}</td>
								<td><a class="ul-link-action text-success" href="/inkubator/surat/edit/{{ $d->id }}" data-toggle="tooltip" data-placement="top" title="Edit"><i class="i-Edit"></i></a><a class="ul-link-action text-danger mr-1" href="/mentor/surat/hapus/{{ $d->id }}" data-toggle="tooltip" data-placement="top" title="Want To Delete !!!"><i class="i-Eraser-2"></i></a></td>
							</tr>
							
							@endif
						@endif
						@endforeach
						</tbody>
					</table>
				</div>
				
				<div class="tab-pane fade" id="contactIcon" role="tabpanel" aria-labelledby="contact-icon-tab">Etsy mixtape wayfarers, ethical wes anderson tofu before they sold out mcsweeney's organic lomo retro fanny pack lo-fi farm-to-table readymade. Messenger bag gentrify pitchfork tattooed craft beer, iphone skateboard locavore.</div>
			</div>
		</div>
	</div>
</div>
</div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{asset('theme/css/plugins/datatables.min.css')}}" />
@endsection
@section('js')
	<script src="{{asset('theme/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('theme/js/scripts/contact-list-table.min.js')}}"></script>
    <script src="{{asset('theme/js/scripts/datatables.script.min.js')}}"></script>
	<script src="{{asset('theme/js/plugins/datatables.min.js')}}"></script>
    <script src="{{asset('theme/js/scripts/tooltip.script.min.js')}}"></script>
    <script>
        $('#masuk').DataTable({
			responsive:true,
		});
		
		$('#keluar').DataTable({
			responsive:true,
		});
    </script>
@endsection