@extends('layouts.app2')

@section('title',  $story->title)

@section('content')
<div class="container">
	<div class="row" style="font-size: 16px">
		<div class="col-md-8">
			<div class="card mb-3">
				<img style="max-height: 340px;object-fit: cover;" src="/storage/{{ $story->picture }}" alt="">
				<div class="card-body">
					<div class="card-title">
						<h4>{{ ucfirst($story->title) }}</h4>
						<div class="card-secondary">
							<a href="{{ route('stories.type', $story->type) }}">{{ ucfirst($story->type) }}</a> - <a href="{{ route('stories.category', $story->category->slug) }}">{{ $story->category->name }}</a>
						</div>
						<div class="text-secondary">
							Di buat oleh <a href="">{{ $story->author->name }}</a>
						</div>
						<div class="text-secondary">
							<li class="fas fa-clock"></li> {{ $story->created_at->diffForHumans() }}
							<li class="fas fa-eye"></li> {{ $story->views }}x dilihat
						</div>
					</div>
					{!! nl2br($story->content) !!}
					<div class="d-flex justify-content-between mt-3">
						<div>
							<a href="#upvote" style="text-decoration: none;color: black">
								<div class="lead" style="font-size: 24px" id="upvote">
									<li class="fas fa-heart"></li> <strong id="likes">{{ $story->likes }}</strong>
								</div>
							</a>
						</div>
						
						<div>
							<a href="#" class="btn btn-primary btn-sm"><li style="font-size: 18px" class="fab fa-facebook-square"></li> Share</a>
							<a href="#" class="btn btn-info text-light btn-sm"><li style="font-size: 18px"  class="fab fa-twitter"></li> Tweet</a>
							<a href="#" class="btn btn-success btn-sm"><li style="font-size: 18px"  class="fab fa-whatsapp"></li> Share</a>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		@csrf
		<div class="col-md-4">
			@include('stories.sidebar')
		</div>
	</div>
</div>
@endsection

@section('script')
	<script>
		$(document).ready(function(){
			if(Cookies.get('upvote_{{ $story->id }}') == "ok"){
				$('.fas.fa-heart').css('color', 'red');
			}
			$('#upvote').click(function(){
				if(Cookies.get('upvote_{{ $story->id }}') == undefined){
					$('#likes').html(parseInt($('#likes').html()) + 1);
					$('.fas.fa-heart').css('color', 'red');
					$.post('{{ route('stories.like') }}',{
						_token: $('input[name="_token"]').val(),
						id: {{ $story->id }}
					},function(){
						Cookies.set('upvote_{{ $story->id }}', 'ok');
					});
				}
			});
		});
	</script>
@endsection