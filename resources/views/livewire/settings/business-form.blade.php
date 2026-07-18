            <div @if(!$updateMode) style="display:none;" @endif id='boxNew' class="card card-primary card-outline mb-4">
    
                <form wire:submit.prevent="save">
 
                    <div class="card-header">
                        <div class="card-title">{{ ucfirst($activeTab) }} Update</div>
                    </div> 
                    <div class="card-body m-3">

                        <div class="mb-3">
                            <label>Name</label>
                            <input type="text" class="form-control" wire:model="name">
                            @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label>Address</label>
                            <input type="address" class="form-control" wire:model="address">
                            @error('emaaddressil') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>Phone</label>
                            <input type="text" class="form-control" wire:model="phone">
                            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>Email</label>
                            <input   type="email" class="form-control" wire:model="email">
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>Web</label>
                            <input  type="web" class="form-control" wire:model="web">
                            @error('web') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>


                        <div class='row'>
                            <div class='col-8'>
                                <label class="form-label">Company Logo</label>
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control" id="img" wire:model="logo">
                                    <label class="input-group-text" for="img">Upload</label>
                                </div>
                            </div>
                        
                            <div class='col-4 d-flex justify-content-center align-items-center'>
                                <img id="previewlogo"
                                    src="
                                        @if ($logo)
                                            {{ $logo->temporaryUrl() }}
                                        @elseif($business->logo)
                                            {{ asset('storage/' . $business->logo) }}
                                        @else
                                            https://via.placeholder.com/120
                                        @endif
                                    "
                                    class="rounded-circle border"
                                    width="120"
                                    height="120"
                                    style="object-fit: cover;">
                            </div>

                            <script>
                                document.getElementById('img').addEventListener('change', function(event) {
                                    const file = event.target.files[0];

                                    if (file) {
                                        const reader = new FileReader();

                                        reader.onload = function(e) {
                                            document.getElementById('previewImage').src = e.target.result;
                                        }

                                        reader.readAsDataURL(file);
                                    }
                                });
                            </script>
                        </div>

                        <div class="row">

                            <div class="col-8">

                                <label class="form-label">Company Document (PDF)</label>

                                <div class="input-group">

                                    <input
                                        type="file"
                                        class="form-control"
                                        wire:model="company_doc"
                                        accept=".pdf,application/pdf">

                                    <label class="input-group-text">
                                        Upload
                                    </label>

                                </div>

                                @error('company_doc')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>

                            <div class="col-4 d-flex align-items-center justify-content-center">

                                @if($company_doc)

                                    <span class="badge bg-success fs-6">
                                        PDF Selected
                                    </span>

                                @elseif($business->company_doc)

                                    <a
                                        href="{{ asset('storage/'.$business->company_doc) }}"
                                        target="_blank"
                                        class="btn btn-outline-primary">

                                        <i class="bi bi-file-earmark-pdf"></i>
                                        View PDF

                                    </a>

                                @else

                                    <span class="text-muted">
                                        No PDF
                                    </span>

                                @endif

                            </div>

                        </div>

                    </div>
                    <div class="card-footer">
                        <div class="m-3 d-flex justify-content-center">
            
                                <button type="submit" class="btn btn-success"><i class="bi bi-check-square"></i>  Update</button>&nbsp;&nbsp;
                                <a href="{{ route('bussiness.index', ['tab' => 'bussiness']) }}" class="btn btn-secondary"><i class="bi bi-x-square"></i> Cancel</a>
                        </div>
                    </div>
                </form>
            </div>