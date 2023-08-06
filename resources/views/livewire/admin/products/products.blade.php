<div>
   @if(session()->has('success'))
       <div wire:poll.3s="hide" class="alert alert-success" role="alert" :wire:key="concat('admin.products.hide)">
           {{ session('success') }}
       </div>
   @endif

   @if(session()->has('danger'))
       <div wire:poll.3s="hide" class="alert alert-danger" role="alert" :wire:key="concat('admin.products.hide)">
           {{ session('danger') }}
       </div>
   @endif

   <h1>
        <a href="{{ route('admin.products') }}" class="link-dark breadcrumbs">Products</a>
   </h1>

   <div class="card shadow-sm">
       <div class="card-header py-3 bg-light">
           <div class="d-flex justify-content-between">
               <a href="{{ route('admin.products.add') }}" class="btn btn-outline-success shadow-sm">
                   <i class="fa-solid fa-plus"></i> Add
               </a>

               <input type="text" 
               class="form-control w-50 shadow-sm" 
               placeholder="Search products..."
               wire:model.live.debounce.500ms="search"
               :wire:key="concat('admin.products', $search)">
           </div>

       </div>
       <div class="card-body bg-light">
           <div class="table-responsive">
               <table class="table table-hover">
                   <thead class="table-dark text-center">
                       <tr>
                           <th scope="col">ID</th>
                           <th scope="col">Images</th>
                           <th scope="col">Name</th>
                           <th scope="col">Slug</th>
                           <th scope="col">Description</th>
                           <th scope="col">Total Stocks</th>
                           <th scope="col">is Featured?</th>
                           <th scope="col">Brand</th>
                           <th scope="col">Category</th>
                           <th scope="col">Status</th>
                           <th scope="col">Actions</th>
                       </tr>
                   </thead>
                   <tbody>
                    @foreach ($products as $product)
                    <tr wire:key="{{  $product->id }}">
                           
                        <th scope="row">{{ $product->id }}</th>
                        <td>
                            @if ($product->images->count() > 0)
                            <div id="productImageCarousel{{  $product->id }}" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                @foreach ($product->images as $image)
                                  <div class="carousel-item {{ $loop->first ? 'active' : '' }}" data-bs-interval="3000">
                                    @if (filter_var($image->filename, FILTER_VALIDATE_URL))
                                    <img src="{{ $image->filename }}" alt="Product Image" class="image-fluid fixed-size-sm" key="{{ $image->id }}">
                                    @else
                                    <img src="{{ asset('storage/' . $image->filename) }}" alt="Product Image" class="image-fluid fixed-size-sm" key="{{ $image->id }}">
                                    @endif
                                </div>
                                @endforeach
                                </div>
                                
                                @if($product->images->count() > 1)
                                    <button class="carousel-control-prev" type="button" data-bs-target="#productImageCarousel{{  $product->id }}" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#productImageCarousel{{  $product->id }}" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                    </button>
                                @endif
                              </div>
                            @else
                                <img src="{{ asset('images/no-photo.svg')}}" alt="No Image" class="image-fluid fixed-size-sm">  
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->slug }}</td>
                        <td class="w-50">
                            <p>{{ $product->description }}</p>
                        </td>
                        <td>{{ $product->stocks->sum('quantity') }}</td>
                       
                        <td>
                            <div class="@if($product->featured == '1') bg-success @else bg-danger @endif rounded px-2 py-1 text-center text-white">
                                <span> {{ $product->featured == '1' ? 'Yes':'No'}}</span>
                            </div>
                        </td>
                        
                        <td>{{ $product->brand->name }}</td>
                        <td>{{ $product->category->name }}</td>
                        <td>
                            <div class="@if($product->status == '1') bg-success @else bg-danger @endif rounded px-2 py-1 text-center text-white">
                                <span> {{ $product->status == '1' ? 'Active':'Inactive'}}</span>
                            </div>
                        </td>
                        <td>
                            <livewire:admin.products.products-delete :deleteProduct="$product" wire:key="{{  $product->id }}"/>

                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('admin.products.edit', ['slug' => $product->slug, 'id' => $product->id ])}}" class="btn btn-outline-warning shadow-sm">
                                        <i class="fa-solid fa-edit"></i>
                                    </a>

                                    <button type="button" class="btn btn-outline-danger shadow-sm" data-bs-toggle="modal" data-bs-target="#deleteProduct-{{ $product->id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                   </tbody>
               </table>

               {{ $products->links()}}
           </div>

           @if($products->isEmpty())
               <div class="alert alert-danger" role="alert">
                   No records found...
               </div>
           @endif
       </div>
   </div>
</div>
