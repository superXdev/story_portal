<div class="col-md-4 mb-3">
	<div class="list-group">
		<a href="{{ route('admin.index') }}" class="list-group-item list-group-item-action{{ Request::is('admin/dashboard') ? ' active' : '' }}"><li class="fas fa-chart-line"></li> Dashboard</a>
		<a href="{{ route('admin.new') }}" class="list-group-item list-group-item-action{{ Request::is('admin/new') ? ' active' : '' }}"><li class="fas fa-plus"></li> Tambahkan cerita</a>
		<a href="{{ route('admin.all') }}" class="list-group-item list-group-item-action{{ Request::is('admin/all') ? ' active' : '' }}"><li class="fas fa-book"></li> Lihat semua</a>
		<a href="{{ route('admin.profile') }}" class="list-group-item list-group-item-action{{ Request::is('admin/profile') ? ' active' : '' }}"><li class="fas fa-users-cog"></li> Profile</a>
		<a href="{{ route('admin.settings') }}" class="list-group-item list-group-item-action{{ Request::is('admin/settings') ? ' active' : '' }}"><li class="fas fa-cogs"></li> Settings</a>
	</div>
</div>