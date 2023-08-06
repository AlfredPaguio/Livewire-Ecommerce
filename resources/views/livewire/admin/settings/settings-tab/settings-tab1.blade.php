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

    <form wire:submit="updateCompanyProfile">
        <div class="row g-3 pt-3">
            <div class="col-lg-5 col-md-6">
                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <h1 class="fw-bold fs-5 pt-2">Company Logo</h1>
                    </div>
                    <div class="card-body bg-light">
                        <div>
                            <label for="company_logo" class="form-label fw-bold">Company Logo</label>
                            <input class="form-control @error('company_logo') is-invalid  @enderror
                            @if('company_logo') '' @endif"
                            type="file" id="company_logo"
                            wire:model.live="company_logo" accept="image/*">

                            @error('company_logo') 
                                <small class="text-danger">{{ $message }}</small>
                            @enderror

                            <div class="pt-3 fixed-size-company-logo">
                                @if($company_logo)
                                    @if(!$company_logo->isPreviewable())
                                        
                                    @else
                                        <img src="{{ $company_logo->temporaryUrl() }}" class="img-fluid" alt="Company Logo">
                                    @endif
                                @elseif($company_profile->logo)
                                    <img src="{{ asset('storage/'.$company_profile->logo) }}" class="img-fluid" alt="Company Logo">
                                @else
                                    <img src="{{ asset('images/bnd.png') }}" class="img-fluid" alt="Company Logo">
                                @endif
                            </div>
                        </div>
                    </div>   
                </div>
            </div>

            <div class="col-lg-7 col-md-6">
                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <h1 class="fw-bold fs-5 pt-2">Company Profile</h1>
                    </div>
                    <div class="card-body bg-light">
                        <div>
                            <label for="company_profile.name" class="form-label fw-bold">Company Name</label>
                            <input type="text" class="form-control @error('company_profile.name') is-invalid  @enderror
                            @if('company_profile.name') '' @endif"
                            id="company_profile.name" placeholder="Company Name"
                            wire:model.live.debounce.500ms="company_profile.name">
                            @error('company_profile.name') 
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>   
                </div>

                <div class="py-1"></div>

                <div class="card">
                    <div class="card-header bg-dark text-light">
                        <div class="d-flex justify-content-between">
                            <h1 class="fw-bold fs-5 pt-2">Company Socials</h1>
                            <button class="btn btn-success shadow-sm" wire:click.prevent="addSocials">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div> 
                    </div>

                    <div class="card-body bg-light">
                        @if(!$socials)
                            <div class="alert alert-danger m-0">
                                No social media added yet..
                            </div>
                        @else
                            <div class="@if(count($socials) > 1) overflow-auto @endif"
                                style="@if(count($socials) > 1) height:315px; @endif">
                                @foreach (array_reverse($socials, true) as $index => $social)
                                    <div class="py-1">
                                        <div class="card shadow-sm">
                                            <div class="card-header d-flex justify-content-between bg-light">
                                                <div>
                                                    <p class="fs-6 fw-bold bg-dark px-2 text-light rounded-5 shadow-sm mt-1 mb-0 mx-0 py-0">{{ $index + 1 }}</p>
                                                </div>
                                                <div>
                                                    <button class="btn btn-outline-danger btn-sm shadow-sm" wire:click.prevent="removeSocials({{ $index }})">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                    
                                            <div class="card-body bg-light">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <label for="socials.{{ $index}}.name" class="form-label fw-bold">Social Media Name</label>
                                                        <input type="text" class="form-control @error('socials.'.$index.'.name') is-invalid  @enderror
                                                        @if("socials.{{ $index }}.name") '' @endif"
                                                        id="socials.{{ $index }}.name" placeholder="Social Media Name"
                                                        wire:model.live.debounce.500ms="socials.{{ $index }}.name">
                                                        @error('socials.'.$index.'.name') 
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                    
                                                    <div class="col-lg-6">
                                                        <label for="social.{{ $index}}.link" class="form-label fw-bold">Social Media Link</label>
                                                        <input type="text" class="form-control @error('socials.'.$index.'.link') is-invalid  @enderror
                                                        @if("socials.{{ $index }}.link") '' @endif"
                                                        id="socials.{{ $index }}.link" placeholder="Social Media Link"
                                                        wire:model.live.debounce.500ms="socials.{{ $index }}.link">
                                                        @error('socials.'.$index.'.link') 
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div> 
                                @endforeach
                            </div>                         
                        @endif
                    </div>
                </div>
                
            </div>
        </div>

        <div class="pt-3">
            <button type="submit" class="btn btn-outline-success shadow-sm">
                <i class="fa-solid fa-check"></i> Confirm
            </button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary shadow-sm">
                Cancel
            </a>
        </div> 
    </form>  
</div>
