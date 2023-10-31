<div id="carouselSliders" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
      @foreach ($sliders as $slider)
        <button type="button" data-bs-target="#carouselSliders" data-bs-slide-to="{{ $loop->index }}" class="@if($loop->index == 0) active @endif" aria-current="@if($loop->index == 0) true @endif" aria-label="Slide {{ $loop->iteration }}"></button>
      @endforeach
    </div>
    <div class="carousel-inner">
      @foreach ($sliders as $slider)
      @if($slider->status == '1')
        <div class="carousel-item @if($loop->index == 0) active @endif" data-bs-interval="3000">
        @if (filter_var($slider->image, FILTER_VALIDATE_URL))
                                    <img src="{{ $slider->image }}" alt="{{ $slider->title }}" class="d-block w-100 carousel-slider">
                                    @else
                                    <img src="{{ asset('storage/'.$slider->image)}}" alt="{{ $slider->title }}" class="d-block w-100 carousel-slider">
                                    @endif
         
          <div class="carousel-caption d-none d-md-block">
            <div class="text-start">
              <h5>{{ $slider->title }}</h5>
              <p>{{ $slider->description }}</p>
            </div>
          </div>
        </div>
      @endif
      @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselSliders" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselSliders" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
</div>
