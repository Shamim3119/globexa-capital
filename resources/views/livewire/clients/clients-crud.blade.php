@php
    use App\Helpers\Toast;
@endphp


<div>
    <br>
    <div class='row'>
        <div class='col-12 col-md-12 col-lg-12'>

            @include('livewire.clients.clients-form')

            <div @if($updateMode) style="display:none;" @endif
                id="boxView"
                class="card card-primary card-outline mb-4">

                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="card-title">
                            {{ ucfirst($activeTab) }} List
                        </div>

                        <div>
                            <strong>
                                Total: {{ $clients->total() }}
                            </strong>
                        </div>
                    </div>
                </div>

                <div class="card-body">

                    {{-- Filters --}}
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
                                placeholder="Name / Phone / Email"
                            >
                        </div>

                        {{-- Client ID --}}
                        <div class="col-md-2">
                            <label class="form-label">
                                Client ID
                            </label>

                            <input
                                type="number"
                                wire:model.live="searchId"
                                class="form-control"
                                placeholder="Client ID"
                            >
                        </div>

                        {{-- Parent ID --}}
                        <div class="col-md-2">
                            <label class="form-label">
                                Parent ID
                            </label>

                            <input
                                type="number"
                                wire:model.live="parentId"
                                class="form-control"
                                placeholder="Parent ID"
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


                    {{-- Summary --}}
                    <div class="row g-3 mb-3">

                        <div class="col-md-4">
                            <div class="card bg-light border">
                                <div class="card-body py-3">

                                    <div class="text-muted small">
                                        Total Deposit
                                    </div>

                                    <div class="fs-4 fw-bold">
                                        {{ number_format($totalDeposit, 2) }}
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="card bg-light border">
                                <div class="card-body py-3">

                                    <div class="text-muted small">
                                        Total Investment
                                    </div>

                                    <div class="fs-4 fw-bold">
                                        {{ number_format($totalInvestment, 2) }}
                                    </div>

                                </div>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="card bg-light border">
                                <div class="card-body py-3">

                                    <div class="text-muted small">
                                        Total Income
                                    </div>

                                    <div class="fs-4 fw-bold">
                                        {{ number_format($totalIncome, 2) }}
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>


                    {{-- Table --}}
                    <div class="table-responsive">

                        <table class="table table-bordered table-hover align-middle">

                            <thead>
                                <tr>

                                    <th style="width:2%">
                                        SL
                                    </th>

                                    <th>
                                       Client
                                        Name
                                    </th>

                                    <th>
                                        Parent
                                    </th>

                                    <th style="text-align:center">
                                        Team
                                    </th>

                                    <th>
                                        Phone
                                    </th>

                                    <th>
                                        Created
                                    </th>

                                    <th>
                                        Update
                                    </th>

                                    <th style="text-align:center">
                                        Status
                                    </th>

                                    <th style="text-align:right">
                                        Deposit
                                    </th>

                                    <th style="text-align:right">
                                        Investment
                                    </th>

                                    <th style="text-align:right">
                                        Income
                                    </th>

                                    <th style="text-align:center; width:150px;">
                                        Action
                                    </th>

                                </tr>
                            </thead>


                            <tbody>

                                @forelse($clients as $client)

                                    <tr
                                        wire:key="client-row-{{ $client->id }}"
                                        class="{{ $client->inactive ? 'table-danger' : '' }}"
                                    >

                                        {{-- SL --}}
                                        <td>
                                            {{ $clients->firstItem() + $loop->index }}
                                        </td>

                                        <td>
                                            {{ $client->id }}-{{ $client->name }}
                                
                                        </td>


                                        {{-- Parent --}}
                                        <td>

                                            @if($client->ref_id == 0)

                                                Root

                                            @else

                                                {{ $client->ref_id }}

                                                @if($client->parent)
                                                    -{{ $client->parent->name }}
                                                @endif

                                            @endif

                                        </td>


                                        {{-- Team --}}
                                        <td style="text-align:center">

                                            @if($client->ref_id == 0)

                                                -

                                            @else

                                                @if($client->site == 0)
                                                    A
                                                @else
                                                    B
                                                @endif

                                            @endif

                                        </td>


                                        {{-- Phone --}}
                                        <td>
                                            {{ $client->phone }}
                                        </td>


                                        {{-- Created --}}
                                        <td>
                                            {{ \Carbon\Carbon::parse($client->created_at)->format('j M y g:i A') }}
                                        </td>


                                        {{-- Updated --}}
                                        <td>
                                            {{ \Carbon\Carbon::parse($client->updated_at)->format('j M y g:i A') }}
                                        </td>


                                        {{-- Status --}}
                                        <td
                                            class="{{ $client->inactive ? 'text-danger' : 'text-success' }}"
                                            style="text-align:center"
                                        >
                                            {{ $client->inactive == 0 ? 'Active' : 'Inactive' }}
                                        </td>


                                        {{-- Deposit --}}
                                        <td style="text-align:right">
                                            {{ number_format($client->deposit_balance, 2) }}
                                        </td>


                                        {{-- Investment --}}
                                        <td style="text-align:right">
                                            {{ number_format($client->investment_balance, 2) }}
                                        </td>


                                        {{-- Income --}}
                                        <td style="text-align:right">
                                            {{ number_format($client->income_balance, 2) }}
                                        </td>


                                        {{-- Actions --}}
                                        <td style="text-align:center">

                                            {{-- Edit Button --}}
                                            <button
                                                wire:click="edit({{ $client->id }})"
                                                class="btn btn-primary btn-sm"
                                                title="Edit"
                                            >
                                                <i class="bi bi-pencil-square"></i>
                                            </button>


                                            {{-- Details Button --}}
                                            <button
                                                data-bs-toggle="modal"
                                                data-bs-target="#ModalClient"
                                                wire:click="showDetails({{ $client->id }})"
                                                class="btn btn-success btn-sm"
                                                title="Details"
                                            >
                                                <i class="bi bi-eye"></i>
                                            </button>

                                            {{-- Verification Button --}}
                                            @if($client->verification_status == 1)
                                                {{-- 1: Success (Green), Clickable, Shows Modal --}}
                                                <button
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#ModalVerification"
                                                    wire:click="showVerification({{ $client->id }})"
                                                    class="btn btn-success btn-sm"
                                                    title="Verified"
                                                >
                                                    <i class="bi bi-shield-check"></i>
                                                </button>
                                            @elseif($client->verification_status == 2)
                                                {{-- 2: Warning (Yellow), Clickable, Shows Modal --}}
                                                <button
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#ModalVerification"
                                                    wire:click="showVerification({{ $client->id }})"
                                                    class="btn btn-warning btn-sm"
                                                    title="Pending Verification"
                                                >
                                                    <i class="bi bi-shield-exclamation"></i>
                                                </button>
                                            @else
                                                {{-- 0: Danger (Red), Not Clickable, No Modal --}}
                                                <button
                                                    type="button"
                                                    class="btn btn-danger btn-sm"
                                                    title="Not Verified"
                                                    disabled
                                                >
                                                    <i class="bi bi-shield-x"></i>
                                                </button>
                                            @endif
                                        
                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="13" class="text-center py-4">
                                            No clients found.
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>


                            {{-- Total --}}
                            <tfoot>

                                <tr class="fw-bold">

                                    <td colspan="9" class="text-end">
                                        TOTAL
                                    </td>

                                    <td class="text-end">
                                        {{ number_format($totalDeposit, 2) }}
                                    </td>

                                    <td class="text-end">
                                        {{ number_format($totalInvestment, 2) }}
                                    </td>

                                    <td class="text-end">
                                        {{ number_format($totalIncome, 2) }}
                                    </td>

                                    <td></td>

                                </tr>

                            </tfoot>

                        </table>

                    </div>


                    {{-- Pagination --}}
                    <div class="d-flex justify-content-between align-items-center mt-3">

                        <div class="text-muted">
                            Showing
                            {{ $clients->firstItem() ?? 0 }}
                            to
                            {{ $clients->lastItem() ?? 0 }}
                            of
                            {{ $clients->total() }}
                            clients
                        </div>

                        <div>
                            {{ $clients->links() }}
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

 {!! Toast::get_toast_message() !!}

    <div    wire:ignore.self  class="modal fade modal-lg" id="ModalClient" tabindex="-1" aria-labelledby="ModalLiveLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="ModalLiveLabel">Client Details</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    @if($selectedClient)

                        <div class="row">

                            <div class="col-md-4 text-center">
                                @if($selectedClient->photo)
                                    <img
                                        src="{{ asset('storage/' . $selectedClient->photo) }}"
                                        class="img-fluid rounded"
                                        style="max-height:200px;"
                                    >
                                @else
                                    <img
                                        src="https://via.placeholder.com/200"
                                        class="img-fluid rounded"
                                    >
                                @endif
                            </div>

                            <div class="col-md-8">

                                <table class="table table-bordered">

                                    <tr>
                                        <th width="30%">ID</th>
                                        <td>{{ $selectedClient->id }}</td>
                                    </tr>

                                    <tr>
                                        <th>Name</th>
                                        <td>{{ $selectedClient->name }}</td>
                                    </tr>

                                    <tr>
                                        <th>Email</th>
                                        <td>{{ $selectedClient->email }}</td>
                                    </tr>

                                    <tr>
                                        <th>Phone</th>
                                        <td>{{ $selectedClient->phone }}</td>
                                    </tr>

                                    <tr>
                                        <th>Address</th>
                                        <td>{{ $selectedClient->address }}</td>
                                    </tr>

                                    <tr>
                                        <th>Status</th>
                                        <td>
                                            {{ $selectedClient->inactive ? 'Inactive' : 'Active' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Team A</th>
                                        <td>{{ $leftCount }}</td>
                                    </tr>
                                    <tr>
                                        <th>Team B</th>
                                        <td>{{ $rightCount }}</td>
                                    </tr>

                                    <tr>
                                        <th>Team A Reference</th>
                                        <td>
                                            <span id="leftRef">
                                                {{ 'https://globexacapital.com?ref='.$selectedClient->left_side }}
                                            </span>

                                            <button
                                                type="button"
                                                class="btn btn-sm btn-outline-primary ms-2"
                                                onclick="copyText('{{ 'https://globexacapital.com?ref='.$selectedClient->left_side }}')"
                                            >
                                            <i class="bi bi-copy"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Team B Reference</th>
                                        <td>
                                            <span id="rightRef">
                                                {{ 'https://globexacapital.com?ref='.$selectedClient->right_side }}
                                            </span>

                                            <button
                                                type="button"
                                                class="btn btn-sm btn-outline-primary ms-2"
                                                onclick="copyText('{{ 'https://globexacapital.com?ref='.$selectedClient->right_side }}')"
                                            >
                                            <i class="bi bi-copy"></i>
                                            </button>
                                        </td>
                                    </tr>

                                </table>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    {{-- Verification Modal --}}
    <div
        wire:ignore.self
        class="modal fade"
        id="ModalVerification"
        tabindex="-1"
        aria-labelledby="ModalVerificationLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-xl modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title" id="ModalVerificationLabel">
                        Client Verification
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>

                </div>


                <div class="modal-body">

                    @if($verificationClient)

                        <div class="row g-4">

                            {{-- Document Image --}}
                            {{-- Document Image --}}
                            <div class="col-md-6">

                                <div class="card border">

                                    <div class="card-header">
                                        <strong>
                                            Verification Document
                                        </strong>
                                    </div>

                                    <div class="card-body text-center">

                                        @if(count($verificationDocImg) > 0)

                                            <div class="row g-2">

                                                @foreach($verificationDocImg as $docImg)

                                                    <div class="col-12">
                                                        <img
                                                            src="{{ asset('storage/' . $docImg) }}"
                                                            class="img-fluid rounded border"
                                                            style="
                                                                max-height:280px;
                                                                width:100%;
                                                                object-fit:contain;
                                                                cursor:pointer;
                                                            "
                                                            alt="Verification Document"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#ImagePreviewModal"
                                                            onclick="document.getElementById('previewImg').src = this.src"
                                                        >
                                                    </div>

                                                @endforeach

                                            </div>

                                        @else

                                            <div class="text-muted py-5">
                                                No verification document uploaded.
                                            </div>

                                        @endif

                                    </div>

                                </div>

                            </div>


                            {{-- Verification Information --}}
                            <div class="col-md-6">

                                <div class="card border">

                                    <div class="card-header">
                                        <strong>
                                            Client Information
                                        </strong>
                                    </div>

                                    <div class="card-body">

                                        <table class="table table-bordered">

                                            <tr>
                                                <th width="40%">
                                                    Client ID
                                                </th>
                                                <td>
                                                    {{ $verificationClient->id }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>
                                                    First Name
                                                </th>
                                                <td>
                                                    {{ $verificationFirstName }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>
                                                    Last Name
                                                </th>
                                                <td>
                                                    {{ $verificationLastName }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>
                                                    Date of Birth
                                                </th>
                                                <td>
                                                    {{ $verificationDob }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>
                                                    Address
                                                </th>
                                                <td>
                                                    {{ $verificationAddress }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>
                                                    Post Code
                                                </th>
                                                <td>
                                                    {{ $verificationPostCode }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>
                                                    City
                                                </th>
                                                <td>
                                                    {{ $verificationCity }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>
                                                    Document Type
                                                </th>
                                                <td>
                                                    {{ $verificationDocType }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>
                                                    Current Status
                                                </th>
                                                <td>

                                                    @if($verificationClient->verification_status == 1)

                                                        <span class="badge bg-success">
                                                            Success
                                                        </span>

                                                    @elseif($verificationClient->verification_status == 2)

                                                        <span class="badge bg-warning text-dark">
                                                            Pending
                                                        </span>

                                                    @else

                                                        <span class="badge bg-danger">
                                                            Cancel
                                                        </span>

                                                    @endif

                                                </td>
                                            </tr>

                                        </table>


                                        {{-- Status --}}
                                        <div class="mt-4">

                                            <label class="form-label fw-bold">
                                                Verification Status
                                            </label>

                                            @if($verificationClient->verification_status == 1)

                                                {{-- Already verified --}}
                                                <div>
                                                    <span class="badge bg-success fs-6">
                                                        <i class="bi bi-shield-check me-1"></i>
                                                        Success
                                                    </span>
                                                </div>

                                                <div class="text-muted small mt-2">
                                                    This client has already been verified and cannot be changed.
                                                </div>

                                            @else

                                                {{-- Pending --}}
                                                <select
                                                    wire:model="verificationStatus"
                                                    class="form-select"
                                                >
                                                    <option value="0">
                                                        Cancel
                                                    </option>

                                                    <option value="1">
                                                        Success
                                                    </option>
                                                </select>

                                                @error('verificationStatus')
                                                    <div class="text-danger mt-1">
                                                        {{ $message }}
                                                    </div>
                                                @enderror

                                                {{-- Description / Reason --}}
                                                <div class="mt-3">

                                                    <label class="form-label fw-bold">
                                                        Verification Description
                                                    </label>

                                                    <textarea
                                                        wire:model.defer="verification_description"
                                                        class="form-control"
                                                        rows="3"
                                                        placeholder="Add a note or reason for this status (optional)"
                                                    ></textarea>

                                                    @error('verificationDescription')
                                                        <div class="text-danger mt-1">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror

                                                </div>

                                            @endif

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    @else

                        <div class="text-center py-5">
                            Loading verification information...
                        </div>

                    @endif

                </div>


                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Close
                    </button>

                    @if($verificationClient && $verificationClient->verification_status != 1)

                        <button
                            type="button"
                            wire:click="updateVerificationStatus"
                            class="btn btn-primary"
                        >
                            <i class="bi bi-check-circle me-1"></i>
                            Update Status
                        </button>

                    @endif

                </div>

            </div>

        </div>
    </div>

    <script>
        function copyText(text)
        {
            navigator.clipboard.writeText(text)
                .then(() => {
                })
                .catch(err => {
                });
        }


        document.addEventListener('livewire:init', () => {

            Livewire.on('close-verification-modal', () => {

                const modalElement =
                    document.getElementById('ModalVerification');

                const modal =
                    bootstrap.Modal.getInstance(modalElement);

                if (modal) {
                    modal.hide();
                }

            });

        });
    </script>

</div>