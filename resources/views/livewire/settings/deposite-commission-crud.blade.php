@php
    use App\Helpers\Toast;
@endphp

<div>
    @include('livewire.settings.tab-menu')

    <div class='row'>
        <div class='col-6'>
            <form wire:submit.prevent="save">
                <div class="card card-primary card-outline mb-4">
                    <div class="card-header">
                        <div class="card-title">{{ ucfirst($activeTab) }} Update</div>
                    </div> 
                    <div class="card-body m-3">

                        @for($i = 1; $i <= $dep_comm_level; $i++)

                            <div class="mb-3">
                                <div class='row'>
                                    <div class='col-6'>
                                        <label>
                                            Validity Days {{ $i }}
                                        </label>

                                        <input
                                            type="text"
                                            class="form-control"
                                            wire:model="days.{{ $i }}"
                                        >

                                        @error("days.$i")
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class='col-6'>
                                        <label>
                                            Commission Level {{ $i }}
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
                                </div>
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