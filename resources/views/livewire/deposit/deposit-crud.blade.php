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
                                <th>Deposit By</th>
                                <th style='text-align:center'>Deposit At</th>
                                <th style='text-align:right'>Amount</th>
                                <th style='text-align:right'>Exch. Amt.</th>
                                <th style='text-align:center'>Currency</th>
                                <th style='text-align:center'>Slip</th>
                                <th style='text-align:center'>Account</th>
              
                                <th style='text-align:center'>Accept At</th>
                                <th style='text-align:center'>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($deposits as $deposit)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $deposit->depositer->id ?? '' }} / {{ $deposit->depositer->name ?? '' }}</td>
                                    <td style='text-align:center'>{{ $deposit->created_at->format('d M y, h:i A') }}</td>

                                    <td style='text-align:right'> {{ $deposit->amount ?? '' }}</td>
                                    <td style='text-align:right'> {{ $deposit->exchange_amount ?? '' }}</td>
                                    <td style='text-align:center'>{{ $deposit->account->operator->currency->name ?? '' }}</td>
                                    <td style='text-align:center'>
                                        @if($deposit->deposit_doc)
                                            <img src="{{ asset($deposit->deposit_doc) }}"
                                                width="40"
                                                height="40"
                                                style="cursor:pointer;border-radius:5px;object-fit:cover"
                                                data-bs-toggle="modal"
                                                data-bs-target="#slipModal"
                                                onclick="showSlip('{{ asset($deposit->deposit_doc) }}')">
                                        @else
                                            -
                                        @endif
                                    </td>
                            

                                  
                                 
                                    <td style='text-align:center'> {{ $deposit->account->account_no ?? '' }}</td>
                                    

                                   <td style='text-align:center'>{{ $deposit->accept_at?->format('d M y, h:i A') ?? '-' }}</td>

                                    <td style='text-align:center'>
                                        @php
                                            $status = $deposit->status->name ?? '';
                                        @endphp

                                        @if($status=='Pending')
                                            <button
                                                class="btn btn-warning btn-sm"
                                                wire:click="openStatusModal({{ $deposit->id }})">
                                                Pending
                                            </button>

                                        @elseif($status=='Accept')
                                            <span class="btn btn-success btn-sm">
                                                Accept
                                            </span>

                                        @elseif($status=='Reject')
                                            <span class="btn btn-danger btn-sm">
                                                Reject
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

    <div class="modal fade" id="slipModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Deposit Slip</h5>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body text-center">

                    <img id="slipImage"
                        src=""
                        class="img-fluid rounded">

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
                    <h5>Update Deposit Status</h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body">



                    @if($selectedDeposit)

                    <div class="table-responsive mb-3">
                        <table class="table table-bordered">

                            <tr>
                                <th width="35%">Deposit By</th>
                                <td>
                                    {{ $selectedDeposit->depositer->id ?? '' }}
                                    /
                                    {{ $selectedDeposit->depositer->name ?? '' }}
                                </td>
                            </tr>

                            <tr>
                                <th>Deposit At</th>
                                <td>
                                    {{ $selectedDeposit->created_at->format('d M y, h:i A') }}
                                </td>
                            </tr>

                            <tr>
                                <th>Amount</th>
                                <td style="text-align:right">
                                    {{ number_format($selectedDeposit->amount,2) }}
                                </td>
                            </tr>

                            <tr>
                                <th>Currency</th>
                                <td>
                                    {{ $selectedDeposit->account->operator->currency->name ?? '' }}
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
                            Accept
                        </option>

                        <option value="3">
                            Reject
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