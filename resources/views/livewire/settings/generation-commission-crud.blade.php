@php
    use App\Helpers\Toast;
@endphp

<div>
    <ul class="nav nav-tabs">

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
            <a class="nav-link {{ $activeTab == 'deposite-commission' ? 'active' : '' }}" 
            href="{{ route('deposite-commission.index', ['tab' => 'deposite-commission']) }}">
            Deposite Commission
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
            User Profile
            </a>
        </li>
    </ul>
    <br>

    <div class='row'>
        <div class='col-6'>
            <form wire:submit.prevent="save">
                <div class="card card-primary card-outline mb-4">
                    <div class="card-header">
                        <div class="card-title">{{ ucfirst($activeTab) }} Update</div>
                    </div> 
                    <div class="card-body m-3">

                        @for($i = 1; $i <= $gen_comm_level; $i++)

                            <div class="mb-3">
                                <label>
                                    Generation Commission Level {{ $i }}
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    wire:model="commissions.{{ $i }}"
                                >

                                @error("commissions.$i")
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                        @endfor

                    </div>
                    <div class="card-footer">
                        <div class="m-3 d-flex justify-content-center">
            
                                <button type="submit" class="btn btn-success">Update</button>&nbsp;&nbsp;
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
   </div>

    {!! Toast::get_toast_message() !!}

</div>