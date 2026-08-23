<div>
    <br>

    <div class="row">

        <div class="col-12">

            <div class="card card-primary card-outline mb-4">

                {{-- ================================================= --}}
                {{-- HEADER --}}
                {{-- ================================================= --}}

                <div class="card-header">

                    <div class="card-title">
                        {{ ucfirst($activeTab) }} List
                    </div>

                </div>


                <div class="card-body">

                    {{-- ================================================= --}}
                    {{-- FILTERS --}}
                    {{-- ================================================= --}}

                    <div class="row g-2 mb-3">

                        {{-- General Search --}}
                        <div class="col-md-4">

                            <label class="form-label">
                                Search
                            </label>

                            <input
                                type="text"
                                wire:model.live.debounce.400ms="search"
                                class="form-control"
                                placeholder="Client Name / Phone"
                            >

                        </div>


                        {{-- Transfer ID --}}
                        <div class="col-md-2">

                            <label class="form-label">
                                Transfer ID
                            </label>

                            <input
                                type="number"
                                wire:model.live="transferId"
                                class="form-control"
                                placeholder="Transfer ID"
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

                    </div>


                    {{-- ================================================= --}}
                    {{-- CLEAR FILTER --}}
                    {{-- ================================================= --}}

                    <div class="mb-3">

                        <button
                            type="button"
                            wire:click="clearFilters"
                            class="btn btn-secondary"
                        >
                            <i class="bi bi-x-lg"></i>
                            Clear Filters
                        </button>

                    </div>


                    {{-- ================================================= --}}
                    {{-- SUMMARY --}}
                    {{-- ================================================= --}}

                    <div class="row mb-3">

                        <div class="col-md-4">

                            <div class="card border">

                                <div class="card-body py-3">

                                    <div class="text-muted small">
                                        Total Transfer Amount
                                    </div>

                                    <div class="fs-4 fw-bold">
                                        {{ number_format($totalAmount, 2) }}
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- TABLE --}}
                    {{-- ================================================= --}}

                    <div class="table-responsive">

                        <table class="table table-bordered table-hover align-middle">

                            <thead>

                                <tr>

                                    <th style="width:2%">
                                        SL
                                    </th>

                                    <th>
                                        Transfer By
                                    </th>

                                    <th style="text-align:center">
                                        Transfer At
                                    </th>

                                    <th style="text-align:right">
                                        Amount
                                    </th>

                                    <th style="text-align:right">
                                        Before Income
                                    </th>

                                    <th style="text-align:right">
                                        After Income
                                    </th>

                                    <th style="text-align:right">
                                        Before Deposit
                                    </th>

                                    <th style="text-align:right">
                                        After Deposit
                                    </th>

                                    <th style="text-align:center">
                                        Status
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse($transfers as $transfer)

                                    <tr wire:key="transfer-{{ $transfer->id }}">

                                        {{-- SL --}}
                                        <td>
                                            {{ $transfers->firstItem() + $loop->index }}
                                        </td>


                                        {{-- Client --}}
                                        <td>

                                            {{ $transfer->member->id ?? '' }}

                                            /

                                            {{ $transfer->member->name ?? '' }}

                                        </td>


                                        {{-- Transfer At --}}
                                        <td style="text-align:center">

                                            {{ $transfer->created_at?->format('d M y, h:i A') }}

                                        </td>


                                        {{-- Amount --}}
                                        <td style="text-align:right">

                                            {{ number_format($transfer->amount ?? 0, 2) }}

                                        </td>


                                        {{-- Before Income --}}
                                        <td style="text-align:right">

                                            {{ number_format($transfer->bofore_incom ?? 0, 2) }}

                                        </td>


                                        {{-- After Income --}}
                                        <td style="text-align:right">

                                            {{ number_format($transfer->after_incom ?? 0, 2) }}

                                        </td>


                                        {{-- Before Deposit --}}
                                        <td style="text-align:right">

                                            {{ number_format($transfer->before_deposit ?? 0, 2) }}

                                        </td>


                                        {{-- After Deposit --}}
                                        <td style="text-align:right">

                                            {{ number_format($transfer->after_deposit ?? 0, 2) }}

                                        </td>


                                        {{-- Status --}}
                                        <td style="text-align:center">

                                            <span class="btn btn-success btn-sm">
                                                Success
                                            </span>

                                        </td>

                                    </tr>

                                @empty

                                    <tr>

                                        <td
                                            colspan="9"
                                            class="text-center py-4"
                                        >
                                            No transfer records found.
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

                                    <td colspan="5"></td>

                                </tr>

                            </tfoot>

                        </table>

                    </div>


                    {{-- ================================================= --}}
                    {{-- PAGINATION --}}
                    {{-- ================================================= --}}

                    <div class="d-flex justify-content-between align-items-center mt-3">

                        <div class="text-muted">

                            Showing
                            {{ $transfers->firstItem() ?? 0 }}

                            to

                            {{ $transfers->lastItem() ?? 0 }}

                            of

                            {{ $transfers->total() }}

                            transfers

                        </div>


                        <div>

                            {{ $transfers->links() }}

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>