<div>
    @if(session()->has('success'))
    <div wire:poll.3s="hide" class="alert alert-success mb-0 mt-3" role="alert" :wire:key="concat('admin.products-add', hide)">
        {{ session('success') }}
    </div>
    @endif

    @if(session()->has('danger'))
        <div wire:poll.3s="hide" class="alert alert-danger mb-0 mt-3" role="alert" :wire:key="concat('admin.products-add', hide)">
            {{ session('danger') }}
        </div>
    @endif
    

    <div class="row g-3 pt-3 d-flex justify-content-center">
        <div class="col-lg-3">
            <div class="card bg-light shadow-sm">
                <div class="card-header bg-dark text-light">
                    <h1 class="pt-2 fs-6 fw-bold">Profile Picture</h1>
                </div>
                <div class="card-body">
                    <div class="py-3 mb-1">
                        <div class="fixed-size-md">
                            @if($image)
                                <img src="{{ $image->temporaryUrl() }}" alt="" class="fixed-size-responsive border border-dark rounded-circle">
                            @elseif($user->image)
                                <img src="{{ asset('storage/' . $user->image) }}" alt="" class="fixed-size-responsive border border-dark rounded-circle">
                            @else
                                <img src="{{ asset('images/profile.svg') }}" alt="" class="fixed-size-responsive border border-dark rounded-circle">
                            @endif
                        </div>
                        <div>  
                            <form wire:submit="uploadImage">
                                <div class="d-flex justify-content-start gap-1">
                                    <div class="btn-group pt-3 dropend"> 
                                        <button class="btn btn-outline-dark btn-sm dropdown-toggle shadow-sm" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-edit"></i>
                                        </button>
                                        
                                        <ul class="dropdown-menu">
                                            <li class="dropdown-item">
                                                @csrf
                                                <!-- Add a hidden file input element -->
                                                <input type="file" id="file-input" style="display: none;" wire:model.live="image" accept="image/*">
                                                <!-- Use JavaScript to open the file upload dialog -->
                                                <a onclick="event.preventDefault(); document.getElementById('file-input').click();" style="cursor: pointer;">Upload Image</a>
                                            </li>
                                            <li class="dropdown-item">
                                                <a wire:click="removeImage" style="cursor: pointer;">Remove Image</a>
                                            </li>
                                        </ul>       
                                    </div>
                                    
                                    @if($image)
                                        <div class="pt-3">
                                            <button type="submit" class="btn btn-sm btn-outline-success">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                        </div>
                                    @endif
                                </div>    
                            </form>       
                        </div> 
                    </div>      
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card bg-light shadow-sm">
                <div class="card-header bg-dark text-light">
                    <h1 class="pt-2 fs-6 fw-bold">Account Password</h1>
                </div>

                <div class="card-body">
                    <form wire:submit="changePassword">
                        <div class="row gap-3">
                            <div class="col-12">
                                <label for="current_password" class="form-label fw-bold">Current Password</label>
                                <input type="password" class="form-control" 
                                id="current_password" wire:model.live.debounce.500ms="current_password"
                                placeholder="Current password">
                                @error('current_password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12">
                                <label for="new_password" class="form-label fw-bold">New Password</label>
                                <input type="password" class="form-control" 
                                id="new_password" wire:model.live.debounce.500ms="new_password"
                                placeholder="New password">
                                @error('new_password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12">
                                <label for="confirm_password" class="form-label fw-bold">Confirm Password</label>
                                <input type="password" class="form-control" 
                                id="confirm_password" wire:model.live.debounce.500ms="confirm_password"
                                placeholder="Confirm Password">
                                @error('confirm_password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-12 text-end">
                                <button type="submit" class="btn btn-sm shadow-sm @if($current_password && $new_password && $confirm_password) btn-success @else btn-outline-success @endif ">
                                    <i class="fa-solid fa-check"></i> Confirm
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
  
