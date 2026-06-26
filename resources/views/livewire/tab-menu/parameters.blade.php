    <!-- Tabs -->
    <ul class="nav nav-tabs">

        <li class="nav-item">
            <a href="{{ route('parameter.index', ['tab' => 'currency']) }}"
            class="nav-link {{ $activeTab == 'currency' ? 'active' : '' }}">
                Currency
            </a>
        </li>
        
        <li class="nav-item">
            <a href="{{ route('parameter.index', ['tab' => 'banking-type']) }}"
            class="nav-link {{ $activeTab == 'banking-type' ? 'active' : '' }}">
                Banking Type
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('parameter.index', ['tab' => 'transfer-type']) }}"
            class="nav-link {{ $activeTab == 'transfer-type' ? 'active' : '' }}">
                Transfer Type
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('bank-operator.index', ['tab' => 'bank-operator']) }}"
            class="nav-link {{ $activeTab == 'bank-operator' ? 'active' : '' }}">
                Bank Operator
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('wallet-type.index', ['tab' => 'wallet-type']) }}"
            class="nav-link {{ $activeTab == 'wallet-type' ? 'active' : '' }}">
               Wallet Type
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('wallet-transfer.index', ['tab' => 'wallet-transfer']) }}"
            class="nav-link {{ $activeTab == 'wallet-transfer' ? 'active' : '' }}">
               Transfer Wallet 
            </a>
        </li>

        
    </ul>

    <br>