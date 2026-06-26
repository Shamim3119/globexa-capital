@php
    use App\Helpers\Toast;
@endphp

<div>
    @include('livewire.tab-menu.parameters')

    <div class='row'>
        <div class='col-12 col-md-6'>


            <button 
                wire:click="create"
                class="mb-3 btn btn-sm btn-success"
                @if($updateMode) style="display:none;" @endif
            >
            <i class="bi bi-plus-square"></i>  New {{ ucfirst($activeTab) }}
            </button>
         
            @include('livewire.parameter.wallet-type-form')
 

            <div @if($updateMode) style="display:none;" @endif id='boxView' class="card card-primary card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">{{ ucfirst($activeTab) }} List</div>
                </div>
                <div class="card-body">

                    <table class="table table-bordered mt-3">

                        <thead>
                            <tr>
                                <th style="width:2%">SL</th>
                                <th>Transfer Type</th>
                                
                                <th>Currency</th>
                                <th>Operator</th>
                 
                                <th style="width:15%;text-align:center;">Status</th>
                                <th style="text-align:center; width:100px;">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($wallet_types as $wallet_types)
                                <tr wire:key="bank-operator-row-{{ $wallet_types->id }}"
                                    class="{{ $wallet_types->inactive ? 'table-danger' : '' }}"
                                >

                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $wallet_types->name }}</td>

                                    <td>{{ $wallet_types->bank_operator?->currency?->name ?? 'N/A' }}</td>
                                    <td>{{ $wallet_types->bank_operator ? $wallet_types->bank_operator->name : 'N/A' }}</td>
                                    
                                    <td class="{{ $wallet_types->inactive ? 'text-danger' : '' }}" style="text-align:center">{{ $wallet_types->inactive == 0 ? 'Active' : 'Inactive' }}</td>

                                    <td style="text-align:center;width:150px;">
                                        <button   
                                            wire:click="edit({{ $wallet_types->id }})"
                                            class="btn btn-primary btn-sm">
                                             <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <button
                                            wire:click="delete({{ $wallet_types->id }})"
                                            class="btn btn-danger btn-sm"
                                            >
                                            <i class="bi bi-trash-fill"></i>
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
