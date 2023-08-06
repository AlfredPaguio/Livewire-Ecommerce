<div>
    @if(session()->has('success'))
        <div wire:poll.3s="hide" class="alert alert-success" role="alert" :wire:key="concat('admin.categories', hide)">
            {{ session('success') }}
        </div>
    @endif

    <h1>Categories</h1>

    <div class="card shadow-sm">
        <div class="card-header py-3 bg-light">
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.categories.add') }}" class="btn btn-outline-success shadow-sm">
                    <i class="fa-solid fa-plus"></i> Add
                </a>

                <input type="text" 
                class="form-control w-50 shadow-sm" 
                placeholder="Search categories..."
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
                            <th scope="col">Description</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                        <tr>
                           
                            <th scope="row">{{ $category->id }}</th>
                            <td>
                                <livewire:components.image-view image="{{ $category->image }}" alt="{{ $category->name }} Image" wire:key='{{ $category->id }}'/>
                            </td>
                            <td>{{ $category->name }}</td>
                            
                            <td>{{ $category->slug }}</td>
                            <td class="w-50">
                                <p>{{ $category->description }}</p>
                            </td>
                            
                            <td>
                                <div class="@if($category->status == '1') bg-success @else bg-danger @endif rounded px-2 py-1 text-center text-white">
                                    <span> {{ $category->status == '1' ? 'Active':'Inactive'}}</span>
                                </div>
                            </td>
                            <td>
                                <livewire:admin.categories.categories-delete :deleteCategory="$category" key="{{  now() }}"/>

                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('admin.categories.edit', ['slug' => $category->slug, 'id' => $category->id ])}}" class="btn btn-outline-warning shadow-sm">
                                        <i class="fa-solid fa-edit"></i>
                                    </a>

                                    <button type="button" class="btn btn-outline-danger shadow-sm" data-bs-toggle="modal" data-bs-target="#deleteCategory-{{ $category->id }}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        
                        
                        @endforeach
                    </tbody>
                </table>

                {{ $categories->links()}}
            </div>

            @if($categories->isEmpty())
                <div class="alert alert-danger" role="alert">
                    No records found...
                </div>
            @endif
        </div>
    </div>
</div>