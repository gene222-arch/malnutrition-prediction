<nav id="sidebar" class="sidebar-container">
    <div class="custom-menu">
      <button type="button" id="sidebarCollapse" class="btn btn-primary">
        <i class="fa fa-bars"></i>
        <span class="sr-only">Toggle Menu</span>
    </button>
  </div>
	<div class="p-4">
		<div class="row mb-5 justify-content-center align-items-center">
			<div class="col">
				<h6><strong>{{ Auth::user()->name }}</strong></h6>
				<small>{{ Auth::user()->email }}</small>
			</div>
		</div>
      <ul class="list-unstyled components mb-5">
			<li class="{{ request()->is('/') ? 'active' : '' }}">
				<a href="/"><span class="fa fa-home mr-3 {{ request()->is('/') ? 'text-info' : '' }}"></span> Dashboard</a>
			</li>
			@hasrole('Administrator|Barangay Nutrition Scholar')
				<li class="{{ request()->is('parents') ? 'active' : '' }}">
					<a href="/parents"><i class="fas fa-user mr-3 {{ request()->is('parents') ? 'text-info' : '' }}"></i> Parents</a>
				</li>
			@endhasrole
			@hasrole('Administrator')
				<li class="{{ request()->is('brgy-nutrition-scholars') || request()->is('brgy-nutrition-scholars/*') ? 'active' : '' }}">
					<a href="/brgy-nutrition-scholars"><i class="fas fa-user mr-3 {{ request()->is('brgy-nutrition-scholars') || request()->is('brgy-nutrition-scholars/*') ? 'text-info' : '' }}"></i> BNS</a>
				</li>
			@endhasrole
			<li class="{{ request()->is('check-ups')  || request()->is('check-ups/*') ? 'active' : '' }}">
				<a href="/check-ups"><i class="fas fa-hospital-user mr-3 {{ request()->is('check-ups')  || request()->is('check-ups/*') ? 'text-info' : '' }}"></i>Check ups</a>
			</li>
			<li>
				<a href="#" class="nav-link" onclick="document.getElementById('logout__form').submit()">
					<p><i class="fas fa-sign-out-alt mr-3 text-light"></i>Logout</p>
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