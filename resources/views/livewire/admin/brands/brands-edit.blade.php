<div>
    <h1>
        <a href="{{ route('admin.brands') }}" class="link-dark breadcrumbs">Brands</a> /
        <a href="" class="breadcrumbs link-secondary">Edit</a>
    </h1>

    <div class="card shadow-sm">
        <div class="card-header py-3 bg-dark">
            <h3 class="m-0 font-weight-bold text-light">Edit information for {{ $brand->name }}</h3>
        </div>
        <div class="card-body bg-light">
            <form class="row g-3 justify-content" wire:submit="editBrand">
                @csrf
                <div class="col-md-4">
                    <label for="name" class="form-label fw-bold">Brand Name</label>
                    <input type="text" class="form-control @error('name') is-invalid  @enderror
                    @if($name) '' @endif"
                    id="name" placeholder="Brand Name"
                    wire:model.live.debounce.500ms="name">
                    @error('name') 
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-4">
                    <label for="slug" class="form-label fw-bold">Slug</label>
                    <input type="text" class="form-control @error('slug') is-invalid  @enderror
                    @if($slug) '' @endif"
                    id="slug" placeholder="Slug"
                    wire:model.live.debounce.500ms="slug">
                    @error('slug') 
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="col-md-4">
                    <label for="category" class="form-label fw-bold" >
                        Category
                    </label>
            
                    <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" aria-placeholder="Select Category" wire:model.live.debounce.500ms="category_id">
                        <option>Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
            
                    @error('category_id') 
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label for="image" class="form-label fw-bold">Image</label>
                    <input class="form-control @error('image') is-invalid  @enderror
                    @if($image) '' @endif"
                    type="file" id="image"
                    wire:model.live="image" accept="image/*">     
                    @error('image') 
                    <small class="text-danger">{{ $message }}</small>
                    @enderror

                    @if($image)
                        @if(!$image->isPreviewable())
                        @else 
                        <img src="{{ $image->temporaryUrl()}}" alt="Brand Image" class="pt-3 img-fluid" width="300"/>
                        @endif
                    @elseif ($brand->image)
                        <img src="{{ asset('storage/' .$brand->image) }}" alt="Brand Image" class="pt-3 image-fluid" width="300" >
                    @else 
                        <img src="{{ asset('images/no-photo.svg')}}" alt="No Image" class="pt-3 image-fluid" width="300">  
                    @endif
                </div>
                
                <div class="col-md-6">
                    <label for="status" class="form-label fw-bold" >
                        Status
                    </label>
                    <select name="status" id="status" class="form-select" aria-placeholder="Select Status" wire:model.live.debounce.500ms="status">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    @error('status') 
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="col-md-12 pt-3">
                    <button type="submit" class="btn btn-outline-warning shadow-sm">
                        <i class="fa-solid fa-edit"></i> Edit
                    </button>
                    <a href="{{ route('admin.brands') }}" class="btn btn-outline-secondary shadow-sm">
                        Cancel
                    </a>
                </div>
            </form> 
        </div>
    </div>
</div>
