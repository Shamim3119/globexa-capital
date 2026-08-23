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

                    {{-- ========================================================= --}}
                    {{-- FILTERS --}}
                    {{-- ========================================================= --}}

                    <div class="row g-2 mb-3">

                        {{-- General Search --}}
                        <div class="col-md-3">

                            <label class="form-label">
                                Search
                            </label>

                            <input
                                type="text"
                                wire:model.live.debounce.400ms="search"
                                class="form-control"
                                placeholder="Client / Phone / TrxID / Account"
                            >

                        </div>


                        {{-- Withdraw ID --}}
                        <div class="col-md-2">

                            <label class="form-label">
                                Withdraw ID
                            </label>

                            <input
                                type="number"
                                wire:model.live="withdrawId"
                                class="form-control"
                                placeholder="Withdraw ID"
                            >

                        </div>


                        {{-- Client ID --}}
                        <div class="col-md-2">

                            <label class="form-label">
                                Client ID
                            </label>

                            <input
                                type="number"
                                wire:model.live="clientId"
                                class="form-control"
                                placeholder="Client ID"
                            >

                        </div>


                        {{-- Created From --}}
                        <div class="col-md-2">

                            <label class="form-label">
                                Created From
                            </label>

                            <input
                                type="date"
                                wire:model.live="createdFrom"
                                class="form-control"
                            >

                        </div>


                        {{-- Created To --}}
                        <div class="col-md-2">

                            <label class="form-label">
                                Created To
                            </label>

                            <input
                                type="date"
                                wire:model.live="createdTo"
                                class="form-control"
                            >

                        </div>


                        {{-- Clear --}}
                        <div class="col-md-1 d-flex align-items-end">

                            <button
                                type="button"
                                wire:click="clearFilters"
                                class="btn btn-secondary w-100"
                                title="Clear Filters"
                            >
                                <i class="bi bi-x-lg"></i>
                            </button>

                        </div>

                    </div>


                    {{-- ========================================================= --}}
                    {{-- SEND DATE FILTER --}}
                    {{-- ========================================================= --}}

                    <div class="row g-2 mb-3">

                        <div class="col-md-3">

                            <label class="form-label">
                                Send From
                            </label>

                            <input
                                type="date"
                                wire:model.live="sendFrom"
                                class="form-control"
                            >

                        </div>


                        <div class="col-md-3">

                            <label class="form-label">
                                Send To
                            </label>

                            <input
                                type="date"
                                wire:model.live="sendTo"
                                class="form-control"
                            >

                        </div>

                    </div>


                    {{-- ========================================================= --}}
                    {{-- SUMMARY --}}
                    {{-- ========================================================= --}}

                    <div class="row g-3 mb-3">

                        {{-- Total Amount --}}
                        <div class="col-md-6">

                            <div class="card border">

                                <div class="card-body py-3">

                                    <div class="text-muted small">
                                        Total Withdraw Amount
                                    </div>

                                    <div class="fs-4 fw-bold">
                                        {{ number_format($totalAmount, 2) }}
                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Total Send Amount --}}
                        <div class="col-md-6">

                            <div class="card border">

                                <div class="card-body py-3">

                                    <div class="text-muted small">
                                        Total Send Amount
                                    </div>

                                    <div class="fs-4 fw-bold">
                                        {{ number_format($totalSendAmount, 2) }}
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- ========================================================= --}}
                    {{-- TABLE --}}
                    {{-- ========================================================= --}}

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover align-middle">

                            <thead>

                                <tr>

                                    <th style="width:2%">
                                        SL
                                    </th>

                                    <th>
                                        Withdraw By
                                    </th>

                                    <th style="text-align:center">
                                        Withdraw At
                                    </th>

                                    <th style="text-align:center">
                                        Slip
                                    </th>

                                    <th>
                                        TrxID
                                    </th>

                                    <th>
                                        Account Info
                                    </th>

                                    <th style="text-align:center">
                                        Send At
                                    </th>

                                    <th style="text-align:right">
                                        Amount
                                    </th>

                                    <th style="text-align:center">
                                        Currency
                                    </th>

                                    <th style="text-align:right">
                                        Rate
                                    </th>

                                    <th style="text-align:right">
                                        Send Amt.
                                    </th>

                                    <th style="text-align:center">
                                        Status
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse($withdraws as $withdraw)

                                    <tr wire:key="withdraw-{{ $withdraw->id }}">

                                        {{-- SL --}}
                                        <td>
                                            {{ $withdraws->firstItem() + $loop->index }}
                                        </td>


                                        {{-- Client --}}
                                        <td>

                                            {{ $withdraw->withdrawer->id ?? '' }}

                                            /

                                            {{ $withdraw->withdrawer->name ?? '' }}

                                        </td>


                                        {{-- Created --}}
                                        <td style="text-align:center">

                                            {{ $withdraw->created_at?->format('d M y, h:i A') }}

                                        </td>


                                        {{-- Slip --}}
                                        <td style="text-align:center">

                                            @if($withdraw->withdraw_doc)

                                                <img
                                                    src="{{ asset($withdraw->withdraw_doc) }}"
                                                    width="40"
                                                    height="40"
                                                    style="
                                                        cursor:pointer;
                                                        border-radius:5px;
                                                        object-fit:cover
                                                    "
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#slipModal"
                                                    onclick="showSlip('{{ asset($withdraw->withdraw_doc) }}')"
                                                >

                                            @else

                                                -

                                            @endif

                                        </td>


                                        {{-- Trx ID --}}
                                        <td
                                            style="
                                                width:150px;
                                                text-align:left;
                                                word-break:break-word;
                                                white-space:normal;
                                            "
                                        >

                                            {{ $withdraw->trxid ?? '' }}

                                        </td>


                                        {{-- Account --}}
                                        <td
                                            style="
                                                width:200px;
                                                text-align:left;
                                                word-break:break-word;
                                                white-space:normal;
                                            "
                                        >

                                            {{ $withdraw->account->account_no ?? '' }}

                                            /

                                            {{ $withdraw->account->operator->name ?? '' }}

                                        </td>


                                        {{-- Send At --}}
                                        <td style="text-align:center">

                                            {{ $withdraw->send_at?->format('d M y, h:i A') ?? '-' }}

                                        </td>


                                        {{-- Amount --}}
                                        <td style="text-align:right">

                                            {{ number_format($withdraw->amount ?? 0, 2) }}

                                        </td>


                                        {{-- Currency --}}
                                        <td style="text-align:center">

                                            {{ $withdraw->account->operator->currency->name ?? '' }}

                                        </td>


                                        {{-- Rate --}}
                                        <td style="text-align:right">

                                            {{ number_format($withdraw->rate ?? 0, 2) }}

                                        </td>


                                        {{-- Send Amount --}}
                                        <td style="text-align:right">

                                            {{ number_format($withdraw->send_amount ?? 0, 2) }}

                                        </td>


                                        {{-- Status --}}
                                        <td style="text-align:center">

                                            @php
                                                $status = $withdraw->status->name ?? '';
                                            @endphp


                                            @if($status == 'Pending')

                                                <button
                                                    class="btn btn-warning btn-sm"
                                                    wire:click="openStatusModal({{ $withdraw->id }})"
                                                >
                                                    Pending
                                                </button>


                                            @elseif($status == 'Success')

                                                <span class="btn btn-success btn-sm">
                                                    Success
                                                </span>


                                            @elseif($status == 'Cancelled')

                                                <span class="btn btn-danger btn-sm">
                                                    Cancelled
                                                </span>


                                            @else

                                                <span class="badge bg-secondary">
                                                    {{ $status ?: 'Unknown' }}
                                                </span>

                                            @endif

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="12"
                                            class="text-center py-4"
                                        >
                                            No withdraw records found.
                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>


                            {{-- ================================================= --}}
                            {{-- TOTAL --}}
                            {{-- ================================================= --}}

                            <tfoot>

                                <tr class="fw-bold">

                                    <td colspan="7" class="text-end">
                                        TOTAL
                                    </td>

                                    <td class="text-end">
                                        {{ number_format($totalAmount, 2) }}
                                    </td>

                                    <td></td>

                                    <td></td>

                                    <td class="text-end">
                                        {{ number_format($totalSendAmount, 2) }}
                                    </td>

                                    <td></td>

                                </tr>

                            </tfoot>

                        </table>

                    </div>


                    {{-- ========================================================= --}}
                    {{-- PAGINATION --}}
                    {{-- ========================================================= --}}

                    <div class="d-flex justify-content-between align-items-center mt-3">

                        <div class="text-muted">

                            Showing
                            {{ $withdraws->firstItem() ?? 0 }}

                            to

                            {{ $withdraws->lastItem() ?? 0 }}

                            of

                            {{ $withdraws->total() }}

                            withdraws

                        </div>


                        <div>

                            {{ $withdraws->links() }}

                        </div>

                    </div>

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