@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container">
	<div class="row">
		@include('admin.nav')
		<div class="col-md-8">
			<div class="card">
				<div class="card-header bg-primary text-light">Dashboard</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-4">
							<div class="card mb-2">
								<div class="card-body border-magenta">
									<div class="h3">{{ $text }}</div>
									<div class="text-secondary">Jumlah teks</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card mb-2">
								<div class="card-body border-orange">
									<div class="h3">{{ $views }}</div>
									<div class="text-secondary">Jumlah dibaca</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card mb-2">
								<div class="card-body border-red">
									<div class="h3">{{ $likes }}</div>
									<div class="text-secondary">Jumlah like</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row py-4">
						<div class="col-md-12">
							<h4>10 Tulisan teratas</h4>
							<table class="table">
								<thead>
									<tr>
										<th>No.</th>
										<th>Judul</th>
										<th>Jumlah dibaca</th>
										<th>Diterbitkan</th>
									</tr>
								</thead>
								<tbody>
									@foreach($stories as $story)
									<tr>
										<td>{{ $no++ }}</td>
										<td>{{ $story->title }}</td>
										<td>{{ $story->views }}</td>
										<td>{{ $story->created_at }}</td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection