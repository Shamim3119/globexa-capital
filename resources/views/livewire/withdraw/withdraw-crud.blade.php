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
                                <th style='text-align:center'>Currency</th>
                                <th style='text-align:center'>Slip</th>
                                <th style='text-align:center'>Trx ID</th>
                                <th style='text-align:center'>Account</th>
              
                                <th style='text-align:center'>Send At</th>
                                <th style='text-align:center'>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($withdraws as $withdraw)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $withdraw->withdrawer->id ?? '' }} / {{ $withdraw->withdrawer->name ?? '' }}</td>
                                    <td style='text-align:center'>{{ $withdraw->created_at->format('d M y, h:i A') }}</td>

                                    <td style='text-align:right'> {{ $withdraw->amount ?? '' }}</td>
                                    <td style='text-align:center'>{{ $withdraw->account->operator->currency->name ?? '' }}</td>
                                    <td style='text-align:center'>
                                        @if($withdraw->withdraw_doc)
                                            <img src="{{ asset($withdraw->withdraw_doc) }}"
                                                width="40"
                                                height="40"
                                                style="cursor:pointer;border-radius:5px;object-fit:cover"
                                                data-bs-toggle="modal"
                                                data-bs-target="#slipModal"
                                                onclick="showSlip('{{ asset($withdraw->withdraw_doc) }}')">
                                        @else
                                            -
                                        @endif
                                    </td>
                            

                                    <td style="width:150px; text-align:center; word-break:break-word; white-space:normal;">
                                        {{ $withdraw->trxid ?? '' }}
                                    </td>
                                 
                                    <td style="width:200px; text-align:center; word-break:break-word; white-space:normal;">
                                        {{ $withdraw->account->account_no ?? '' }}
                                    </td>

                                   <td style='text-align:center'>{{ $withdraw->send_at?->format('d M y, h:i A') ?? '-' }}</td>

                                    <td style='text-align:center'>
                                        @php
                                            $status = $withdraw->status->name ?? '';
                                        @endphp

                                        @if($status=='Pending')
                                            <button
                                                class="btn btn-warning btn-sm"
                                                wire:click="openStatusModal({{ $withdraw->id }})">
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

    <div class="modal fade" id="slipModal" tabindex="-1">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Withdraw Slip</h5>

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
                    <h5>Update Withdraw Status</h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body">



                    @if($selectedwithdraw)

                    <div class="table-responsive mb-3">
                        <table class="table table-bordered">

                            <tr>
                                <th width="35%">Deposit By</th>
                                <td>
                                    {{ $selectedwithdraw->withdrawer->id ?? '' }}
                                    /
                                    {{ $selectedwithdraw->withdrawer->name ?? '' }}
                                </td>
                            </tr>

                            <tr>
                                <th>Deposit At</th>
                                <td>
                                    {{ $selectedwithdraw->created_at->format('d M y, h:i A') }}
                                </td>
                            </tr>

                            <tr>
                                <th>Amount</th>
                                <td style="text-align:right">
                                    {{ number_format($selectedwithdraw->amount,2) }}
                                </td>
                            </tr>

                            <tr>
                                <th>Currency</th>
                                <td>
                                    {{ $selectedwithdraw->account->operator->currency->name ?? '' }}
                                </td>
                            </tr>

                        </table>
                    </div>

                    @endif

                    <div class="mb-3">
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

                    <div class="mb-3">

                        <label class="form-label">Current Slip</label><br>

                        @if($selectedwithdraw?->withdraw_doc)
                            <img src="{{ asset($selectedwithdraw->withdraw_doc) }}"
                                width="120"
                                class="img-thumbnail mb-2">
                        @endif

                    </div>

                    <div class="mb-3">

                        <label class="form-label">New Slip</label>

                        <input
                            type="file"
                            class="form-control"
                            wire:model="withdraw_doc">

                        @error('withdraw_doc')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror

                    </div>

                    <div class="mb-3">

                        <label class="form-label">Transaction ID</label>
                        <input
                            type="text"
                            class="form-control"
                            wire:model="trxid">
                    </div>

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