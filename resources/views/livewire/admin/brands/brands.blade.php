<div>
    @if(session()->has('success'))
        <div wire:poll.3s="hide" class="alert alert-success" role="alert" :wire:key="concat('admin.categories', hide)">
            {{ session('success') }}
        </div>
    @endif

    <h1>
        <a href="{{ route('admin.brands') }}" class="link-dark breadcrumbs">Brands</a>
    </h1>

    <div class="card shadow-sm">
        <div class="card-header py-3 bg-light">
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.brands.add') }}" class="btn btn-outline-success shadow-sm">
                    <i class="fa-solid fa-plus"></i> Add
                </a>

                <input type="text" 
                class="form-control w-50 shadow-sm" 
                placeholder="Search brands..."
                wire:model.live.debounce.500ms="search"
                :wire:key="concat('admin.categories', $search)">
            </div>

        </div>
        <div class="card-body bg-light">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark text-center">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Image</th>
                            <th scope="col">Name</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Category</th>
                            <th scope="col">Description</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                        @foreach ($brands as $brand)
                        <tr wire:key="{{  $brand->id }}">
                           
                            <th scope="row">{{ $brand->id }}</th>
                            <td>
                                <livewire:components.image-view image="{{ $brand->image }}" alt="{{ $brand->name }} Image" wire:key='{{ $brand->id }}'/>
                            </td>
                            <td>{{ $brand->name }}</td>
                            <td>{{ $brand->slug }}</td>
                            <td>{{ $brand->category->name }}</td>
                            <td class="w-50">
                                <p>{{ $brand->description }}</p>
                            </td>
                            <td>
                                <div class="@if($brand->status == '1') bg-success @else bg-danger @endif rounded px-2 py-1 text-center text-white">
                                    <span> {{ $brand->status == '1' ? 'Active':'Inactive'}}</span>
                                </div>
                            </td>
                            <td>
                                <livewire:admin.brands.brands-delete :deleteBrand="$brand" wire:key="{{  $brand->id }}" />

                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('admin.brands.edit', ['slug' => $brand->slug, 'id' => $brand->id ])}}" class="btn btn-outline-warning shadow-sm">
                                        <i class="fa-solid fa-edit"></i>
                                    </a>

                                    <button type="button" class="btn btn-outline-danger shadow-sm" data-bs-toggle="modal" data-bs-target="#deleteBrand-{{ $brand->id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $brands->links()}}
            </div>

            @if($brands->isEmpty())
                <div class="alert alert-danger" role="alert">
                    No records found...
                </div>
            @endif
        </div>
    </div>
</div>