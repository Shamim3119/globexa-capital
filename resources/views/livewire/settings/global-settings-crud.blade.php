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
                            <label>Referance Direct Commission</label>
                            <input type="text" class="form-control" wire:model="ref_comm">
                            @error('ref_comm') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>Generation Commission Level</label>
                            <input type="text" class="form-control" wire:model="gen_comm_level">
                            @error('gen_comm_level') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>Investment Commission Level</label>
                            <input type="text" class="form-control" wire:model="dep_comm_level">
                            @error('dep_comm_level') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>Investment Charge Level</label>
                            <input type="text" class="form-control" wire:model="inv_charge_level">
                            @error('inv_charge_level') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>


                        <div class="mb-3">
                            <label>IVR Commission %</label>
                            <input type="text" class="form-control" wire:model="ivr_com">
                            @error('ivr_com') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label>Minimum Activation</label>
                            <input type="text" class="form-control" wire:model="min_activation">
                            @error('min_activation') <span class="text-danger">{{ $message }}</span> @enderror      
                        </div>
                        <div class="mb-3">
                            <label>Minimum Deposit</label>
                            <input type="text" class="form-control" wire:model="min_deposit">
                            @error('min_deposit') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label>Minimum Withdrawal</label>
                            <input type="text" class="form-control" wire:model="min_withdrawal">
                            @error('min_withdrawal') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>Minimum P2P</label>
                            <input type="text" class="form-control" wire:model="min_p2p">
                            @error('min_p2p') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>Minimum Transfer</label>
                            <input type="text" class="form-control" wire:model="min_transfer">
                            @error('min_transfer') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>Maximum Activation</label>
                            <input type="text" class="form-control" wire:model="max_activation">
                            @error('max_activation') <span class="text-danger">{{ $message }}</span> @enderror 
                        </div>
                        <div class="mb-3">
                            <label>Maximum Deposit</label>
                            <input type="text" class="form-control" wire:model="max_deposit">
                            @error('max_deposit') <span class="text-danger">{{ $message }}</span> @enderror 
                        </div>
                        <div class="mb-3">
                            <label>Maximum Withdrawal</label>
                            <input type="text" class="form-control" wire:model="max_withdrawal">
                            @error('max_withdrawal') <span class="text-danger">{{ $message }}</span> @enderror  
                        </div>
                        <div class="mb-3">
                            <label>Maximum P2P</label>
                            <input type="text" class="form-control" wire:model="max_p2p">
                            @error('max_p2p') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>Maximum Transfer</label>
                            <input type="text" class="form-control" wire:model="max_transfer">
                            @error('max_transfer') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
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