@extends('layouts.app2')

@section('title', 'Daftar Cerpen')

@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-8">
			@isset($search)
			<h4>Hasil pencarian: {{ $search }}</h4>
			@endisset
			<table class="table table-bordered bg-white">
				@foreach($stories as $story)
				<tr>
					<td>
						<h4><a style="color: salmon;text-decoration: none;" href="/stories/{{ $story->slug }}">{{ $story->title }}</a></h4>
						<div class="text-secondary">
							<i class="fas fa-user"></i> {{ $story->author->name }} - {{ ucfirst($story->type) }}
						</div>
						<div class="text-secondary">
							<i class="fas fa-calendar"></i> {{ $story->created_at }}
						</div>
						{{ \Str::limit($story->content, 240) }}
					</td>
				</tr>
				@endforeach
			</table>
			{{ $stories->links() }}
		</div>
		<div class="col-md-4">
			@include('stories.sidebar')
		</div>
	</div>
</div>
@endsection