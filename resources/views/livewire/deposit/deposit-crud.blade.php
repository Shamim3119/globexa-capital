@php
    use App\Helpers\Toast;
@endphp


<div>
    <br>
    <div class='row'>
        <div class='col-12 col-md-12 col-lg-12'>


            <div @if($updateMode) style="display:none;" @endif id='boxView' class="card card-primary card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">{{ ucfirst($activeTab) }} List</div>
                </div>
                <div class="card-body">

                    <table class="table table-bordered mt-3">

                        <thead>
                            <tr>
                                <th style="width:2%">SL</th>
                                <th>Deposit By</th>
                                <th>Deposit At</th>
                                <th>Accept At</th>
                                <th>Status</th>
                                <th>Currency</th>
                                <th style='text-align:right'>Before</th>
                                <th style='text-align:right'>Amount</th>
                                <th style='text-align:right'>After</th>
                                <th style="text-align:center; width:150px;">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($deposits as $deposit)
                                <tr
                                    wire:key="client-row-{{ $deposit->id }}"
                                    class="{{ $deposit->status_id == 0 ? 'text-danger' : '' }}"
                                >
                               

                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $deposit->deposit_by }}</td>
                                    <td>{{ $deposit->deposit_at }}</td>
                                    <td>{{ $deposit->accept_at }}</td>
                                    <td>{{ $deposit->status_id }}</td>
                                    <td>{{ $deposit->currency_id }}</td>
                                    <td>{{ $deposit->deposit_by }}</td>


                                    <td>
                                        @if($client->ref_id == 0)
                                            Root
                                        @else
                                            {{ $client->ref_id.' / '.$client->parent->name ?? 'N/A' }}
                                        @endif
                                    </td>
                                    <td style='text-align:center'>
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
                                    <td>{{ $client->phone }}</td>
                                    <td>{{ \Carbon\Carbon::parse($client->updated_at)->format('j M y g:i A') }}</td>
                                    <td style='text-align:right'>{{ $client->balance }}</td>
                                    <td class="{{ $client->inactive ? 'text-danger' : '' }}" style="text-align:center">{{ $client->inactive == 0 ? 'Active' : 'Inactive' }}</td>

                                    <td style="text-align:center;width:150px;">
                                        <button   
                                            wire:click="edit({{ $client->id }})"
                                            class="btn btn-primary btn-sm">
                                            Edit
                                        </button>

                                        <button data-bs-toggle="modal" data-bs-target="#ModalClient" 
                                            wire:click="showDetails({{ $client->id }})"
                                            class="btn btn-success btn-sm"
                                        >
                                            Details
                                        </button>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {!! Toast::get_toast_message() !!}

    <div    wire:ignore.self class="modal fade modal-lg" id="ModalClient" tabindex="-1" aria-labelledby="ModalLiveLabel" style="display: none;" aria-hidden="true">
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

 

</div>