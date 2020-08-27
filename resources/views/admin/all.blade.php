@extends('layouts.app')

@section('title', 'Tampilkan semua')

@section('content')
<div class="container">
	<div class="row">
		@include('admin.nav')
		<div class="col-md-8">
			@if(session()->has('success'))
			<div class="alert alert-success">{{ session()->get('success') }}</div>
			@endif
			<div class="card">
				<div class="card-header bg-info text-light">Daftar ceritamu</div>
				<div class="card-body">
					<div class="table-responsive">
					<table class="table">
						<thead class="thead-light">
						    <tr>
						      <th scope="col">#</th>
						      <th scope="col">Judul</th>
						      <th scope="col">Jumlah dilihat</th>
						      <th scope="col">Kategori</th>
						      <th scope="col">Opsi</th>
						    </tr>
						</thead>
						<tbody>
							@foreach($stories as $story)
						   <tr>
						      <td scope="row">{{ $no++ }}</td>
						      <td>{{ $story->title}}</td>
						      <td>{{ $story->views }}</td>
						      <td>{{ $story->category->name }}</td>
						      <td class="text-center">
						      	<button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pilihan</button>
							    <div class="dropdown-menu">
							      <a class="dropdown-item delete-btn" href="{{ route('stories.show',$story->slug) }}" target="_blank">Lihat</a>
							      <div role="separator" class="dropdown-divider"></div>
							      <a class="dropdown-item" href="{{ route('admin.edit', $story->id) }}">Ubah</a>
							      <div role="separator" class="dropdown-divider"></div>
							      <a class="dropdown-item delete-btn" href="#" id="{{ $story->id }}">Hapus</a>
							    </div>
						      </td>
						    </tr>
						    @endforeach
						</tbody>
					</table>
				</div>
				</div>
			</div>
			<!-- Modal -->
			<div class="modal fade" id="modal-delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi</h5>
			        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
			          <span aria-hidden="true">&times;</span>
			        </button>
			      </div>
			      <div class="modal-body">
			        Apakah kamu yakin ingin menghapus cerita ini?
			        <form action="/admin/delete" method="post">
			        	@csrf
			        	@method('delete')
			        	<input type="hidden" name="id" value="" id="input-id">
			        	<button type="submit" class="btn btn-success">Ya</button>
			        	<button type="button" class="btn btn-danger" data-dismiss="modal">Tidak</button>
			        </form>
			      </div>
			      <div class="modal-footer">
			        
			      </div>
			    </div>
			  </div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
	<script>
		$(document).ready(function(){
			$('.delete-btn').click(function(){
				var id = $(this).attr('id');

				$('#input-id').val(id);
				$('#modal-delete').modal('show');
			})
			
		})
		
	</script>
@endsection