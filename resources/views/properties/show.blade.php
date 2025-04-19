@extends('layouts.app')

@section('title', $property->title . ' - Egeden Emlak')

@section('content')
<div class="container">
    <div class="property-details">
        <div class="property-images">
            <div class="slider-container">
                <div class="main-slider">
                    @forelse($property->images as $image)
                        <div class="slide">
                            <img src="{{ $image->image_url }}" alt="Property Image">
                        </div>
                    @empty
                        <div class="slide no-image">
                            <div class="no-image-content">
                                <i class="fas fa-image"></i>
                                <p>No images available</p>
                            </div>
                        </div>
                    @endforelse
                </div>
                
                @if($property->images->count() > 1)
                    <div class="slider-controls">
                        <button class="slider-control prev" onclick="moveSlide(-1)">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="slider-control next" onclick="moveSlide(1)">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                    
                    <div class="slider-dots">
                        @foreach($property->images as $index => $image)
                            <button class="slider-dot {{ $index === 0 ? 'active' : '' }}" 
                                    onclick="goToSlide({{ $index }})"
                                    aria-label="Go to slide {{ $index + 1 }}">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="property-info">
            <h1>{{ $property->title }}</h1>
            <div class="property-meta">
                <span class="price">${{ number_format($property->price, 2) }}</span>
                <span class="type">{{ $property->propertyType->name }}</span>
                <span class="status">{{ $property->propertyStatus->name }}</span>
            </div>
            <div class="property-details-grid">
                <div class="detail-item">
                    <i class="fas fa-ruler-combined"></i>
                    <span>{{ $property->area }} m²</span>
                </div>
                <div class="detail-item">
                    <i class="fas fa-bed"></i>
                    <span>{{ $property->bedrooms }} Bedrooms</span>
                </div>
                <div class="detail-item">
                    <i class="fas fa-bath"></i>
                    <span>{{ $property->bathrooms }} Bathrooms</span>
                </div>
                <div class="detail-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>{{ $property->location }}</span>
                </div>
            </div>
            <div class="property-description">
                <h2>Description</h2>
                <p>{{ $property->description }}</p>
            </div>
            <div class="property-contact">
                <h2>Contact Information</h2>
                <p><i class="fas fa-phone"></i> {{ $property->contact_number }}</p>
            </div>
        </div>
    </div>
</div>

<style>
.property-details {
    max-width: 1200px;
    margin: 2rem auto;
    padding: 0 1rem;
}

.property-images {
    margin-bottom: 2rem;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.slider-container {
    position: relative;
    width: 100%;
    height: 500px;
    overflow: hidden;
}

.main-slider {
    display: flex;
    transition: transform 0.5s ease-in-out;
    height: 100%;
}

.slide {
    min-width: 100%;
    height: 100%;
    position: relative;
}

.slide img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.no-image {
    background: var(--light-gray);
    display: flex;
    align-items: center;
    justify-content: center;
}

.no-image-content {
    text-align: center;
    color: var(--dark-gray);
}

.no-image-content i {
    font-size: 4rem;
    margin-bottom: 1rem;
}

.slider-controls {
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    transform: translateY(-50%);
    display: flex;
    justify-content: space-between;
    padding: 0 1rem;
    pointer-events: none;
}

.slider-control {
    background: rgba(255, 255, 255, 0.9);
    border: none;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.3s ease;
    pointer-events: auto;
}

.slider-control:hover {
    background: white;
    transform: scale(1.1);
}

.slider-control i {
    color: var(--primary-color);
    font-size: 1.2rem;
}

.slider-dots {
    position: absolute;
    bottom: 1rem;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 0.5rem;
}

.slider-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.5);
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

.slider-dot.active {
    background: white;
    transform: scale(1.2);
}

.property-info {
    background: white;
    padding: 2rem;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.property-meta {
    display: flex;
    gap: 1rem;
    margin: 1rem 0;
    align-items: center;
}

.price {
    font-size: 1.5rem;
    font-weight: bold;
    color: var(--primary-color);
}

.type, .status {
    padding: 0.5rem 1rem;
    border-radius: 4px;
    background: var(--light-gray);
    color: var(--dark-gray);
}

.property-details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin: 2rem 0;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem;
    background: var(--light-gray);
    border-radius: 4px;
}

.detail-item i {
    color: var(--primary-color);
}

.property-description, .property-contact {
    margin-top: 2rem;
}

.property-description h2, .property-contact h2 {
    color: var(--dark-gray);
    margin-bottom: 1rem;
}

@media (max-width: 768px) {
    .slider-container {
        height: 300px;
    }

    .property-meta {
        flex-direction: column;
        align-items: flex-start;
    }

    .property-details-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
let currentSlide = 0;
const slides = document.querySelectorAll('.slide');
const dots = document.querySelectorAll('.slider-dot');
const slider = document.querySelector('.main-slider');

function updateSlider() {
    slider.style.transform = `translateX(-${currentSlide * 100}%)`;
    dots.forEach((dot, index) => {
        dot.classList.toggle('active', index === currentSlide);
    });
}

function moveSlide(direction) {
    currentSlide = (currentSlide + direction + slides.length) % slides.length;
    updateSlider();
}

function goToSlide(index) {
    currentSlide = index;
    updateSlider();
}

// Auto-advance slides every 3 seconds
let slideInterval = setInterval(() => {
    if (slides.length > 1) {
        moveSlide(1);
    }
}, 3000);

// Pause auto-advance when hovering over the slider
slider.addEventListener('mouseenter', () => {
    clearInterval(slideInterval);
});

slider.addEventListener('mouseleave', () => {
    slideInterval = setInterval(() => {
        if (slides.length > 1) {
            moveSlide(1);
        }
    }, 3000);
});
</script>
@endsection 