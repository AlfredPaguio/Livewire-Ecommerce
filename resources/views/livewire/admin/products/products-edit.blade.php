<div>
    <h1>
        <a href="{{ route('admin.products') }}" class="link-dark breadcrumbs">Products</a> /
        <a href="" class="breadcrumbs link-secondary">Edit</a>
    </h1>

    <div class="card shadow-sm">
        <div class="card-header py-3 bg-dark">
            <h3 class="m-0 font-weight-bold text-light">
                Edit information for {{ $product->name }}
            </h3>
        </div>
        
        <div class="card-body bg-light">
            @if(session()->has('success'))
                <div wire:poll.3s="hide" class="alert alert-success" role="alert" :wire:key="concat('admin.products-add', hide)">
                    {{ session('success') }}
                </div>
            @endif
           
            @if(session()->has('danger'))
                <div wire:poll.3s="hide" class="alert alert-danger" role="alert" :wire:key="concat('admin.products-add', hide)">
                    {{ session('danger') }}
                </div>
            @endif
            
            @if($errors->any())
                <div wire:poll.3s="hide" class="alert alert-danger" role="alert" :wire:key="concat('admin.products-add', hide)">
                    Errors found. Please check and fill the forms in all tabs .
                </div>
            @endif

            <form wire:submit="editProduct">
                @csrf
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                      <button class="nav-link @if($tab == 'products') active bg-dark text-light link-light @else link-dark @endif" id="nav-product-tab" data-bs-toggle="tab" data-bs-target="#nav-product" type="button" role="tab" aria-controls="nav-product" aria-selected="@if($tab == 'products') true @else false @endif" wire:click="$set('tab', 'products')">Product</button>
                      <button class="nav-link @if($tab == 'stocks') active bg-dark text-light link-light @else link-dark @endif" id="nav-stocks-tab" data-bs-toggle="tab" data-bs-target="#nav-stocks" type="button" role="tab" aria-controls="nav-stocks" aria-selected="@if($tab == 'stocks') true @else false @endif" wire:click="$set('tab', 'stocks')">Stocks</button>
                      <button class="nav-link @if($tab == 'images') active bg-dark text-light link-light @else link-dark @endif" id="nav-images-tab" data-bs-toggle="tab" data-bs-target="#nav-images" type="button" role="tab" aria-controls="nav-images" aria-selected="@if($tab == 'images') true @else false @endif" wire:click="$set('tab', 'images')">Images</button>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade @if($tab == 'products') show active @endif" id="nav-product" role="tabpanel" aria-labelledby="nav-product-tab" tabindex="0">
                        <div class="row g-3 pt-3">    
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-bold">Product Name</label>
                                <input type="text" class="form-control @error('name') is-invalid  @enderror
                                @if($name) '' @endif"
                                id="name" placeholder="Product Name"
                                wire:model.live.debounce.500ms="name">
                                @error('name') 
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        
                            <div class="col-md-6">
                                <label for="slug" class="form-label fw-bold">Slug</label>
                                <input type="text" class="form-control @error('slug') is-invalid  @enderror
                                @if($slug) '' @endif"
                                id="slug" placeholder="Product Name"
                                wire:model.live.debounce.500ms="slug">
                                @error('slug') 
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        
                            <div class="col-md-6">
                                <label for="category" class="form-label fw-bold" >
                                    Category
                                </label>
                        
                                <select name="category" id="category" class="form-select @error('category') is-invalid @enderror" aria-placeholder="Select Category" wire:model.live="category" wire:change="matchBrands">
                                    <option value="-1">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                        
                                @error('category') 
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        
                            <div class="col-md-6">
                                <label for="brand" class="form-label fw-bold" >
                                    Brand
                                </label>
                        
                                <div wire:loading wire:target="category">
                                    Loading...
                                </div>

                                <select name="brand" id="brand" class="form-select @error('brand') is-invalid @enderror" aria-placeholder="Select Status" wire:model.live="brand">
                                    <option value="-1">Select Brand</option>
                                    @foreach ($brands as $brand)
                                        <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                    @endforeach
                                </select>
                        
                                @error('brand') 
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        
                            <div class="col-md-12">
                                <label for="description" class="form-label fw-bold">Description</label>
                                <textarea class="form-control @error('description') is-invalid  @enderror
                                @if($description) '' @endif" 
                                name="description" id="description" rows="2" placeholder="Description"
                                wire:model.live.debounce.500ms="description"></textarea>
                        
                                @error('description') 
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        
                            <div class="col-md-6">
                                <label for="status" class="form-label fw-bold" >
                                    Status
                                </label>
                        
                                <select name="status" id="status" class="form-select" aria-placeholder="Select Category" wire:model.live.debounce.500ms="status">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        
                            <div class="col-md-6">
                                <label for="featured" class="form-label fw-bold" >
                                    Featured
                                </label>
                        
                                <select name="featured" id="featured" class="form-select" aria-placeholder="Select Category" wire:model.live.debounce.500ms="featured">
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
                                </select>
                            </div>
                        
                            <div>
                                <hr>
                            </div>
                            
                            <h4 class="my-0 pb-2">SEO Tags</h4>
                            
                            <div class="col-md-12 my-0">
                                <label for="meta_name" class="form-label fw-bold">Meta Name</label>
                                <input type="text" class="form-control @error('meta_name') is-invalid  @enderror
                                @if($meta_name) '' @endif"
                                id="meta_name" placeholder="Meta Name"
                                wire:model.live.debounce.500ms="meta_name">
                                @error('meta_name') 
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="col-md-12">
                                <label for="meta_keyword" class="form-label fw-bold">Meta Keyword</label>
                                <textarea class="form-control @error('meta_keyword') is-invalid  @enderror
                                @if($meta_keyword) '' @endif" 
                                name="meta_keyword" id="meta_keyword" rows="2" placeholder="Meta Keyword"
                                wire:model.live.debounce.500ms="meta_keyword"></textarea>
                                @error('meta_keyword') 
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="col-md-12">
                                <label for="meta_description" class="form-label fw-bold">Meta Description</label>
                                <textarea class="form-control @error('meta_description') is-invalid  @enderror
                                @if($meta_description) '' @endif"
                                name="meta_description" id="meta_description" rows="2" placeholder="Meta Description"
                                wire:model.live.debounce.500ms="meta_description"></textarea>
                                @error('meta_description') 
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade @if($tab == 'stocks') show active @endif" id="nav-stocks" role="tabpanel" aria-labelledby="nav-stocks-tab" tabindex="0">
                        <div>
                            <div class="d-flex justify-content-start pt-3 gap-2">
                                <button type="button" class="btn btn-outline-success shadow-sm" wire:click.prevent="addStock">
                                    <i class="fa-solid fa-plus"></i> New
                                </button>
                            </div>
                            
                            <div class="pt-3">
                                @if(!$stocks)
                                    <div class="alert alert-danger">
                                        No stock available
                                    </div>
                                @else
                                @foreach(array_reverse($stocks, true) as $index => $stock)
                                    <div class="py-2">
                                        <div class="card">
                                            <div class="card-header">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <p class="fs-5 fw-bold bg-dark px-3 text-light rounded-5 shadow-sm">{{ $index + 1 }}</p>
                                                    </div>

                                                    <div>
                                                        <button type="button" class="btn btn-outline-danger shadow-sm" wire:click.prevent="removeStock({{$index}})">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </div>    
                                                </div>
                                            </div>
                            
                                            <div class="card-body bg-light">
                                                <div class="row g-3">
                                                    <div class="col-md-4">
                                                        <label for="stock_name{{ $index }}" class="form-label fw-bold">Stock Name</label>
                                                        <input type="text" class="form-control @error('stocks.'.$index.'.name') is-invalid @enderror"
                                                            id="stock_name{{ $index }}" placeholder="Stock Name"
                                                            wire:model.live.debounce.500ms="stocks.{{ $index }}.name">
                                                        @error('stocks.'.$index.'.name') 
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                            
                                                    <div class="col-md-4">
                                                        <label for="quantity{{ $index }}" class="form-label fw-bold">Quantity</label>
                                                        <input type="number" class="form-control @error('stocks.'.$index.'.quantity') is-invalid @enderror"
                                                            id="quantity{{ $index }}" placeholder="Quantity"
                                                            wire:model.live.debounce.500ms="stocks.{{ $index }}.quantity">
                                                        @error('stocks.'.$index.'.quantity') 
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                            
                                                    <div class="col-md-4">
                                                        <label for="status{{ $index }}" class="form-label fw-bold">Status</label>
                                                        <select name="status{{ $index }}" id="status{{ $index }}" 
                                                        class="form-select @error('stocks.'.$index.'.status') is-invalid @enderror"
                                                            aria-placeholder="Select Status"
                                                            wire:model.live.debounce.500ms="stocks.{{ $index }}.status">
                                                            <option value="">Select Status</option>
                                                            <option value="1">Active</option>
                                                            <option value="0">Inactive</option>
                                                        </select>
                                                        @error('stocks.'.$index.'.status') 
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                            
                                                    <div class="col-md-6">
                                                        <label for="original_price{{ $index }}" class="form-label fw-bold">Original Price</label>
                                                        <input type="number" class="form-control @error('stocks.'.$index.'.original_price') is-invalid @enderror"
                                                            id="original_price{{ $index }}" placeholder="Original Price"
                                                            wire:model.live.debounce.500ms="stocks.{{ $index }}.original_price">
                                                        @error('stocks.'.$index.'.original_price')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                
                                                    <div class="col-md-6">
                                                        <label for="selling_price{{ $index }}" class="form-label fw-bold">Selling Price</label>
                                                        <input type="number" class="form-control @error('stocks.'.$index.'.selling_price') is-invalid @enderror"
                                                            id="selling_price{{ $index }}" placeholder="Selling Price"
                                                            wire:model.live.debounce.500ms="stocks.{{ $index }}.selling_price">
                                                        @error('stocks.'.$index.'.selling_price')
                                                            <small class="text-danger">{{ $message }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                  
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade @if($tab == 'images') show active @endif" id="nav-images" role="tabpanel" aria-labelledby="nav-images-tab" tabindex="0">
                        <div class="row g-3 d-flex justify-content-center pt-3">
                            <div class="col-md-6">
                                <label for="images_edit" class="form-label fw-bold">Product Images</label>
                                <input class="form-control @error('images_edit') is-invalid  @enderror
                                @if($images_edit) '' @endif"
                                type="file" id="images_edit"
                                wire:model.live="images_edit" accept="image/*" multiple> 
                        
                                @error('images_edit') 
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        
                            @if(!$images && !$images_edit)
                                <div class="col-md-12">
                                    <div class="alert alert-danger">
                                        No image available
                                    </div>
                                </div>
                            @endif
                        
                            @if($images || $images_edit)
                            <div class="row d-flex justify-content-center gap-3 pt-3">
                                @foreach($images_edit as $index => $image)
                                    @if(!$image->isPreviewable())
                                        <div class="col-md-3 card shadow-sm bg-light text-center border border-danger">
                                            <img src="{{ asset( 'images/wrong.svg') }}" class="pt-3 img-fluid"/>
                                            <small> This type of file is not supported </small>
                                            <div class="py-2 px-auto">
                                                <button class="btn btn-danger btn-sm shadow-sm" wire:click.prevent="removeImageEdit({{ $index }})">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-md-3 card shadow-sm bg-light text-center">
                                            <img src="{{ $image->temporaryUrl() }}" class="pt-3 img-fluid"/>
                                            <div class="py-2 px-auto">
                                                <button class="btn btn-danger btn-sm shadow-sm" wire:click.prevent="removeImageEdit({{ $index }})">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endif
                                    
                                @endforeach

                                @foreach($images as $index => $image)
                                    <div class="col-md-3 card shadow-sm bg-light text-center">
                                        @if (filter_var($category->image, FILTER_VALIDATE_URL))
                                        <img src="{{ $image['filename'] }}" class="pt-3 img-fluid"/>
                                        @else
                                        <img src="{{ asset('storage/'.$image['filename']) }}" class="pt-3 img-fluid"/>
                                        @endif
                                        <div class="py-2 px-auto">
                                            <button class="btn btn-danger btn-sm shadow-sm" wire:click.prevent="removeImage({{ $index }})">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @endif
                        </div>  
                    </div>
                </div>

                <div class="col-md-12 pt-3">
                    <button type="submit" class="btn btn-outline-warning shadow-sm">
                        <i class="fa-solid fa-edit"></i> Edit
                    </button>
                    <a href="{{ route('admin.products') }}" class="btn btn-outline-secondary shadow-sm">
                        Cancel
                    </a>
                </div>
            </form> 
        </div>
    </div>
</div>


