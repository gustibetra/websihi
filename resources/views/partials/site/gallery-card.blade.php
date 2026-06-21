<div class="rbt-card variation-02 rbt-hover h-100">
    <div class="rbt-card-img" style="height: 180px; overflow: hidden; position: relative;">
        @if($gal->category)
            <span class="rbt-badge-card position-absolute top-0 start-0 m-3" >
                {{ $gal->category->data1 }}
            </span>
        @endif

        @if($gal->images->count() > 1)
            <!-- Slideshow for multiple images -->
            <div id="carousel-{{ $gal->id }}" class="carousel slide h-100" data-bs-ride="carousel" data-bs-interval="3000">
                <div class="carousel-inner h-100">
                    @foreach($gal->images as $index => $img)
                        <div class="carousel-item h-100 {{ $index === 0 ? 'active' : '' }}">
                            <a href="{{ route('gallery.show', $gal->slug) }}" class="d-block h-100 w-100">
                                <img src="{{ asset('storage/' . $img->image_path) }}" alt="{{ $gal->title }}" style="width: 100%; height: 100%; object-fit: cover;">
                            </a>
                        </div>
                    @endforeach
                </div>
                <!-- Premium Hover Arrows -->
                <button class="carousel-control-prev gallery-carousel-control" type="button" data-bs-target="#carousel-{{ $gal->id }}" data-bs-slide="prev" style="width: 30px; opacity: 0; transition: opacity 0.3s; background: rgba(0,0,0,0.3); height: 40px; top: calc(50% - 20px); border-radius: 0 4px 4px 0; border: none;">
                    <span class="carousel-control-prev-icon" aria-hidden="true" style="width: 12px; height: 12px;"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next gallery-carousel-control" type="button" data-bs-target="#carousel-{{ $gal->id }}" data-bs-slide="next" style="width: 30px; opacity: 0; transition: opacity 0.3s; background: rgba(0,0,0,0.3); height: 40px; top: calc(50% - 20px); border-radius: 4px 0 0 4px; border: none;">
                    <span class="carousel-control-next-icon" aria-hidden="true" style="width: 12px; height: 12px;"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        @elseif($gal->coverImage)
            <!-- Single Image -->
            <a href="{{ route('gallery.show', $gal->slug) }}" class="d-block h-100 w-100">
                <img src="{{ asset('storage/' . $gal->coverImage->image_path) }}" alt="{{ $gal->title }}" style="width: 100%; height: 100%; object-fit: cover;">
            </a>
        @else
            <!-- Placeholder -->
            <div class="bg-light d-flex align-items-center justify-content-center h-100 w-100">
                <i class="feather-image fs-1 text-muted"></i>
            </div>
        @endif
    </div>
    <div class="rbt-card-body p--15 d-flex flex-column justify-content-between">
        <div>
            <h5 class="rbt-card-title mb--5" style="font-size: 15px; font-weight: 600; line-height: 1.4;">
                <a href="{{ route('gallery.show', $gal->slug) }}" style="color: var(--color-heading); text-decoration: none;">{{ $gal->title }}</a>
            </h5>
        </div>
        <div class="d-flex justify-content-between align-items-center mt--10">
            <span class="rbt-card-text text-muted" style="font-size: 12px;"><i class="feather-image"></i> {{ $gal->images_count ?? $gal->images->count() }} Foto</span>
        </div>
    </div>
</div>
