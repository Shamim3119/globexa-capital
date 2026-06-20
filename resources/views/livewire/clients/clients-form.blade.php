    <div class='row'>
        <div class='col-12 col-md-6 col-lg-6'>
             
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
                            <label class="mb-2">Name</label>
                            <input type="text" class="form-control" placeholder="Name" wire:model.defer="name" >
                            @error('name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="mb-2">Email</label>
                            <input type="email" class="form-control" placeholder="Email" wire:model.defer="email" >
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="mb-2">Phone</label>
                            <input type="text" class="form-control" placeholder="Phone" wire:model.defer="phone" >
                            @error('phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="mb-2">Address</label>
                            <input type="text" class="form-control" placeholder="Address" wire:model.defer="address" >
                            @error('address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>


                    <div class='row'>
                            <div class='col-8 mt-3'>
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control" id="img" wire:model="photo">
                                    <label class="input-group-text" for="img">Upload</label>
                                </div>
                            </div>
                         
                            <div class='col-4 d-flex justify-content-center align-items-center'>
                                <img id="previewImage"
                                    src="
                                    @if($photo instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                                        {{ $photo->temporaryUrl() }}
                                    @elseif($photo)
                                        {{ asset('storage/'.$photo) }}
                                    @else
                                        {{ asset('assets/img/logo.webp') }}
                                        https://via.placeholder.com/120
                                    @endif
                                    "
                                    class="rounded-circle border"
                                    width="120"
                                    height="120"
                                    style="object-fit: cover;">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="m-3 d-flex justify-content-center">
                            @if($client_id)
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

        </div>
    </div>