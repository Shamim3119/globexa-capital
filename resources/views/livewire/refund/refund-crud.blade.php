@php
    use App\Helpers\Toast;
@endphp


<div>
    <br>
    <div class='row'>
        <div class='col-12 col-md-12 col-lg-12'>


            <div class="card card-primary card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">{{ ucfirst($activeTab) }} List</div>
                </div>
                <div class="card-body">

                    <table class="table table-bordered mt-3">

                        <thead>
                            <tr>
                                <th style="width:2%">SL</th>
                     
                                <th>Apply By</th>
                                <th style='text-align:center'>Apply At</th>
                                <th style='text-align:center'>Charge</th>
                                <th style='text-align:center'>Pass Day</th>
                                <th style='text-align:right'>Amount</th>
                                <th style='text-align:right'>Deduct</th>
                                <th style='text-align:right'>Return</th>
                                <th style='text-align:center'>Refund At</th>
                                <th style='text-align:center'>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($refunds as $refund)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $refund->member->id ?? '' }} / {{ $refund->member->name ?? '' }}</td>
                                    <td style='text-align:center'>{{ $refund->created_at->format('d M y, h:i A') }}</td>

                                    <td style='text-align:center'>
                                        {{ $refund->charge ?? '' }}
                                    </td>
                                     <td style='text-align:center'>
                                        {{ $refund->pass_day ?? '' }}
                                    </td>
                                    <td style='text-align:right'> {{ $refund->amount ?? '' }}</td>
                                    <td style='text-align:right'> {{ $refund->deduct ?? '' }}</td>
                                    <td style='text-align:right'>{{ $refund->return_amount ?? '' }}</td>
          
                       
 
                                 


                                   <td style='text-align:center'>{{ $refund->accept_at?->format('d M y, h:i A') ?? '-' }}</td>

                                    <td style='text-align:center'>
                                        @php
                                            $status = $refund->status->name ?? '';
                                        @endphp

                                        @if($status=='Pending')
                                            <button
                                                class="btn btn-warning btn-sm"
                                                wire:click="openStatusModal({{ $refund->id }})">
                                                Pending
                                            </button>

                                        @elseif($status=='Success')
                                            <span class="btn btn-success btn-sm">
                                                Success
                                            </span>

                                        @elseif($status=='Cancelled')
                                            <span class="btn btn-danger btn-sm">
                                                Cancelled
                                            </span>

                                        @endif
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

 
    <div class="modal fade"
        id="statusModal"
        tabindex="-1"
        wire:ignore.self>

        <div class="modal-dialog">

            <div class="modal-content">

                <div class="modal-header">
                    <h5>Update Refund Status</h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body">



                    @if($selectedRefund)

                    <div class="table-responsive mb-3">
                        <table class="table table-bordered">

                            <tr>
                                <th width="35%">Refund By</th>
                                <td>
                                    {{ $selectedRefund->member->id ?? '' }}
                                    /
                                    {{ $selectedRefund->member->name ?? '' }}
                                </td>
                            </tr>

                            <tr>
                                <th>Refund At</th>
                                <td>
                                    {{ $selectedRefund->created_at->format('d M y, h:i A') }}
                                </td>
                            </tr>
                            <tr>
                                <th>Charge</th>
                                <td style="text-align:left">
                                    {{ number_format($selectedRefund->charge,2) }}
                                </td>
                            </tr>
                            <tr>
                                <th>Pass Day</th>
                                <td style="text-align:left">
                                    {{ number_format($selectedRefund->pass_day) }}
                                </td>
                            </tr>
                            
            
                              
        
                            <tr>
                                <th>Amount</th>
                                <td style="text-align:left">
                                    {{ number_format($selectedRefund->amount,2) }}
                                </td>
                            </tr>

                            <tr>
                                <th>Deduct</th>
                                <td style="text-align:left">
                                    {{ number_format($selectedRefund->deduct,2) }}
                                </td>
                            </tr>
                            
                            <tr>
                                <th>Return</th>
                                <td style="text-align:left">
                                    {{ number_format($selectedRefund->return_amount,2) }}
                                </td>
                            </tr>

                        </table>
                    </div>

                    @endif


                    <select
                        class="form-select"
                        wire:model="selectedStatus">

                        <option value="">Select Status</option>

                        <option value="2">
                            Success
                        </option>
 

                    </select>

                </div>

                <div class="modal-footer">

                    <button
                        class="btn btn-primary"
                        wire:click="updateStatus">
                        Save
                    </button>

                </div>

            </div>

        </div>

    </div>

    {!! Toast::get_toast_message() !!}

    <script>
        function showSlip(image){
            document.getElementById('slipImage').src = image;
        }
    </script>

    <script>
        document.addEventListener('livewire:init', () => {

            Livewire.on('openStatusModal', () => {
                new bootstrap.Modal(document.getElementById('statusModal')).show();
            });

            Livewire.on('closeStatusModal', () => {
                bootstrap.Modal.getInstance(document.getElementById('statusModal')).hide();
            });

        });
    </script>


</div>