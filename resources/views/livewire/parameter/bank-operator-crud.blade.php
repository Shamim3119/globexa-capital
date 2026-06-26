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
         
            @include('livewire.parameter.bank-operator-form')
 

            <div @if($updateMode) style="display:none;" @endif id='boxView' class="card card-primary card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">{{ ucfirst($activeTab) }} List</div>
                </div>
                <div class="card-body">

                    <table class="table table-bordered mt-3">

                        <thead>
                            <tr>
                                <th style="width:2%">SL</th>
                                <th>Name</th>
                                <th>Currency</th>
                                <th>Type</th>
                 
                                <th style="width:15%;text-align:center;">Status</th>
                                <th style="text-align:center; width:100px;">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($bank_operators as $bank_operator)
                                <tr wire:key="bank-operator-row-{{ $bank_operator->id }}"
                                    class="{{ $bank_operator->inactive ? 'table-danger' : '' }}"
                                >

                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $bank_operator->name }}</td>
                                    <td>{{ $bank_operator->currency ? $bank_operator->currency->name : 'N/A' }}</td>
                                    <td>{{ $bank_operator->bank_type ? $bank_operator->bank_type->name : 'N/A' }}</td>
                                    
                                    <td class="{{ $bank_operator->inactive ? 'text-danger' : '' }}" style="text-align:center">{{ $bank_operator->inactive == 0 ? 'Active' : 'Inactive' }}</td>

                                    <td style="text-align:center;width:150px;">
                                        <button   
                                            wire:click="edit({{ $bank_operator->id }})"
                                            class="btn btn-primary btn-sm">
                                             <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <button
                                            wire:click="delete({{ $bank_operator->id }})"
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
