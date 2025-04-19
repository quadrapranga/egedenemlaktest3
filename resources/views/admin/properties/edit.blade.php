@extends('layouts.app')

@section('title', 'Edit Property - Egeden Emlak')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="edit-card">
        <div class="edit-header">
            <h1 class="edit-title">Edit Property</h1>
            <p class="edit-subtitle">Update property information</p>
        </div>

        <form action="{{ route('admin.properties.update', $property) }}" method="POST" enctype="multipart/form-data" class="edit-form">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" id="title" name="title" value="{{ old('title', $property->title) }}" required>
                    @error('title')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="property_type_id">Property Type</label>
                    <select id="property_type_id" name="property_type_id" required>
                        @foreach($propertyTypes as $type)
                            <option value="{{ $type->id }}" {{ old('property_type_id', $property->property_type_id) == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('property_type_id')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="property_status_id">Status</label>
                    <select id="property_status_id" name="property_status_id" required>
                        @foreach($propertyStatuses as $status)
                            <option value="{{ $status->id }}" {{ old('property_status_id', $property->property_status_id) == $status->id ? 'selected' : '' }}>
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('property_status_id')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price">Price (₺)</label>
                    <input type="number" id="price" name="price" value="{{ old('price', $property->price) }}" required>
                    @error('price')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="area">Area (m²)</label>
                    <input type="number" id="area" name="area" value="{{ old('area', $property->area) }}" required>
                    @error('area')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="bedrooms">Bedrooms</label>
                    <input type="number" id="bedrooms" name="bedrooms" value="{{ old('bedrooms', $property->bedrooms) }}" required>
                    @error('bedrooms')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="bathrooms">Bathrooms</label>
                    <input type="number" id="bathrooms" name="bathrooms" value="{{ old('bathrooms', $property->bathrooms) }}" required>
                    @error('bathrooms')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" id="location" name="location" value="{{ old('location', $property->location) }}" required>
                    @error('location')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="contact_number">Contact Number</label>
                    <input type="text" id="contact_number" name="contact_number" value="{{ old('contact_number', $property->contact_number) }}" required>
                    @error('contact_number')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group full-width">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" rows="4" required>{{ old('description', $property->description) }}</textarea>
                    @error('description')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group full-width">
                    <label for="image">Property Image</label>
                    <div class="image-upload">
                        <div class="current-image">
                            @if($property->image)
                                <img src="{{ asset('storage/' . $property->image) }}" alt="Current property image">
                            @else
                                <div class="no-image">No image available</div>
                            @endif
                        </div>
                        <div class="upload-controls">
                            <input type="file" id="image" name="image" accept="image/*">
                            <p class="upload-hint">Click to upload a new image</p>
                        </div>
                    </div>
                    @error('image')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.properties.index') }}" class="cancel-btn">
                    <i class="fas fa-times"></i>
                    Cancel
                </a>
                <button type="submit" class="save-btn">
                    <i class="fas fa-save"></i>
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .edit-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .edit-header {
        margin-bottom: 2rem;
        text-align: center;
    }

    .edit-title {
        font-size: 2rem;
        font-weight: bold;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }

    .edit-subtitle {
        color: #666;
        font-size: 1.1rem;
    }

    .edit-form {
        max-width: 1200px;
        margin: 0 auto;
    }

    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .form-group.full-width {
        grid-column: 1 / -1;
    }

    .form-group label {
        font-weight: 500;
        color: #2d3748;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        padding: 0.75rem;
        border: 2px solid #e2e8f0;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-group input:focus,
    .form-group select:focus,
    .form-group textarea:focus {
        border-color: var(--primary-color);
        outline: none;
        box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.1);
    }

    .error-message {
        color: #e53e3e;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .image-upload {
        display: flex;
        gap: 2rem;
        align-items: center;
    }

    .current-image {
        width: 200px;
        height: 200px;
        border-radius: 10px;
        overflow: hidden;
        background: #f7fafc;
    }

    .current-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .no-image {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #a0aec0;
        font-size: 0.875rem;
    }

    .upload-controls {
        flex: 1;
    }

    .upload-controls input[type="file"] {
        width: 100%;
        padding: 1rem;
        border: 2px dashed #e2e8f0;
        border-radius: 8px;
        cursor: pointer;
    }

    .upload-hint {
        margin-top: 0.5rem;
        color: #718096;
        font-size: 0.875rem;
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #e2e8f0;
    }

    .cancel-btn,
    .save-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s ease;
        cursor: pointer;
    }

    .cancel-btn {
        background-color: #f7fafc;
        color: #4a5568;
        text-decoration: none;
        border: 2px solid #e2e8f0;
    }

    .cancel-btn:hover {
        background-color: #edf2f7;
        transform: translateY(-1px);
    }

    .save-btn {
        background-color: var(--primary-color);
        color: white;
        border: none;
    }

    .save-btn:hover {
        background-color: #2b6cb0;
        transform: translateY(-1px);
    }

    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }

        .image-upload {
            flex-direction: column;
        }

        .current-image {
            width: 100%;
            height: 300px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const imageInput = document.getElementById('image');
        const currentImage = document.querySelector('.current-image img');
        const noImage = document.querySelector('.no-image');

        imageInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    if (currentImage) {
                        currentImage.src = e.target.result;
                    } else {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        noImage.replaceWith(img);
                    }
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
@endsection 