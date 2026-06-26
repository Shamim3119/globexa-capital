@php
    use App\Helpers\Toast;
@endphp


<div>
    @include('livewire.settings.tab-menu')
 
    <div class='row'>
        <div class='col-12 col-md-6'>
            @include('livewire.settings.business-form')
        </div>
 
        <div class='col-12'>

            <div @if($updateMode) style="display:none;" @endif id='boxView' class="card card-primary card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">{{ ucfirst($activeTab) }} List</div>
                </div>
                <div class="card-body">

                    <table class="table table-bordered mt-3">

                        <thead>
                            <tr>
                                <th style="width:2%">SL</th>
                                <th>Code</th>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Website</th>
                                <th style='text-align:center; width:100px;'>Account</th>
                 
                                <th style="text-align:center; width:50px;">Action</th>
                            </tr>
                        </thead>
                            <tbody>
                                @if($business)
                                    <tr wire:key="busines-row-{{ $business->id }}">

                                        <td>1</td>
                                        <td>{{ $business->code }}</td>
                                        <td>{{ $business->name }}</td>
                                        <td>{{ $business->address }}</td>
                                        <td>{{ $business->email }}</td>
                                        <td>{{ $business->phone }}</td>
                                        <td>{{ $business->web }}</td>
                                        <td style='text-align:center;'>
                                            <button 
                                            wire:click="$dispatch('setRefId', { id: {{ $business->id }}, type: 2, code: '{{ $business->code }}' })"
                                            data-bs-toggle="modal"
                                            data-bs-target="#ModalAccount"
                                            class="btn btn-sm btn-{{ $business->account_count == 0 ? 'danger' : 'success' }}"> 
                                            <i class="bi bi-cash-stack"></i>
                                            </button>
                                        </td>
                                        <td style="text-align:center;width:50px;">
                                            <button
                                                wire:click="edit({{ $business->id }})"
                                                class="btn btn-primary btn-sm">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <script>

        document.addEventListener('livewire:init', () => {
            // Account modal
            Livewire.on('close-account-modal', () => {
                let modal = bootstrap.Modal.getInstance(document.getElementById('ModalAccount'));
                if (modal) modal.hide();
                cleanupModal();
            });

            function cleanupModal() {
                setTimeout(() => {
                    document.querySelectorAll('.modal-backdrop').forEach(el => el.remove());
                    document.body.classList.remove('modal-open');
                    document.body.style.removeProperty('padding-right');
                }, 300);
            }
        });

    </script>

    @include('livewire.settings.business-modal')

    {!! Toast::get_toast_message() !!}


</div>