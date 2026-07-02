<div class='m-3'>

<form wire:submit.prevent="store">

    <div class="mb-3 form-check">
        <input type="checkbox"
            class="form-check-input"
            id="inactive"
            wire:model="inactive">

        <label class="form-check-label text-danger fw-bold" for="inactive">
            Inactive
        </label>
        <style>
            .form-check-input:checked {
                background-color: red;
                border-color: red;
            }
        </style>
    </div>

    <div class="mb-3">
        <label>Bank Type :</label>

        <select class="form-select" wire:model.live="operator_id">

            <option value="">--Select--</option>

            @foreach($bank_operators as $bank_operator)

                <option value="{{ $bank_operator->id }}">
                    {{ $bank_operator->name }}
                </option>

            @endforeach

        </select>

        @error('operator_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

 

    <div class="mb-3">
        <label>Account No / Address</label>

        <input
            type="text"
            class="form-control"
            wire:model="account_no"
        >

        @error('account_no')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <label>Account Name</label>

        <input
            type="text"
            class="form-control"
            wire:model="account_name"
        >

        @error('account_name')
            <span class="text-danger">{{ $message }}</span>
        @enderror
    </div>

    <div class="mb-3">
        <label>QR Code</label>

        <input
            type="file"
            class="form-control"
            wire:model="qr_code"
            accept="image/*"
        >

        @error('qr_code')
            <span class="text-danger">{{ $message }}</span>
        @enderror

        {{-- Preview newly selected image --}}
        @if($qr_code)
            <div class="mt-2">
                <img src="{{ $qr_code->temporaryUrl() }}"
                    width="150"
                    class="img-thumbnail">
            </div>

        {{-- Show existing image while editing --}}
        @elseif($old_qr_code)
            <div class="mt-2">
                <img src="{{ asset('storage/qr_code/'.$old_qr_code) }}"
                    width="150"
                    class="img-thumbnail">
            </div>
        @endif

        <div wire:loading wire:target="qr_code" class="text-primary mt-2">
            Uploading...
        </div>
    </div>

    <div class="mb-3">

        @if($updateMode)

            <button type="submit" class="btn btn-md btn-primary btn-sm">
            <i class="bi bi-check-square"></i> Update
            </button>

            <button
                type="button"
                class="btn btn-secondary btn-sm"
                wire:click="cancel"
            >
                <i class="bi bi-x-lg"></i> Cancel
            </button>

        @else

            <button type="submit" class="btn btn-success btn-sm">
                <i class="bi bi-floppy"></i> Save
            </button>

        @endif

    </div>

</form>

<br>

<h5 class="mt-3">Accounts Details</h5>

<table class="table table-bordered mt-3">

    <thead>
        <tr>
            <th>SL</th>
            <th>Account No</th>
            <th>Account Name</th>
            <th>Operator</th>
            <th>Currency</th>
            <th style="width:100px;text-align:center">Action</th>
        </tr>
    </thead>

    <tbody>

        @foreach($accounts as $account)

            <tr>

                <td>{{ $loop->iteration }}</td>

                <td class="{{ $account->inactive ? 'text-danger' : '' }}">
                    {{ $account->account_no }}
                </td>

                <td class="{{ $account->inactive ? 'text-danger' : '' }}">
                    {{ $account->account_name }}
                </td>

                <td class="{{ $account->inactive ? 'text-danger' : '' }}">
                    {{ $account->operator_name ?? '' }}
                </td>

                <td class="{{ $account->inactive ? 'text-danger' : '' }}">
                    {{ $account->currency_name ?? '' }}
                </td>

                

 

                <td style="text-align:center">
                    <button
                        wire:click="edit({{ $account->id }})"
                        class="btn btn-primary btn-sm"
                    >
                           <i class="bi bi-pencil-square"></i>
                    </button>

                    <button
                        wire:click="delete({{ $account->id }})"
                        class="btn btn-danger btn-sm"
                    >
                    <i class="bi bi-trash-fill"></i>
                    </button>
                </td>

            </tr>

        @endforeach

    </tbody>

</table>

</div>