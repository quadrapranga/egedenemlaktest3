@extends('layouts.admin')

@section('title', 'Add New Property - Egeden Emlak Admin')

@section('content')
<div class="card">
    <div class="card-header">
        <h2 class="card-title">Add New Property</h2>
    </div>
    
    <div class="card-body">
        <form action="{{ route('admin.properties.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                        class="form-control @error('title') is-invalid @enderror">
                    @error('title')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="property_type_id">Property Type</label>
                    <select name="property_type_id" id="property_type_id" required
                        class="form-select @error('property_type_id') is-invalid @enderror">
                        <option value="">Select Type</option>
                        @foreach($propertyTypes as $type)
                            <option value="{{ $type->id }}" {{ old('property_type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('property_type_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="property_status_id">Property Status</label>
                    <select name="property_status_id" id="property_status_id" required
                        class="form-select @error('property_status_id') is-invalid @enderror">
                        <option value="">Select Status</option>
                        @foreach($propertyStatuses as $status)
                            <option value="{{ $status->id }}" {{ old('property_status_id') == $status->id ? 'selected' : '' }}>
                                {{ $status->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('property_status_id')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price">Price ($)</label>
                    <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}" required
                        class="form-control @error('price') is-invalid @enderror">
                    @error('price')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="area">Area (m²)</label>
                    <input type="number" step="0.01" name="area" id="area" value="{{ old('area') }}" required
                        class="form-control @error('area') is-invalid @enderror">
                    @error('area')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}" required
                        class="form-control @error('location') is-invalid @enderror">
                    @error('location')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="bedrooms">Bedrooms</label>
                    <input type="number" name="bedrooms" id="bedrooms" value="{{ old('bedrooms') }}" required
                        class="form-control @error('bedrooms') is-invalid @enderror">
                    @error('bedrooms')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="bathrooms">Bathrooms</label>
                    <input type="number" name="bathrooms" id="bathrooms" value="{{ old('bathrooms') }}" required
                        class="form-control @error('bathrooms') is-invalid @enderror">
                    @error('bathrooms')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="contact_number">Contact Number</label>
                    <input type="text" name="contact_number" id="contact_number" value="{{ old('contact_number') }}" required
                        class="form-control @error('contact_number') is-invalid @enderror">
                    @error('contact_number')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="image">Property Image</label>
                    <div class="file-upload">
                        <input type="file" name="image" id="image" accept="image/*"
                            class="file-input @error('image') is-invalid @enderror">
                        <div class="file-upload-label">
                            <span class="file-icon">📷</span>
                            <span class="file-text">Choose an image</span>
                        </div>
                    </div>
                    @error('image')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group full-width">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="4"
                        class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Property Images</label>
                    <div class="image-upload-container">
                        <div class="image-upload-area" id="dropZone">
                            <input type="file" name="images[]" id="images" class="image-input" multiple accept="image/*" @error('images') is-invalid @enderror>
                            <div class="upload-content">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <p>Drag & Drop images here or click to browse</p>
                                <span class="text-muted">Supported formats: JPG, PNG, GIF (Max 2MB each)</span>
                            </div>
                        </div>
                        <div class="image-preview-container" id="imagePreviewContainer"></div>
                    </div>
                    @error('images')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.properties.index') }}" class="btn btn-secondary">
                    <span class="btn-icon">←</span> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <span class="btn-icon">✓</span> Create Property
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .card {
        background-color: white;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 24px;
        margin-bottom: 24px;
    }
    
    .card-header {
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid var(--border-color);
    }
    
    .card-title {
        font-size: 24px;
        font-weight: 600;
        color: var(--text-color);
    }
    
    .card-body {
        padding: 0;
    }
    
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }
    
    .form-group {
        margin-bottom: 0;
    }
    
    .form-group.full-width {
        grid-column: 1 / -1;
    }
    
    .form-group label {
        display: block;
        margin-bottom: 8px;
        font-weight: 500;
        color: var(--text-color);
    }
    
    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 14px;
        transition: border-color 0.3s, box-shadow 0.3s;
    }
    
    .form-control:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.1);
    }
    
    .form-select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 14px;
        background-color: white;
        cursor: pointer;
        transition: border-color 0.3s, box-shadow 0.3s;
    }
    
    .form-select:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.1);
    }
    
    .is-invalid {
        border-color: var(--error-color);
    }
    
    .invalid-feedback {
        display: block;
        color: var(--error-color);
        font-size: 12px;
        margin-top: 5px;
    }
    
    .file-upload {
        position: relative;
        width: 100%;
    }
    
    .file-input {
        position: absolute;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
        z-index: 2;
    }
    
    .file-upload-label {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 10px 12px;
        border: 1px dashed var(--border-color);
        border-radius: 8px;
        background-color: #f8f9fa;
        transition: all 0.3s;
    }
    
    .file-upload-label:hover {
        border-color: var(--primary-color);
        background-color: rgba(0, 102, 255, 0.05);
    }
    
    .file-icon {
        font-size: 18px;
        margin-right: 8px;
    }
    
    .file-text {
        font-size: 14px;
        color: #666;
    }
    
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
        margin-top: 30px;
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background-color: var(--primary-color);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        background-color: var(--primary-hover);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    
    .btn-secondary {
        background-color: #6c757d;
    }
    
    .btn-secondary:hover {
        background-color: #5a6268;
    }
    
    .btn-icon {
        margin-right: 8px;
        font-size: 16px;
    }
    
    @media (max-width: 768px) {
        .form-grid {
            grid-template-columns: 1fr;
        }
    }

    .image-upload-container {
        margin-bottom: 1.5rem;
    }

    .image-upload-area {
        border: 2px dashed var(--primary-color);
        border-radius: 8px;
        padding: 2rem;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s ease;
        background: var(--light-gray);
        position: relative;
    }

    .image-upload-area:hover {
        background: #f8f9fa;
        border-color: #2b6cb0;
    }

    .image-upload-area.dragover {
        background: #ebf8ff;
        border-color: #2b6cb0;
    }

    .image-input {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
    }

    .upload-content {
        pointer-events: none;
    }

    .upload-content i {
        font-size: 3rem;
        color: var(--primary-color);
        margin-bottom: 1rem;
    }

    .upload-content p {
        margin: 0.5rem 0;
        font-size: 1.1rem;
        color: var(--dark-gray);
    }

    .image-preview-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }

    .image-preview {
        position: relative;
        aspect-ratio: 1;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .image-preview .remove-image {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        background: rgba(255,255,255,0.9);
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: var(--error-color);
        transition: all 0.3s ease;
    }

    .image-preview .remove-image:hover {
        background: var(--error-color);
        color: white;
    }
</style>

<script>
    // Update file input label when a file is selected
    document.getElementById('image').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name || 'Choose an image';
        document.querySelector('.file-text').textContent = fileName;
    });

    document.addEventListener('DOMContentLoaded', function() {
        const dropZone = document.getElementById('dropZone');
        const imageInput = document.getElementById('images');
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');
        const maxFileSize = 2 * 1024 * 1024; // 2MB

        // Prevent default drag behaviors
        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, preventDefaults, false);
            document.body.addEventListener(eventName, preventDefaults, false);
        });

        // Highlight drop zone when dragging over it
        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, highlight, false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, unhighlight, false);
        });

        // Handle dropped files
        dropZone.addEventListener('drop', handleDrop, false);

        // Handle selected files
        imageInput.addEventListener('change', handleFiles, false);

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        function highlight(e) {
            dropZone.classList.add('dragover');
        }

        function unhighlight(e) {
            dropZone.classList.remove('dragover');
        }

        function handleDrop(e) {
            const dt = e.dataTransfer;
            const files = dt.files;
            handleFiles({ target: { files: files } });
        }

        function handleFiles(e) {
            const files = [...e.target.files];
            
            files.forEach(file => {
                if (!file.type.startsWith('image/')) {
                    alert('Please upload only image files.');
                    return;
                }
                
                if (file.size > maxFileSize) {
                    alert('File size should not exceed 2MB.');
                    return;
                }

                const reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onloadend = function() {
                    const preview = document.createElement('div');
                    preview.className = 'image-preview';
                    preview.innerHTML = `
                        <img src="${reader.result}" alt="Preview">
                        <button type="button" class="remove-image" onclick="this.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                    imagePreviewContainer.appendChild(preview);
                }
            });
        }
    });
</script>
@endsection 