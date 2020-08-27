@extends('layouts.app')

@section('title', 'Add new')

@section('content')
<div class="container">
	<div class="row">
		@include('admin.nav')
		<div class="col-md-8">
			<div class="card">
				<div class="card-header bg-info text-light">Edit : {{ $story->title }}</div>
				<div class="card-body">
					<form action="" method="post" class="form-group" enctype="multipart/form-data">
						@csrf
						@method('patch')
							<div class="row mb-2">
								<div class="col-md-6">
									<label for="picture">Gambar</label>
									<input type="file" name="picture" id="" class="form-control">
									@error('picture')
									<div class="text-danger mt-2">
										{{ $message }}
									</div>
									@enderror
								</div>
								<div class="col-md-6">
									<label for="type">jenis Cerita</label>
									<select name="type" id="" class="form-control">
										<option value="cerpen" {{ $story->type == 'cerpen' ? 'selected' : '' }}>Cerpen</option>
										<option value="novel" {{ $story->type == 'novel' ? 'selected' : '' }}>Novel</option>
									</select>
								</div>
							</div>
							<div class="row">
								<div class="col-md-6">
									<label for="title">Judul</label>
									<input type="text" value="{{ $story->title }}" name="title" id="" class="form-control">
									@error('title')
									<div class="text-danger mt-2">
										{{ $message }}
									</div>
									@enderror
								</div>
								<div class="col-md-6">
									<label for="category">Genre</label>
									<select type="text" name="category" id="" class="form-control">
										<option selected>Pilih kategori</option>
										@foreach($categories as $category)
										<option value="{{ $category->id }}" {{ $category->id == $story->category->id ? 'selected' : '' }}>{{ $category->name }}</option>
										@endforeach
									</select>
									@error('category')
									<div class="text-danger mt-2">
										{{ $message }}
									</div>
									@enderror
								</div>
							</div>
						
						<div class="row col-xl-12 mt-2">
							<label for="content">Isi</label>
							<textarea name="content" id="" rows="20" class="form-control">{{ $story->content }}</textarea>
							@error('content')
							<div class="text-danger mt-2">
								{{ $message }}
							</div>
							@enderror
						</div>
						<div class="row col-md-4 mt-2">
							<button type="submit" class="btn btn-primary">Simpan</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection