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

              <li class="nav-item {{ request()->routeIs('parameter.*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link active">
                  <i class="nav-icon bi bi-bricks"></i>
                  <p>
                    Parameters
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">

                  <li class="nav-item">
                      <a href="{{ route('parameter.index', ['tab' => 'currency']) }}" class="nav-link {{ request('tab') == 'currency' ? 'active' : '' }}">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Currency</p>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a href="{{ route('parameter.index', ['tab' => 'banking-type']) }}" class="nav-link {{ request('tab') == 'banking-type' ? 'active' : '' }}">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Banking Type</p>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a href="{{ route('parameter.index', ['tab' => 'transfer-type']) }}" class="nav-link {{ request('tab') == 'transfer-type' ? 'active' : '' }}">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Transfer Type</p>
                      </a>
                  </li>

                  

                  <li class="nav-item">
                    <a href="{{ route('bank-operator.index', ['tab' => 'bank-operator']) }}" class="nav-link {{ request('tab') == 'bank-operator' ? 'active' : '' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Bank Operator</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="{{ route('wallet-type.index', ['tab' => 'wallet-type']) }}" class="nav-link {{ request('tab') == 'wallet-type' ? 'active' : '' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Wallet Type</p>
                    </a>
                  </li>

                  <li class="nav-item">
                    <a href="{{ route('wallet-transfer.index', ['tab' => 'wallet-transfer']) }}" class="nav-link {{ request('tab') == 'wallet-transfer' ? 'active' : '' }}">
                      <i class="nav-icon bi bi-circle"></i>
                      <p>Transfer Wallet</p>
                    </a>
                  </li>


                  
 
                </ul>
              </li>

                <li class="nav-item">
                  <a href="{{ route('clients.index') }}" class="nav-link active">
                  <i class="nav-icon bi bi-universal-access"></i>
                          <p>Clients</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('deposit.index') }}" class="nav-link active">
                  <i class="nav-icon bi bi-plus-circle"></i>
                          <p>Deposit</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="{{ route('withdraw.index') }}" class="nav-link active">
                  <i class="nav-icon bi bi-dash-circle"></i>
                          <p>Withdraw</p>
                  </a>
                </li>


              <li class="nav-item {{ request()->routeIs('reference.*') || request()->routeIs('daily.*') || request()->routeIs('generation.*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link active">
                  <i class="nav-icon bi bi-currency-dollar"></i>
                  <p>
                    Income
                    <i class="nav-arrow bi bi-chevron-right"></i>
                  </p>
                </a>

                <ul class="nav nav-treeview">

                  <li class="nav-item">
                      <a href="{{ route('reference.index', ['tab' => 'reference', 'flag' => 'true']) }}" class="nav-link {{ request('tab') == 'reference' ? 'active' : '' }}">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Reference</p>
                      </a>
                  </li>


                  <li class="nav-item">
                      <a href="{{ route('daily.index', ['tab' => 'daily', 'flag' => 'true']) }}" class="nav-link {{ request('tab') == 'daily' ? 'active' : '' }}">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Daily</p>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a href="{{ route('generation.index', ['tab' => 'generation', 'flag' => 'true']) }}" class="nav-link {{ request('tab') == 'generation' ? 'active' : '' }}">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>generation</p>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a href="{{ route('salary.index', ['tab' => 'salary', 'flag' => 'true']) }}" class="nav-link {{ request('tab') == 'salary' ? 'active' : '' }}">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Salary</p>
                      </a>
                  </li>

                    <li class="nav-item">
                      <a href="{{ route('ib.index', ['tab' => 'ib', 'flag' => 'true']) }}" class="nav-link {{ request('tab') == 'ib' ? 'active' : '' }}">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>IB</p>
                      </a>
                  </li>

                </ul>
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
                      <a href="{{ route('rate.index', ['tab' => 'rate', 'flag' => 'true']) }}" class="nav-link {{ request('tab') == 'rate' ? 'active' : '' }}">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Rate</p>
                      </a>
                  </li>


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
                      <a href="{{ route('deposite-commission.index', ['tab' => 'Investment Commission', 'flag' => 'true']) }}" class="nav-link {{ request('tab') == 'investment-commission' ? 'active' : '' }}">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Investment Commission</p>
                      </a>
                  </li>


                  <li class="nav-item">
                      <a href="{{ route('investment-charge.index', ['tab' => 'Investment Charge', 'flag' => 'true']) }}" class="nav-link {{ request('tab') == 'investment-charge' ? 'active' : '' }}">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Investment Charge</p>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a href="{{ route('salary-slot.index', ['tab' => 'Salary Slot', 'flag' => 'true']) }}" class="nav-link {{ request('tab') == 'salary-slot' ? 'active' : '' }}">
                        <i class="nav-icon bi bi-circle"></i>
                        <p>Salary Slot</p>
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