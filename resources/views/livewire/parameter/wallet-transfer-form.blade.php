            <div @if(!$updateMode) style="display:none;" @endif id='boxNew' class="card card-primary card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">{{ ucfirst($activeTab) }} Update</div>
                </div>

                <form wire:submit.prevent="store" wire:key="wallet_types-form-{{ $updateMode ? 'edit' : 'create' }}">
                    
                    <div class="card-body">

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" wire:model="inactive">
                            <label class="form-check-label" for="exampleCheck1">Inactive</label>
                        </div>
 

                        <div class="mb-3">
                          <label>Wallet Transfer Type :</label>
                                <select class="form-select" wire:model="transfer_type_id">
                                    <option selected value="">Select Wallet Transfer Type</option>
                                        @foreach($transfer_types as $transfer_type)
                                            <option value="{{ $transfer_type->id }}">{{ $transfer_type->name }}</option>
                                        @endforeach
                                </select>
                                @error('transfer_type_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>


                        <div class="mb-3">
                          <label>Wallet Type :</label>
                                <select class="form-select" wire:model="wallet_type_id">
                                    <option selected value="">Select Wallet Type</option>
                                        @foreach($wallet_types as $wallet_type)
                                            <option value="{{ $wallet_type->id }}">{{ $wallet_type->name }}</option>
                                        @endforeach
                                </select>
                                @error('transfer_type_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                
                    </div>
                    <div class="card-footer">
                        <div class="m-3 d-flex justify-content-center">
                            @if($wallet_type_id)
                                <button type="submit" class="btn btn-md  btn-success"><i class="bi bi-check-square"></i> Update</button>&nbsp;&nbsp;
                                <button type="button" wire:click="cancel" class="btn btn-md btn-secondary"><i class="bi bi-x-square"></i>  Cancel</button>
                            @else
                                <button type="submit" class="btn btn-md btn-success"><i class="bi bi-floppy"></i> Save</button>&nbsp;&nbsp;
                                <button type="button" wire:click="cancel" class="btn btn-md btn-secondary"><i class="bi bi-x-square"></i>  Cancel</button>
                            @endif
                        </div>
                    </div>
                </form>
            </div>