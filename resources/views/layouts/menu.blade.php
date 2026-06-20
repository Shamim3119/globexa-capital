<div class="sidebar-wrapper">

        <nav class="mt-2">
                <!--begin::Sidebar Menu-->
                <ul
                class="nav sidebar-menu flex-column"
                data-lte-toggle="treeview"
                role="navigation"
                aria-label="Main navigation"
                data-accordion="false"
                id="navigation"
                >
                <li class="nav-item">
                  <a href="{{ route('dashboard') }}" class="nav-link active">
                          <i class="nav-icon bi bi-speedometer"></i>
                          <p>Dashboard</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('clients.index') }}" class="nav-link active">
                  <i class="nav-icon bi bi-universal-access"></i>
                          <p>Clients</p>
                  </a>
                </li>


                <li class="nav-item {{ request()->routeIs('bussiness.*') || request()->routeIs('profile.*') || request()->routeIs('generation-commission.*') || request()->routeIs('global-settings.*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link active">
                  <i class="nav-icon bi bi-boxes"></i>
                  <p>
                    Settings
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">

                  <li class="nav-item">
                      <a href="{{ route('global-settings.index', ['tab' => 'global-settings', 'flag' => 'true']) }}" class="nav-link {{ request('tab') == 'global-settings' ? 'active' : '' }}">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Global Settings</p>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a href="{{ route('generation-commission.index', ['tab' => 'Generation Commission', 'flag' => 'true']) }}" class="nav-link {{ request('tab') == 'generation-commission' ? 'active' : '' }}">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Generation Commission</p>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a href="{{ route('deposite-commission.index', ['tab' => 'Deposite Commission', 'flag' => 'true']) }}" class="nav-link {{ request('tab') == 'deposite-commission' ? 'active' : '' }}">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Deposite Commission</p>
                      </a>
                  </li>


 

                  <li class="nav-item">
                      <a href="{{ route('bussiness.index', ['tab' => 'Bussiness', 'flag' => 'true']) }}" class="nav-link {{ request('tab') == 'bussiness' ? 'active' : '' }}">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Bussiness</p>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a href="{{ route('profile.index', ['tab' => 'Profile', 'flag' => 'true']) }}" class="nav-link {{ request('tab') == 'profile' ? 'active' : '' }}">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Profile</p>
                      </a>
                  </li>

                </ul>
              </li>


              <li class="nav-item">
                <a onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link">
                  <i class="nav-icon bi bi-arrow-left-square"></i>
                  <p>Logout</p>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
                </form>
              </li>



                </ul>
        <!--end::Sidebar Menu-->
        </nav>

</div>