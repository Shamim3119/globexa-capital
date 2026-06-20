<div>
 
    <br>

    <div class='row'>
        <div class='col-12 col-md-6'>
            <button 
                wire:click="create"
                class="mb-3 btn btn-sm btn-primary"
                @if($updateMode) style="display:none;" @endif >
                New {{ ucfirst($activeTab) }}
            </button>
         
 
            <div @if(!$updateMode) style="display:none;" @endif id='boxNew' class="card card-primary card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">{{ ucfirst($activeTab) }} Update</div>
                </div>

                <form wire:submit.prevent="store" wire:key="parameter-form-{{ $updateMode ? 'edit' : 'create' }}">
                    
                    <div class="card-body">

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" wire:model="inactive">
                            <label class="form-check-label" for="exampleCheck1">Inactive</label>
                        </div>

                        <div class="mb-3">
                            <label class="mb-2">{{ ucfirst($activeTab) }} :</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Name"
                                wire:model.defer="name"
                            >
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="m-3 d-flex justify-content-center">
                            @if($parameter_id)
                                <button type="submit" class="btn btn-primary">Update</button>&nbsp;&nbsp;
                                <button type="button" wire:click="cancel" class="btn btn-secondary">Cancel</button>
                            @else
                                <button type="submit" class="btn btn-success">Save</button>&nbsp;&nbsp;
                                <button type="button" wire:click="cancel" class="btn btn-secondary">Cancel</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        
    

            <div @if($updateMode) style="display:none;" @endif id='boxView' class="card card-primary card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">{{ ucfirst($activeTab) }} List</div>
                </div>
                <div class="card-body">

                    <table class="table table-bordered mt-3">

                        <thead>
                            <tr>
                                <th style="width:2%">SL</th>
                                <th>Name</th>
                                <th style="width:15%;text-align:center;">Status</th>
                                <th style="text-align:center; width:150px;">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($parameters as $parameter)
                                <tr wire:key="parameter-row-{{ $parameter->id }}">

                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $parameter->name }}</td>
                                    <td class="{{ $parameter->inactive ? 'text-danger' : '' }}" style="text-align:center">{{ $parameter->inactive == 0 ? 'Active' : 'Inactive' }}</td>

                                    <td style="text-align:center;width:150px;">
                                        <button   
                                            wire:click="edit({{ $parameter->id }})"
                                            class="btn btn-primary btn-sm">
                                            Edit
                                        </button>

                                        <button
                                            wire:click="delete({{ $parameter->id }})"
                                            class="btn btn-danger btn-sm"
                                        >
                                            Delete
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

    {!! MyHelper::get_toast_dispatch() !!}

 
</div>