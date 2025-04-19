@extends('layouts.app')

@section('title', 'Properties - Egeden Emlak')

@section('content')
<div class="hero-slider">
    <div class="slider-container">
        <div class="slider-wrapper">
            @php
                $sliderItems = json_decode(App\Models\SiteSetting::get('hero_slider', '[]'), true);
            @endphp
            
            @foreach($sliderItems as $index => $slide)
                <div class="slide {{ $index === 0 ? 'active' : '' }}">
                    <div class="slide-content">
                        <h2>{{ $slide['title'] }}</h2>
                        <p>{{ $slide['subtitle'] }}</p>
                    </div>
                    @if(isset($slide['image']))
                        <div class="slide-background" style="background-image: url('{{ asset('storage/' . $slide['image']) }}')"></div>
                    @endif
                </div>
            @endforeach
        </div>
        <div class="slider-controls">
            <button class="prev-slide">❮</button>
            <button class="next-slide">❯</button>
        </div>
        <div class="slider-dots"></div>
    </div>
</div>

<div class="container mx-auto px-4 py-8">
    <div class="filter-section">
        <h1 class="section-title">Featured Properties</h1>
        <div class="filter-controls">
            <div class="filter-group">
                <label for="propertyType">Property Type</label>
                <select id="propertyType" class="filter-select">
                    <option value="">All Types</option>
                    @foreach($propertyTypes as $type)
                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <label for="propertyStatus">Status</label>
                <select id="propertyStatus" class="filter-select">
                    <option value="">All Status</option>
                    @foreach($propertyStatuses as $status)
                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                    @endforeach
                </select>
            </div>
            <button class="filter-btn">
                <i class="fas fa-filter"></i>
                Apply Filters
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($properties as $property)
            <div class="property-card">
                <div class="property-image">
                    @if($property->images->isNotEmpty())
                        @php
                            $imageUrl = $property->images->first()->image_url;
                            $imagePath = $property->images->first()->image_path;
                        @endphp
                        <!-- Debug info -->
                        @if(config('app.debug'))
                            <div style="display: none;">
                                Image URL: {{ $imageUrl }}<br>
                                Image Path: {{ $imagePath }}
                            </div>
                        @endif
                        <img src="{{ $imageUrl }}" alt="{{ $property->title }}" loading="lazy">
                    @else
                        <div class="no-image">
                            <i class="fas fa-home"></i>
                            <span>No Image Available</span>
                        </div>
                    @endif
                </div>
                <div class="property-details">
                    <h3 class="property-title">{{ $property->title }}</h3>
                    <div class="property-info">
                        <span class="property-type">{{ $property->propertyType->name }}</span>
                        <span class="property-status">{{ $property->propertyStatus->name }}</span>
                    </div>
                    <div class="property-features">
                        <span class="feature">
                            <i class="fas fa-ruler-combined"></i>
                            {{ $property->area }}m²
                        </span>
                        <span class="feature">
                            <i class="fas fa-bed"></i>
                            {{ $property->bedrooms }} Beds
                        </span>
                        <span class="feature">
                            <i class="fas fa-bath"></i>
                            {{ $property->bathrooms }} Baths
                        </span>
                    </div>
                    <div class="property-location">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ $property->location }}
                    </div>
                    <div class="property-price">
                        ₺{{ number_format($property->price, 0, ',', '.') }}
                    </div>
                    <a href="{{ route('properties.show', $property) }}" class="view-details-btn">
                        <span>View Details</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

    <div class="pagination-wrapper">
        {{ $properties->links() }}
    </div>
</div>

<style>
    .hero-slider {
        position: relative;
        width: 100%;
        height: 500px;
        overflow: hidden;
        margin-bottom: 2rem;
    }

    .slider-container {
        position: relative;
        width: 100%;
        height: 100%;
    }

    .slider-wrapper {
        position: relative;
        width: 100%;
        height: 100%;
    }

    .slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 0.5s ease-in-out;
        border-radius: 20px;
        overflow: hidden;
        margin: 0 20px;
    }

    .slide.active {
        opacity: 1;
    }

    .slide::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.5));
        z-index: 1;
    }

    .slide-content {
        position: relative;
        z-index: 2;
        color: white;
        text-align: center;
        padding: 2rem;
        max-width: 800px;
        margin: 0 auto;
        top: 50%;
        transform: translateY(-50%);
    }

    .slide-content h2 {
        font-size: 3rem;
        font-weight: bold;
        margin-bottom: 1rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .slide-content p {
        font-size: 1.5rem;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
    }

    .slider-controls {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 1rem;
        z-index: 3;
    }

    .slider-controls button {
        background: rgba(255, 255, 255, 0.3);
        border: none;
        color: white;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .slider-controls button:hover {
        background: rgba(255, 255, 255, 0.5);
    }

    .slider-dots {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 0.5rem;
        z-index: 3;
    }

    .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .dot.active {
        background: white;
    }

    .page-header {
        text-align: center;
        margin-bottom: 40px;
    }
    
    .page-title {
        font-size: 32px;
        font-weight: 700;
        color: var(--text-color);
        margin-bottom: 10px;
    }
    
    .page-description {
        font-size: 16px;
        color: #666;
    }
    
    .property-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 30px;
        padding: 20px 0;
    }
    
    .property-card {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .property-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    }
    
    .property-image {
        position: relative;
        width: 100%;
        height: 250px;
        overflow: hidden;
        background-color: #f7fafc;
    }
    
    .property-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    
    .property-card:hover .property-image img {
        transform: scale(1.05);
    }
    
    .property-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background-color: rgba(0, 102, 255, 0.9);
        color: white;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .no-image {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        background-color: #f7fafc;
        color: #a0aec0;
    }
    
    .no-image i {
        font-size: 3rem;
        margin-bottom: 1rem;
    }
    
    .no-image span {
        font-size: 1rem;
    }
    
    .property-details {
        padding: 20px;
    }
    
    .property-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
        color: var(--text-color);
    }
    
    .property-location {
        color: #666;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
    }
    
    .location-icon {
        margin-right: 5px;
    }
    
    .property-features {
        display: flex;
        gap: 15px;
        margin-bottom: 15px;
        color: #666;
        font-size: 14px;
    }
    
    .feature {
        display: flex;
        align-items: center;
    }
    
    .feature-icon {
        margin-right: 5px;
    }
    
    .property-price {
        font-size: 22px;
        font-weight: 700;
        color: var(--primary-color);
        margin-bottom: 20px;
    }
    
    .btn-primary {
        display: inline-block;
        background-color: var(--primary-color);
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        text-align: center;
        width: 100%;
    }
    
    .btn-primary:hover {
        background-color: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .no-properties {
        grid-column: 1 / -1;
        text-align: center;
        padding: 40px;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 40px;
    }
    
    .pagination a {
        padding: 8px 16px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        color: var(--text-color);
        text-decoration: none;
        transition: all 0.3s;
        margin: 0 4px;
    }
    
    .pagination a:hover {
        background-color: var(--light-gray);
    }
    
    .pagination .active {
        background-color: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }
    
    @media (max-width: 768px) {
        .property-grid {
            grid-template-columns: 1fr;
        }
        
        .page-title {
            font-size: 28px;
        }
    }

    .filter-section {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
    }

    .section-title {
        font-size: 2rem;
        font-weight: bold;
        color: var(--primary-color);
        margin-bottom: 1.5rem;
    }

    .filter-controls {
        display: flex;
        gap: 1rem;
        flex-wrap: wrap;
        align-items: flex-end;
    }

    .filter-group {
        flex: 1;
        min-width: 200px;
    }

    .filter-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: #666;
        font-weight: 500;
    }

    .filter-select {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        background-color: white;
        color: #2d3748;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .filter-select:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
    }

    .filter-btn {
        padding: 0.75rem 1.5rem;
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .filter-btn:hover {
        background-color: #2b6cb0;
        transform: translateY(-1px);
    }

    .property-card {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .property-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
    }

    .view-details-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background-color: var(--primary-color);
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .view-details-btn:hover {
        background-color: #2b6cb0;
        transform: translateY(-1px);
    }

    .pagination-wrapper {
        margin-top: 2rem;
        display: flex;
        justify-content: center;
    }

    /* Make pagination match our design */
    .pagination {
        display: flex;
        gap: 0.5rem;
    }

    .pagination a {
        padding: 0.5rem 1rem;
        background: white;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        color: #2d3748;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .pagination a:hover {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .pagination .active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelector('.slider-dots');
        let currentSlide = 0;
        let slideInterval;

        // Create dots
        slides.forEach((_, index) => {
            const dot = document.createElement('div');
            dot.classList.add('dot');
            if (index === 0) dot.classList.add('active');
            dot.addEventListener('click', () => goToSlide(index));
            dots.appendChild(dot);
        });

        // Set background images (you'll need to replace these with your actual image paths)
        slides[0].style.backgroundImage = "url('/images/slider/slide1.jpg')";
        slides[1].style.backgroundImage = "url('/images/slider/slide2.jpg')";
        slides[2].style.backgroundImage = "url('/images/slider/slide3.jpg')";

        function goToSlide(index) {
            slides[currentSlide].classList.remove('active');
            document.querySelectorAll('.dot')[currentSlide].classList.remove('active');
            
            currentSlide = index;
            
            slides[currentSlide].classList.add('active');
            document.querySelectorAll('.dot')[currentSlide].classList.add('active');
        }

        function nextSlide() {
            goToSlide((currentSlide + 1) % slides.length);
        }

        function prevSlide() {
            goToSlide((currentSlide - 1 + slides.length) % slides.length);
        }

        // Add click events to controls
        document.querySelector('.next-slide').addEventListener('click', nextSlide);
        document.querySelector('.prev-slide').addEventListener('click', prevSlide);

        // Start automatic slideshow
        function startSlideshow() {
            slideInterval = setInterval(nextSlide, 2000);
        }

        function stopSlideshow() {
            clearInterval(slideInterval);
        }

        // Start slideshow
        startSlideshow();

        // Pause slideshow when hovering over slider
        const slider = document.querySelector('.slider-container');
        slider.addEventListener('mouseenter', stopSlideshow);
        slider.addEventListener('mouseleave', startSlideshow);
    });

    // Add filter functionality
    document.addEventListener('DOMContentLoaded', function() {
        const filterBtn = document.querySelector('.filter-btn');
        const typeSelect = document.getElementById('propertyType');
        const statusSelect = document.getElementById('propertyStatus');

        filterBtn.addEventListener('click', function() {
            const type = typeSelect.value;
            const status = statusSelect.value;
            
            // Build the URL with query parameters
            let url = window.location.pathname + '?';
            if (type) url += `type=${type}&`;
            if (status) url += `status=${status}&`;
            
            // Remove trailing &
            url = url.slice(0, -1);
            
            // Navigate to the filtered URL
            window.location.href = url;
        });
    });

    // Add lazy loading for images
    document.addEventListener('DOMContentLoaded', function() {
        const images = document.querySelectorAll('.property-image img');
        
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    observer.unobserve(img);
                }
            });
        });

        images.forEach(img => {
            imageObserver.observe(img);
        });
    });
</script>
@endsection 