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

                        <div class="mb-3">
                            <label>Deposit Conversion Rate 1 $ = BDT Amount </label>
                            <input type="text" class="form-control" wire:model="deposit_rate">
                            @error('deposit_rate') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label>Witdraw Conversion Rate 1 $ = BDT Amount </label>
                            <input type="text" class="form-control" wire:model="withdraw_rate">
                            @error('withdraw_rate') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
 
                    </div>
                    <div class="card-footer">
                        <div class="m-3 d-flex justify-content-center">
            
                                <button type="submit" class="btn btn-success">Update</button>&nbsp;&nbsp;
                                <a href="{{ route('bussiness.index', ['tab' => 'bussiness']) }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
   </div>

    {!! Toast::get_toast_message() !!}


</div>
