<nav id="sidebar" class="sidebar-container">
    <div class="custom-menu">
      <button type="button" id="sidebarCollapse" class="btn btn-primary">
        <i class="fa fa-bars"></i>
        <span class="sr-only">Toggle Menu</span>
    </button>
  </div>
	<div class="p-4">
		<div class="row mb-2 justify-content-center align-items-center">
			<img src="{{ asset('mulawin.png') }}" alt="" width="60" height="65">
			<div class="col">
				<h6><strong>{{ Auth::user()->name }}</strong></h6>
				<small>{{ Auth::user()->email }}</small>
			</div>
			<div class="col mt-3">
				<h3 class="text-warning">{{ Auth::user()->detail->loft_name }}</h3>
				<span class=""><strong>{{ Auth::user()->detail->phone }}</strong></span>
			</div>
		</div>
      <ul class="list-unstyled components mb-5">
			<li class="{{ request()->is('/') ? 'active' : '' }}">
				<a href="/"><span class="fa fa-home mr-3"></span> Home</a>
			</li>
			<li class="{{ request()->is('tournaments') ? 'active' : '' }}">
				<a href="/tournaments"><i class="fas fa-poll-h mr-3"></i> Tournaments</a>
			</li>
			@hasrole('User')
				<li class="{{ request()->is('my-pigeons') ? 'active' : '' }}">
					<a href="/my-pigeons"><i class="fas fa-dove mr-3"></i> My Pigeons</a>
				</li>
			@endhasrole
			<li class="{{ request()->is('coordinates') ? 'active' : '' }}">
				<a href="/coordinates"><i class="fas fa-thumbtack mr-3"></i> View Coordinates</a>
			</li>
			@if (Auth::user()->hasRole('Admin'))
				<li class="{{ request()->is('generate-qrcode') ? 'active' : '' }}">
					<a href="/generate-qrcode"><i class="fas fa-qrcode mr-3"></i> Generate QR Code</a>
				</li>
			@endif
			@hasrole('Admin')
				<li class="{{ request()->is('clubs') ? 'active' : '' }}">
					<a href="/clubs"><i class="fas fa-users mr-3"></i>Clubs</a>
				</li>
			@endhasrole
			@hasrole('User')
				<li class="{{ request()->is('clubs') ? 'active' : '' }}">
					<a href="/clubs/{{ Auth::user()->club()->id }}">
						<img 
							class="img-responsive rounded mr-2" 
							src="{{ Auth::user()->club()->logo_path }}" 
							alt="Card image cap"
							width="25"
							height="25"
						>
						{{ Auth::user()->club()->name }}</a>
				</li>
			@endhasrole
			@if (Auth::user()->hasRole('Admin'))
				<li class="{{ request()->is('register') ? 'active' : '' }}">
					<a href="/register"><i class="fas fa-user-plus mr-3"></i> Generate Player</a>
				</li>
			@endif
			<li>
				<a href="#" class="nav-link" onclick="document.getElementById('logout__form').submit()">
					<p><i class="fas fa-sign-out-alt mr-3"></i>Logout</p>
					<form action="{{ route('logout') }}" method="POST" id="logout__form">
						@csrf
					</form>
              	</a>
			</li>
      </ul>

      <div class="footer">
		<p>Copyright &copy;
			<script>document.write(new Date().getFullYear());</script> All rights reserved
		</p>
      </div>

  </div>
</nav>