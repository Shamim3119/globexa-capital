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


                        {{-- Deposit ID --}}
                        <div class="col-md-2">

                            <label class="form-label">
                                Deposit ID
                            </label>

                            <input
                                type="number"
                                wire:model.live="depositId"
                                class="form-control"
                                placeholder="Deposit ID"
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
                    {{-- ACCEPT DATE FILTER --}}
                    {{-- ========================================================= --}}

                    <div class="row g-2 mb-3">

                        <div class="col-md-3">

                            <label class="form-label">
                                Accept From
                            </label>

                            <input
                                type="date"
                                wire:model.live="acceptFrom"
                                class="form-control"
                            >

                        </div>


                        <div class="col-md-3">

                            <label class="form-label">
                                Accept To
                            </label>

                            <input
                                type="date"
                                wire:model.live="acceptTo"
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
                                        Total Deposit Amount
                                    </div>

                                    <div class="fs-4 fw-bold">
                                        {{ number_format($totalAmount, 2) }}
                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Total Exchange Amount --}}
                        <div class="col-md-6">

                            <div class="card border">

                                <div class="card-body py-3">

                                    <div class="text-muted small">
                                        Total Exchange Amount
                                    </div>

                                    <div class="fs-4 fw-bold">
                                        {{ number_format($totalExchangeAmount, 2) }}
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
                                        Deposit By
                                    </th>

                                    <th style="text-align:center">
                                        Deposit At
                                    </th>

                                    <th style="text-align:right">
                                        Amount
                                    </th>

                                    <th style="text-align:right">
                                        Exch. Amt.
                                    </th>

                                    <th style="text-align:center">
                                        Currency
                                    </th>

                                    <th style="text-align:center">
                                        Slip
                                    </th>

                                    <th style="text-align:center">
                                        Trx ID
                                    </th>

                                    <th style="text-align:center">
                                        Account
                                    </th>

                                    <th style="text-align:center">
                                        Accept At
                                    </th>

                                    <th style="text-align:center">
                                        Status
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse($deposits as $deposit)

                                    <tr wire:key="deposit-{{ $deposit->id }}">

                                        {{-- SL --}}
                                        <td>
                                            {{ $deposits->firstItem() + $loop->index }}
                                        </td>


                                        {{-- Client --}}
                                        <td>

                                            {{ $deposit->depositer->id ?? '' }}

                                            /

                                            {{ $deposit->depositer->name ?? '' }}

                                        </td>


                                        {{-- Deposit At --}}
                                        <td style="text-align:center">

                                            {{ $deposit->created_at?->format('d M y, h:i A') }}

                                        </td>


                                        {{-- Amount --}}
                                        <td style="text-align:right">

                                            {{ number_format($deposit->amount ?? 0, 2) }}

                                        </td>


                                        {{-- Exchange Amount --}}
                                        <td style="text-align:right">

                                            {{ number_format($deposit->exchange_amount ?? 0, 2) }}

                                        </td>


                                        {{-- Currency --}}
                                        <td style="text-align:center">

                                            {{ $deposit->account->operator->currency->name ?? '' }}

                                        </td>


                                        {{-- Slip --}}
                                        <td style="text-align:center">

                                            @if($deposit->deposit_doc)

                                                <img
                                                    src="{{ asset($deposit->deposit_doc) }}"
                                                    width="40"
                                                    height="40"
                                                    style="
                                                        cursor:pointer;
                                                        border-radius:5px;
                                                        object-fit:cover
                                                    "
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#slipModal"
                                                    onclick="showSlip('{{ asset($deposit->deposit_doc) }}')"
                                                >

                                            @else

                                                -

                                            @endif

                                        </td>


                                        {{-- Trx ID --}}
                                        <td
                                            style="
                                                width:150px;
                                                text-align:center;
                                                word-break:break-word;
                                                white-space:normal;
                                            "
                                        >

                                            {{ $deposit->trxid ?? '' }}

                                        </td>


                                        {{-- Account --}}
                                        <td
                                            style="
                                                width:200px;
                                                text-align:center;
                                                word-break:break-word;
                                                white-space:normal;
                                            "
                                        >

                                            {{ $deposit->account->account_no ?? '' }}

                                        </td>


                                        {{-- Accept At --}}
                                        <td style="text-align:center">

                                            {{ $deposit->accept_at?->format('d M y, h:i A') ?? '-' }}

                                        </td>


                                        {{-- Status --}}
                                        <td style="text-align:center">

                                            @php
                                                $status = $deposit->status->name ?? '';
                                            @endphp


                                            @if($status == 'Pending')

                                                <button
                                                    class="btn btn-warning btn-sm"
                                                    wire:click="openStatusModal({{ $deposit->id }})"
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
                                            colspan="11"
                                            class="text-center py-4"
                                        >
                                            No deposit records found.
                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>


                            {{-- ================================================= --}}
                            {{-- TOTAL --}}
                            {{-- ================================================= --}}

                            <tfoot>

                                <tr class="fw-bold">

                                    <td colspan="3" class="text-end">
                                        TOTAL
                                    </td>

                                    <td class="text-end">
                                        {{ number_format($totalAmount, 2) }}
                                    </td>

                                    <td class="text-end">
                                        {{ number_format($totalExchangeAmount, 2) }}
                                    </td>

                                    <td colspan="6"></td>

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
                            {{ $deposits->firstItem() ?? 0 }}

                            to

                            {{ $deposits->lastItem() ?? 0 }}

                            of

                            {{ $deposits->total() }}

                            deposits

                        </div>


                        <div>

                            {{ $deposits->links() }}

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