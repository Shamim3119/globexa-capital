<div>
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'bussiness' ? 'active' : '' }}" 
            href="{{ route('bussiness.index', ['tab' => 'bussiness']) }}">
            Business
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ $activeTab == 'profile' ? 'active' : '' }}" 
            href="{{ route('profile.index', ['tab' => 'profile']) }}">
            User Profile
            </a>
        </li>
    </ul>
    <br>

    <div class='row'>
        <div class='col-6'>
            <form wire:submit.prevent="save">
                <div class="card card-primary card-outline mb-4">
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
                            <label>Email</label>
                            <input readonly   type="email" class="form-control" wire:model="email">
                            @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>Phone</label>
                            <input type="text" class="form-control" wire:model="phone">
                            @error('phone') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>Address</label>
                            <input type="address" class="form-control" wire:model="address">
                            @error('emaaddressil') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class='row'>
                            <div class='col-8 mt-3'>
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control" id="img" wire:model="image">
                                    <label class="input-group-text" for="img">Upload</label>
                                </div>
                            </div>
                         
                            <div class='col-4 d-flex justify-content-center align-items-center'>
                                <img id="previewImage"
                                    src="
                                        @if ($image)
                                            {{ $image->temporaryUrl() }}
                                        @elseif($user->image)
                                            {{ asset('storage/' . $user->image) }}
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


                    </div>
                    <div class="card-footer">
                        <div class="m-3 d-flex justify-content-center">
            
                                <button type="submit" class="btn btn-success">Update</button>&nbsp;&nbsp;
                                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
   </div>

    {!! MyHelper::get_toast_dispatch() !!}
    
</div>