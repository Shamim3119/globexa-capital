@php
    use App\Helpers\Toast;
@endphp

<div>
    @include('livewire.settings.tab-menu')

        <div class='row'>
        <div class='col-12 col-md-8'>
            <button 
                wire:click="create"
                class="mb-3 btn btn-sm btn-primary"
                @if($updateMode) style="display:none;" @endif >
                New {{ ucfirst($activeTab) }}
            </button>
         
 
            <div @if(!$updateMode) style="display:none;" @endif id='boxNew' class="card card-primary card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">{{ ucfirst($activeTab) }} Update</div>
                </div>

                <form wire:submit.prevent="store" wire:key="slot-form-{{ $updateMode ? 'edit' : 'create' }}">
                    
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="mb-2">Name :</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Name"
                                wire:model.defer="name"
                            >
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                    <div class="mb-3">
                        <label class="mb-2">Rank :</label>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Rank"
                            wire:model.defer="rank"
                        >
                        @error('rank')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                        <div class="mb-3">
                            <label class="mb-2">Team A Amount :</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Name"
                                wire:model.defer="left_amount"
                            >
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                        <div class="mb-3">
                            <label class="mb-2">Team B Amount  :</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Name"
                                wire:model.defer="right_amount"
                            >
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="mb-2">Salary Amount  :</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Salary Amount"
                                wire:model.defer="salary_amount"
                            >
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="m-3 d-flex justify-content-center">
                            @if($slot_id)
                                <button type="submit" class="btn btn-primary">Update</button>&nbsp;&nbsp;
                                <button type="button" wire:click="cancel" class="btn btn-secondary">Cancel</button>
                            @else
                                <button type="submit" class="btn btn-success">Save</button>&nbsp;&nbsp;
                                <button type="button" wire:click="cancel" class="btn btn-secondary">Cancel</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        
    

            <div @if($updateMode) style="display:none;" @endif id='boxView' class="card card-primary card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">{{ ucfirst($activeTab) }} List</div>
                </div>
                <div class="card-body">

                    <table class="table table-bordered mt-3">

                        <thead>
                            <tr>
                                <th style="width:2%">SL</th>
                                <th>Rank</th>
                                <th>Name</th>
                                <th style="text-align:right;">Team A Amount</th>
                                <th style="text-align:right;">Team B Amount</th>
                                <th style="text-align:right;">Salary A Amount</th>
                                <th style="text-align:center; width:150px;">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($salarySlots as $slot)
                                <tr wire:key="slot-row-{{ $slot->id }}">

                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $slot->rank }}</td>
                                    <td>{{ $slot->name }}</td>

                                    <td style="text-align:right;">{{ $slot->left_amount }}</td>
                                    <td style="text-align:right;">{{ $slot->right_amount }}</td>
                                    <td style="text-align:right;">{{ $slot->salary_amount }}</td>

                                    <td style="text-align:center;width:150px;">
                                        <button   
                                            wire:click="edit({{ $slot->id }})"
                                            class="btn btn-primary btn-sm">
                                            Edit
                                        </button>

                                        <button
                                            wire:click="delete({{ $slot->id }})"
                                            class="btn btn-danger btn-sm"
                                        >
                                            Delete
                                        </button>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {!! Toast::get_toast_message() !!}

</div>
