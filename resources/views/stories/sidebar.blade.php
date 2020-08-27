
<div class="card mb-3">
	<div class="card-body">
		<div class="card-title"><h5>Pencarian</h5></div>
		<form action="{{ route('stories.search') }}" method="get">
			<div class="input-group">
			      <input type="text" class="form-control" name="qr">
			    <div class="input-group-append">
			       <button class="btn btn-outline-secondary" type="submit"><i class="fas fa-search"></i></button>
			    </div>
			  </div>
		</form>
	</div>
</div>
<div class="card">
	<div class="card-header" style="color: white;background-color: salmon">
		<i class="fas fa-book"></i> Rekomendasi lainnya
	</div>
	<div class="card-body">
		<ul class="list-group list-group-flush">
			@foreach($stories as $list_story)
			<li class="list-group-item">
					<h6><a style="color: salmon;text-decoration: none;" href="/stories/{{ $list_story->slug }}">{{ $list_story->title }}</a></h6>
					<p><small>{{ \Str::limit($list_story->content, 100) }}</small></p>
			</li>
			@endforeach
		</ul>
	</div>
</div>
