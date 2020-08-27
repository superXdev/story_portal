@extends('layouts.app')

@section('title', 'Profile kamu')

@section('content')

<div class="container">
	<div class="row">
		@include('admin.nav')
		<div class="col-md-8">
			<div class="card">
				<div class="card-header bg-primary text-light">Pengaturan profile</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-4 text-center">
							<img src="/storage/{{ $user->photo_profile }}" alt="" class="rounded" width="150">
						</div>
						<div class="col-md-8">
							<dl class="mt-3">
								<dt>Username</dt>
								<dd>{{ $user->username }}</dd>
								<dt>Email</dt>
								<dd>{{ $user->email }}</dd>
							</dl>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 mt-3">
							<ul class="nav nav-tabs" id="settingTab" role="tablist">
								<li class="nav-item" role="presentation">
									<a href="#general" class="nav-link" id="general-tab" data-toggle="tab">Umum</a>
								</li>
								<li class="nav-item" role="presentation">
									<a href="#sosmed" class="nav-link" id="sosmed-tab" data-toggle="tab">Sosmed</a>
								</li>
								<li class="nav-item" role="presentation">
									<a href="#bio" class="nav-link" id="bio-tab" data-toggle="tab">Biodata</a>
								</li>
							</ul>
							<div class="tab-content">
								<div class="tab-pane fade" id="general" role="tabpanel">
									<div class="row mt-2">
										<div class="col-md-12">
											<div class="form-group">
												<label for="name">Nama</label>
												<input type="text" name="name" class="form-control" value="{{ $user->name }}">
											</div>
											
										</div>
									</div>
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="jk">Jenis kelamin</label>
												<select name="jk" id="" class="form-control">
													<option value="male" {{ ($user->profile->gender == 'male') ? 'selected' : '' }}>Laki-laki</option>
													<option value="female" {{ ($user->profile->gender == 'female') ? 'selected' : '' }}>Perempuan</option>
												</select>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="db">Tanggal lahir</label>
												<input type="date" name="date" class="form-control" value="{{ $user->profile->birth_date }}">
											</div>
										</div>
										<div class="col-md-6">
											<button class="btn btn-primary" id="btn-general">Simpan</button>
										</div>
									</div>
								</div>
								<div class="tab-pane fade" id="sosmed" role="tabpanel">
									<div class="form-group mt-2">
										<label for="facebook">Facebook</label>
										<input type="text" class="form-control" name="facebook" value="{{ $user->profile->facebook_link }}">
									</div>
									<div class="form-group">
										<label for="instagram">Instagram</label>
										<input type="text" class="form-control" name="instagram" value="{{ $user->profile->instagram_link }}">
									</div>
									<div class="form-group">
										<label for="twitter">Twitter</label>
										<input type="text" name="twitter" class="form-control"value="{{ $user->profile->twitter_link }}">
									</div>
									<button class="btn btn-primary" id="btn-sosmed">Simpan</button>
								</div>
								<div class="tab-pane fade" id="bio" role="tabpanel">
									<div class="toast" id="notif">
										<div class="toast-header" role="alert" aria-live="assertive" aria-atomic="true">
											<strong class="mr-auto">Notif</strong>
											<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
												<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="toast-body">
											Profile berhasil diupdate!
										</div>
									</div>
									<div class="form-group mt-2">
										<label for="status_bio">Status</label>
										<textarea class="form-control" name="status_bio" id="" cols="30" rows="10">{{ $user->profile->status_bio }}</textarea>
									</div>
									<button class="btn btn-primary" id="btn-bio">Simpan</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@csrf
<input type="hidden" id="myId" value="{{ $user->profile->id }}">
@endsection

@section('script')
	<script>
		$(document).ready(function(){
						$('#notif').toast('show');
			$('#settingTab li:first-child a').tab('show');

			$('#btn-sosmed').click(function(){
				$.ajax({
					url: '{{ route('admin.profile.save') }}',
					method: 'POST',
					data: { 
						id: $('#myId').val(),
						_token: $('input[name="_token"]').val(), 
						type:'sosmed',
						facebook_link: $('input[name="facebook"]').val(),
						instagram_link: $('input[name="instagram"]').val(),
						twitter_link: $('input[name="twitter"]').val()
					},
					success: function(){
						alert('Berhasil!');
					}
				});
			});

			$('#btn-general').click(function(){
				$.ajax({
					url: '{{ route('admin.profile.save') }}',
					method: 'POST',
					data: { 
						id: $('#myId').val(),
						_token: $('input[name="_token"]').val(), 
						type:'general',
						name: $('input[name="name"]').val(),
						gender: $('select[name="jk"]').val(),
						birth_date: $('input[name="date"]').val()
					},
					success: function(){
						alert('Berhasil!');
					}
				});
			});

			$('#btn-bio').click(function(){
				$.ajax({
					url: '{{ route('admin.profile.save') }}',
					method: 'POST',
					data: { 
						id: $('#myId').val(),
						_token: $('input[name="_token"]').val(), 
						type: 'bio',
						bio: $('textarea[name="status_bio"]').val()
					},
					success: function(){
						$('#notif').toast('show');
					}
				});
			});

		});
		
	</script>
@endsection