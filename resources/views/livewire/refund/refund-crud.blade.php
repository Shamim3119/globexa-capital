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
                                placeholder="Client Name / Phone"
                            >

                        </div>


                        {{-- Refund ID --}}
                        <div class="col-md-2">

                            <label class="form-label">
                                Refund ID
                            </label>

                            <input
                                type="number"
                                wire:model.live="refundId"
                                class="form-control"
                                placeholder="Refund ID"
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


                        {{-- Investment ID --}}
                        <div class="col-md-2">

                            <label class="form-label">
                                Investment ID
                            </label>

                            <input
                                type="number"
                                wire:model.live="investmentId"
                                class="form-control"
                                placeholder="Investment ID"
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
                    {{-- CREATED DATE --}}
                    {{-- ========================================================= --}}

                    <div class="row g-2 mb-3">

                        <div class="col-md-3">

                            <label class="form-label">
                                Created From
                            </label>

                            <input
                                type="date"
                                wire:model.live="createdFrom"
                                class="form-control"
                            >

                        </div>


                        <div class="col-md-3">

                            <label class="form-label">
                                Created To
                            </label>

                            <input
                                type="date"
                                wire:model.live="createdTo"
                                class="form-control"
                            >

                        </div>


                        <div class="col-md-3">

                            <label class="form-label">
                                Refund From
                            </label>

                            <input
                                type="date"
                                wire:model.live="acceptFrom"
                                class="form-control"
                            >

                        </div>


                        <div class="col-md-3">

                            <label class="form-label">
                                Refund To
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

                        {{-- Amount --}}
                        <div class="col-md-3">

                            <div class="card border">

                                <div class="card-body py-3">

                                    <div class="text-muted small">
                                        Total Amount
                                    </div>

                                    <div class="fs-4 fw-bold">
                                        {{ number_format($totalAmount, 2) }}
                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Charge --}}
                        <div class="col-md-3">

                            <div class="card border">

                                <div class="card-body py-3">

                                    <div class="text-muted small">
                                        Total Charge
                                    </div>

                                    <div class="fs-4 fw-bold">
                                        {{ number_format($totalCharge, 2) }}
                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Deduct --}}
                        <div class="col-md-3">

                            <div class="card border">

                                <div class="card-body py-3">

                                    <div class="text-muted small">
                                        Total Deduct
                                    </div>

                                    <div class="fs-4 fw-bold">
                                        {{ number_format($totalDeduct, 2) }}
                                    </div>

                                </div>

                            </div>

                        </div>


                        {{-- Return --}}
                        <div class="col-md-3">

                            <div class="card border">

                                <div class="card-body py-3">

                                    <div class="text-muted small">
                                        Total Return
                                    </div>

                                    <div class="fs-4 fw-bold">
                                        {{ number_format($totalReturn, 2) }}
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
                                        Apply By
                                    </th>

                                    <th style="text-align:center">
                                        Apply At
                                    </th>

                                    <th style="text-align:center">
                                        Charge
                                    </th>

                                    <th style="text-align:center">
                                        Pass Day
                                    </th>

                                    <th style="text-align:right">
                                        Amount
                                    </th>

                                    <th style="text-align:right">
                                        Deduct
                                    </th>

                                    <th style="text-align:right">
                                        Return
                                    </th>

                                    <th style="text-align:center">
                                        Refund At
                                    </th>

                                    <th style="text-align:center">
                                        Status
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse($refunds as $refund)

                                    <tr wire:key="refund-{{ $refund->id }}">

                                        {{-- SL --}}
                                        <td>
                                            {{ $refunds->firstItem() + $loop->index }}
                                        </td>


                                        {{-- Client --}}
                                        <td>

                                            {{ $refund->member->id ?? '' }}

                                            /

                                            {{ $refund->member->name ?? '' }}

                                        </td>


                                        {{-- Apply At --}}
                                        <td style="text-align:center">

                                            {{ $refund->created_at?->format('d M y, h:i A') }}

                                        </td>


                                        {{-- Charge --}}
                                        <td style="text-align:center">

                                            {{ number_format($refund->charge ?? 0, 2) }}

                                        </td>


                                        {{-- Pass Day --}}
                                        <td style="text-align:center">

                                            {{ $refund->pass_day ?? 0 }}

                                        </td>


                                        {{-- Amount --}}
                                        <td style="text-align:right">

                                            {{ number_format($refund->amount ?? 0, 2) }}

                                        </td>


                                        {{-- Deduct --}}
                                        <td style="text-align:right">

                                            {{ number_format($refund->deduct ?? 0, 2) }}

                                        </td>


                                        {{-- Return --}}
                                        <td style="text-align:right">

                                            {{ number_format($refund->return_amount ?? 0, 2) }}

                                        </td>


                                        {{-- Refund At --}}
                                        <td style="text-align:center">

                                            {{ $refund->accept_at?->format('d M y, h:i A') ?? '-' }}

                                        </td>


                                        {{-- Status --}}
                                        <td style="text-align:center">

                                            @php
                                                $status = $refund->status->name ?? '';
                                            @endphp


                                            @if($status == 'Pending')

                                                <button
                                                    class="btn btn-warning btn-sm"
                                                    wire:click="openStatusModal({{ $refund->id }})"
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
                                            colspan="10"
                                            class="text-center py-4"
                                        >
                                            No refund records found.
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

                                    <td class="text-center">
                                        {{ number_format($totalCharge, 2) }}
                                    </td>

                                    <td></td>

                                    <td class="text-end">
                                        {{ number_format($totalAmount, 2) }}
                                    </td>

                                    <td class="text-end">
                                        {{ number_format($totalDeduct, 2) }}
                                    </td>

                                    <td class="text-end">
                                        {{ number_format($totalReturn, 2) }}
                                    </td>

                                    <td colspan="2"></td>

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
                            {{ $refunds->firstItem() ?? 0 }}

                            to

                            {{ $refunds->lastItem() ?? 0 }}

                            of

                            {{ $refunds->total() }}

                            refunds

                        </div>


                        <div>

                            {{ $refunds->links() }}

                        </div>

                    </div>

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