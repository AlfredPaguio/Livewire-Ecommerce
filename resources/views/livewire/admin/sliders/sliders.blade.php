<div>
    @if(session()->has('success'))
        <div wire:poll.3s="hide" class="alert alert-success" role="alert" :wire:key="concat('admin.sliders', hide)">
            {{ session('success') }}
        </div>
    @endif

    <h1>
        <a href="{{ route('admin.sliders') }}" class="link-dark breadcrumbs">Sliders</a>
    </h1>

    <div class="card shadow-sm">
        <div class="card-header py-3 bg-light">
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.sliders.add') }}" class="btn btn-outline-success shadow-sm">
                    <i class="fa-solid fa-plus"></i> Add
                </a>

                <input type="text" 
                class="form-control w-50 shadow-sm" 
                placeholder="Search sliders..."
                wire:model.live.debounce.500ms="search"
                :wire:key="concat('admin.sliders', $search)">
            </div>

        </div>
        <div class="card-body bg-light">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-dark text-center">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">Image</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sliders as $slider)
                            <tr class="">
                            
                                <th scope="row">{{ $slider->id }}</th>
                                <td>{{ $slider->title }}</td>
                                <td class="w-50">
                                    <p>{{ $slider->description }}</p>
                                </td>
                                <td>
                                    <livewire:components.image-view image='{{ $slider->image }}' alt='{{ $slider->title }} Image' className="image-fluid" width="150" wire:key='{{ $slider->id }}'>
                                </td>
                                <td>
                                    <div class="@if($slider->status == '1') bg-success @else bg-danger @endif rounded px-2 py-1 text-center text-white">
                                        <span> {{ $slider->status == '1' ? 'Active':'Inactive'}}</span>
                                    </div>
                                </td>
                                <td>
                                    <livewire:admin.sliders.sliders-delete :deleteSlider="$slider" key="{{  now() }}"/>

                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('admin.sliders.edit', ['id' => $slider->id ])}}" class="btn btn-outline-warning shadow-sm">
                                            <i class="fa-solid fa-edit"></i>
                                        </a>

                                        <button type="button" class="btn btn-outline-danger shadow-sm" data-bs-toggle="modal" data-bs-target="#deleteSlider-{{ $slider->id }}">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $sliders->links()}}
            </div>

            @if($sliders->isEmpty())
                <div class="alert alert-danger" role="alert">
                    No records found...
                </div>
            @endif
        </div>
    </div>
</div>
