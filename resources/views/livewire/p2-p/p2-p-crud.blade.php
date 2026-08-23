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
                        <div class="col-md-3">

                            <label class="form-label">
                                Search
                            </label>

                            <input
                                type="text"
                                wire:model.live.debounce.400ms="search"
                                class="form-control"
                                placeholder="Sender / Receiver / Phone"
                            >

                        </div>


                        {{-- P2P ID --}}
                        <div class="col-md-2">

                            <label class="form-label">
                                P2P ID
                            </label>

                            <input
                                type="number"
                                wire:model.live="p2pId"
                                class="form-control"
                                placeholder="P2P ID"
                            >

                        </div>


                        {{-- Sender ID --}}
                        <div class="col-md-2">

                            <label class="form-label">
                                Sender ID
                            </label>

                            <input
                                type="number"
                                wire:model.live="senderId"
                                class="form-control"
                                placeholder="Sender ID"
                            >

                        </div>


                        {{-- Receiver ID --}}
                        <div class="col-md-2">

                            <label class="form-label">
                                Receiver ID
                            </label>

                            <input
                                type="number"
                                wire:model.live="receiverId"
                                class="form-control"
                                placeholder="Receiver ID"
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


                    {{-- ================================================= --}}
                    {{-- DATE FILTER --}}
                    {{-- ================================================= --}}

                    <div class="row g-2 mb-3">

                        <div class="col-md-3">

                            <label class="form-label">
                                P2P From
                            </label>

                            <input
                                type="date"
                                wire:model.live="createdFrom"
                                class="form-control"
                            >

                        </div>


                        <div class="col-md-3">

                            <label class="form-label">
                                P2P To
                            </label>

                            <input
                                type="date"
                                wire:model.live="createdTo"
                                class="form-control"
                            >

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- SUMMARY --}}
                    {{-- ================================================= --}}

                    <div class="row g-3 mb-3">

                        <div class="col-md-3">

                            <div class="card border">

                                <div class="card-body py-3">

                                    <div class="text-muted small">
                                        Total P2P Amount
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

                                    <th style="text-align:center">
                                        P2P At
                                    </th>

                                    <th style="text-align:left">
                                        From
                                    </th>

                                    <th style="text-align:left">
                                        To
                                    </th>

                                    <th style="text-align:right">
                                        Amount
                                    </th>

                                    <th style="text-align:center">
                                        Status
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse($p2ps as $p2p)

                                    <tr wire:key="p2p-{{ $p2p->id }}">

                                        {{-- SL --}}
                                        <td>
                                            {{ $p2ps->firstItem() + $loop->index }}
                                        </td>


                                        {{-- P2P At --}}
                                        <td style="text-align:center">

                                            {{ $p2p->created_at?->format('d M y, h:i A') }}

                                        </td>


                                        {{-- Sender --}}
                                        <td>

                                            {{ $p2p->sender->id ?? '' }}

                                            /

                                            {{ $p2p->sender->name ?? '' }}

                                        </td>


                                        {{-- Receiver --}}
                                        <td>

                                            {{ $p2p->receiver->id ?? '' }}

                                            /

                                            {{ $p2p->receiver->name ?? '' }}

                                        </td>


                                        {{-- Amount --}}
                                        <td style="text-align:right">

                                            {{ number_format($p2p->amount ?? 0, 2) }}

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
                                            colspan="6"
                                            class="text-center py-4"
                                        >
                                            No P2P records found.
                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>


                            {{-- ================================================= --}}
                            {{-- TOTAL --}}
                            {{-- ================================================= --}}

                            <tfoot>

                                <tr class="fw-bold">

                                    <td
                                        colspan="4"
                                        class="text-end"
                                    >
                                        TOTAL
                                    </td>

                                    <td style="text-align:right">

                                        {{ number_format($totalAmount, 2) }}

                                    </td>

                                    <td></td>

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

                            {{ $p2ps->firstItem() ?? 0 }}

                            to

                            {{ $p2ps->lastItem() ?? 0 }}

                            of

                            {{ $p2ps->total() }}

                            P2P records

                        </div>


                        <div>

                            {{ $p2ps->links() }}

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>