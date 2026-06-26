            <div @if(!$updateMode) style="display:none;" @endif id='boxNew' class="card card-primary card-outline mb-4">
                <div class="card-header">
                    <div class="card-title">{{ ucfirst($activeTab) }} Update</div>
                </div>

                <form wire:submit.prevent="store" wire:key="bank_operator-form-{{ $updateMode ? 'edit' : 'create' }}">
                    
                    <div class="card-body">

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="exampleCheck1" wire:model="inactive">
                            <label class="form-check-label" for="exampleCheck1">Inactive</label>
                        </div>
 


                        <div class="mb-3">
                          <label>Bank Type :</label>
                                <select class="form-select" wire:model="type_id">
                                    <option selected value="">Select Bank Type</option>
                                        @foreach($bank_types as $type)
                                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                                        @endforeach
                                </select>
                                @error('type_id') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label>Currency:</label>
                            <select class="form-select" wire:model="currency_id">
                                <option value="">Select Currency</option>
                                @foreach($currencies as $currency)
                                    <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                                @endforeach
                            </select>
                            @error('currency_id')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
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
                            @if($bank_operator_id)
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