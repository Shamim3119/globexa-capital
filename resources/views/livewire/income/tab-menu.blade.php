    <ul class="nav nav-tabs">

        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'reference' ? 'active' : '' }}" 
            href="{{ route('reference.index', ['tab' => 'reference']) }}">
            Reference
            </a>
        </li>
 
        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'daily' ? 'active' : '' }}" 
            href="{{ route('daily.index', ['tab' => 'daily']) }}">
            Daily
            </a>
        </li>   
        
        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'generation' ? 'active' : '' }}" 
            href="{{ route('generation.index', ['tab' => 'generation']) }}">
            Generation
            </a>                        
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'salary' ? 'active' : '' }}" 
            href="{{ route('salary.index', ['tab' => 'salary']) }}">
            Salary
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'ib' ? 'active' : '' }}" 
            href="{{ route('ib.index', ['tab' => 'ib']) }}">
            IB
            </a>
        </li>

    </ul>
    <br>