<div>
    <h1>
        <a href="{{ route('admin.categories') }}" class="link-dark breadcrumbs">Categories</a> /
        <a href="" class="breadcrumbs link-secondary">Edit</a>
    </h1>

    <div class="card shadow-sm">
        <div class="card-header py-3 bg-dark">
            <h3 class="m-0 font-weight-bold text-light">Edit Information for {{ $name_title }}</h3>
        </div>
        <div class="card-body bg-light">
            <form class="row g-3 justify-content" wire:submit="editCategory">
                @csrf
                <div class="col-md-6">
                    <label for="name" class="form-label fw-bold">Category Name</label>
                    <input type="text" class="form-control @error('name_edit') is-invalid  @enderror
                    @if($name_edit) '' @endif"
                    id="name" placeholder="Category Name"
                    wire:model.live.debounce.500ms="name_edit">
                    @error('name_edit') 
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="slug" class="form-label fw-bold">Slug</label>
                    <input type="text" class="form-control @error('slug_edit') is-invalid  @enderror
                    @if($slug_edit) '' @endif"
                    id="slug" placeholder="Slug"
                    wire:model.live.debounce.500ms="slug_edit">
                    @error('slug_edit') 
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-12">
                    <label for="description" class="form-label fw-bold">Description</label>
                    <textarea class="form-control @error('description_edit') is-invalid  @enderror
                    @if($description_edit) '' @endif" 
                    name="description" id="description" rows="2" placeholder="Description"
                    wire:model.live.debounce.500ms="description_edit"></textarea>
                    @error('description_edit') 
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label for="image" class="form-label fw-bold">Image</label>
                    <input class="form-control @error('image_edit') is-invalid  @enderror
                    @if($image_edit) '' @endif"
                    type="file" id="image"
                    wire:model.live="image_edit" accept="image/*">     
                    @error('image_edit') 
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                    
                    @if ($image_edit)
                        @if(!$image_edit->isPreviewable())
                        @else
                        <img src="{{ $image_edit->temporaryUrl()}}" alt="Category Image" class="pt-3 img-fluid" width="300"/>
                        @endif
                    @elseif ($category->image)
                        <img src="{{ asset('storage/' .$category->image) }}" alt="Category Image" class="pt-3 image-fluid" width="300" >
                    @else 
                        <img src="{{ asset('images/no-photo.svg')}}" alt="No Image" class="pt-3 image-fluid" width="300">  
                    @endif
                </div>
                
                <div class="col-md-6">
                    <label for="status" class="form-label fw-bold" >
                        Status
                    </label>
                    <select name="status" id="status" class="form-select" aria-placeholder="Select Status"
                    wire:model.live.debounce.500ms="status_edit">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    @error('status_edit') 
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                
                <div>
                    <hr>
                </div>
                
                <h4 class="my-0 pb-2">SEO Tags</h4>
                
                <div class="col-md-12 my-0">
                    <label for="meta_name" class="form-label fw-bold">Meta Name</label>
                    <input type="text" class="form-control @error('meta_name_edit') is-invalid  @enderror
                    @if($meta_name_edit) '' @endif"
                    id="meta_name" placeholder="Meta Name"
                    wire:model.live.debounce.500ms="meta_name_edit">
                    @error('meta_name_edit') 
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="col-md-12">
                    <label for="meta_keyword" class="form-label fw-bold">Meta Keyword</label>
                    <textarea class="form-control @error('meta_keyword_edit') is-invalid  @enderror
                    @if($meta_keyword_edit) '' @endif" 
                    name="meta_keyword" id="meta_keyword" rows="2" placeholder="Meta Keyword"
                    wire:model.live.debounce.500ms="meta_keyword_edit"></textarea>
                    @error('meta_keyword_edit') 
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="col-md-12">
                    <label for="meta_description" class="form-label fw-bold">Meta Description</label>
                    <textarea class="form-control @error('meta_description_edit') is-invalid  @enderror
                    @if($meta_description_edit) '' @endif"
                    name="meta_description" id="meta_description" rows="2" placeholder="Meta Description"
                    wire:model.live.debounce.500ms="meta_description_edit"></textarea>
                    @error('meta_description_edit') 
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <div class="col-md-12 pt-3">
                    <button type="submit" class="btn btn-outline-warning shadow-sm">
                        <i class="fa-solid fa-edit"></i> Edit
                    </button>
                    <a href="{{ route('admin.categories') }}" class="btn btn-outline-secondary shadow-sm">
                        Cancel
                    </a>
                </div>
            </form> 
        </div>
    </div>
</div>
