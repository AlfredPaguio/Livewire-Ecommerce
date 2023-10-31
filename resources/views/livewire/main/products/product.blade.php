@section('title', $product->meta_name)
@section('meta_keywords', $product->meta_keywords)
@section('meta_description', $product->meta_description)

@section('content')
<div class="container-md p-4 p-md-5">
   <h1 class="fw-bold fs-4 pb-3">
      <a href="{{ route('index') }}" class="link-dark breadcrumbs">Home</a> /
      <a href="{{ route('main.categories') }}" class="link-dark breadcrumbs">Categories</a> /
      <a href="{{ route('main.category', ['slug' => $product->category->slug, 'id' => $product->category->id ])}}" class="link-dark breadcrumbs">{{ $product->category->name }}</a>
   </h1>


   <div class="row justify-content-around">
      <div class="col-md-6">
         <div id="carouselExample" class="carousel slide carousel-fade" data-bs-ride="carousel">
            <div class="carousel-indicators">
               @foreach($product->images as $image)
                  <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{ $loop->index }}" @if($loop->first) class="active" aria-current="true" @endif aria-label="Slide {{ $loop->index }}"></button>
               @endforeach
            </div>

            <div class="carousel-inner">
               @foreach($product->images as $image)
                  <div class="carousel-item @if($loop->first) active @endif" data-bs-interval="3000">
                     <div class="card">
                     @if (filter_var($image->filename, FILTER_VALIDATE_URL))
                                    <img src="{{ $image->filename }}" class="d-block w-100" alt="..." height="500">
                                    @else
                                    <img src="{{ asset('storage/'.$image->filename)}}" class="d-block w-100" alt="..." height="500">
                                    @endif
                     </div>
                  </div>
               @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
              <span class="carousel-control-prev-icon bg-dark py-5" aria-hidden="true"></span>
              <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
              <span class="carousel-control-next-icon bg-dark py-5" aria-hidden="true"></span>
              <span class="visually-hidden">Next</span>
            </button>
          </div>
      </div>
      <div class="col-md-6">
         
         <div class="d-flex justify-content-between pt-3">
            <h1 class="fw-bold">
               {{ $product->name }}
            </h1>
   
            <p class="pt-3">
               <span class="px-2 rounded-5 fw-bold @if($product->status == 1) bg-success bg-opacity-75 rounded @else bg-danger bg-opacity-75 rounded @endif">
                  {{ $product->status ? 'Available' : 'Unavaliable' }}
               </span>
            </p>
         </div>

         <hr class="m-0 pb-4">

         <div class="d-flex align-items-end">
            <h6 class="text-warning m-0 p-0">
               <span class="text-dark fs-3">
                  <i class="fa-solid fa-peso-sign"></i>
                  {{ $product->stocks->first()->selling_price }}
               </span> 
            </h6>

            <small class="text-danger mx-2 pb-1 fw-bold">
               <span class="text-dark">P</span>
               <s>{{ $product->stocks->first()->original_price }}</s>
            </small>
         </div>

         <h5 class="text-dark m-0 pt-3 fw-bold">
            Variants
         </h5>
        

         <div class="row pt-1">
            @foreach($stocks as $stock)
               <div class="col-3 p-1">
                     <div class="card bg-body">
                        <input type="radio" class="btn-check" name="stock-choices" id="stock-{{ $stock->id }}" @if($loop->first) checked @endif>

                     <label class="btn btn-outline-dark text-nowrap" for="stock-{{ $stock->id }}">
                        {{ $stock->name }}
                     </label>
                  </div>    
               </div>
            @endforeach
         </div>

         <h5 class="text-dark m-0 pt-3 fw-bold">
            Quantity
         </h5>

         <div class="d-flex justify-content-between pt-2">
            <div class="d-flex justify-content-start">
               <button class="btn btn-outline-dark" wire:click="decrement">
                  <i class="fa-solid fa-minus"></i>
               </button>
   
               <div class="border border-dark rounded px-4 mx-2">
                  <h1 class="fw-bold fs-3 m-0 pt-1" wire:model="quantity">
                     {{ $quantity }}
                  </h1>
               </div>
   
               <button class="btn btn-outline-dark"  wire:click="increment">
                  <i class="fa-solid fa-plus"></i>
               </button>
            </div>

            <div>
               <button class="btn btn-outline-danger">
                  <i class="fa-solid fa-heart"></i>
               </button>
            </div>
         </div>

         <small class="fw-bold"> 
            Stock: 10
         </small>

         <div class="pt-2 pt-lg-5">
            <button class="btn btn-lg btn-outline-danger mt-3 rounded-0 shadow-sm p-md-3">
               <i class="fa-solid fa-shopping-cart"></i> Add to Cart
            </button>

            <button class="btn btn-lg btn-outline-danger mt-3 rounded-0 shadow-sm p-md-3">
               Buy Now
            </button>
         </div>
      </div>

      <div class="col-md-12">
         <div class="pt-5">
            <h1 class="fw-bold fs-3">
               Product Description
            </h1>
         </div>

         <hr class="m-0 pb-4">

         <div class="collapse" id="product_description">
            <div>
               <p class="pt-3">
                  {{ $product->description }}
               </p>
            </div>
         </div>

         <div class="text-center">
            <button class="btn btn-outline-dark" type="button" data-bs-toggle="collapse" data-bs-target="#product_description" aria-expanded="false" aria-controls="product_description">
               Load Description...
            </button>
          </div>
      </div>
   </div>
</div>

@endsection