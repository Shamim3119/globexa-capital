    <ul class="nav nav-tabs">

        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'rate' ? 'active' : '' }}" 
            href="{{ route('rate.index', ['tab' => 'rate']) }}">
            Rate
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'global-settings' ? 'active' : '' }}" 
            href="{{ route('global-settings.index', ['tab' => 'global-settings']) }}">
            Global Settings
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'generation-commission' ? 'active' : '' }}" 
            href="{{ route('generation-commission.index', ['tab' => 'generation-commission']) }}">
            Generation Commission
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'investment-commission' ? 'active' : '' }}" 
            href="{{ route('deposite-commission.index', ['tab' => 'investment-commission']) }}">
            Investment Commission
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'investment-charge' ? 'active' : '' }}" 
            href="{{ route('investment-charge.index', ['tab' => 'investment-charge']) }}">
            Investment Charge
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'salary-slot' ? 'active' : '' }}" 
            href="{{ route('salary-slot.index', ['tab' => 'salary-slot']) }}">
            Salary Slot
            </a>
        </li>

        

        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'bussiness' ? 'active' : '' }}" 
            href="{{ route('bussiness.index', ['tab' => 'bussiness']) }}">
            Business
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'profile' ? 'active' : '' }}" 
            href="{{ route('profile.index', ['tab' => 'profile']) }}">
            Profile
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'change-password' ? 'active' : '' }}" 
            href="{{ route('change-password.index', ['tab' => 'change-password']) }}">
            Change Password
            </a>
        </li>
    </ul>
    <br>