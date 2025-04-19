@extends('layouts.admin')

@section('title', 'Site Settings - Egeden Emlak')

@section('content')
<div class="settings-container">
    <div class="settings-header">
        <h1>Site Settings</h1>
        <p class="settings-description">Manage your website settings and configurations</p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="settings-form">
        @csrf
        
        @foreach($settings as $group => $groupSettings)
            <div class="settings-group">
                <h2 class="settings-group-title">{{ ucfirst($group) }} Settings</h2>
                <div class="settings-group-content">
                    @foreach($groupSettings as $setting)
                        <div class="form-group">
                            <label for="{{ $setting->key }}">{{ $setting->label }}</label>
                            @if($setting->description)
                                <p class="setting-description">{{ $setting->description }}</p>
                            @endif

                            @if($setting->type === 'image')
                                @if($setting->value)
                                    <div class="current-image">
                                        <img src="{{ asset('storage/' . $setting->value) }}" alt="{{ $setting->label }}">
                                    </div>
                                @endif
                                <div class="file-upload-wrapper">
                                    <input type="file" 
                                           id="{{ $setting->key }}" 
                                           name="{{ $setting->key }}" 
                                           accept="image/*"
                                           class="file-upload-input">
                                    <label for="{{ $setting->key }}" class="file-upload-label">
                                        <i class="fas fa-cloud-upload-alt"></i>
                                        <span>Choose Image</span>
                                    </label>
                                </div>

                            @elseif($setting->type === 'json' && $setting->key === 'hero_slider')
                                <div class="slider-items">
                                    @php
                                        $sliderItems = json_decode($setting->value, true) ?? [];
                                    @endphp
                                    @foreach($sliderItems as $index => $item)
                                        <div class="slider-item">
                                            <div class="slider-item-header">
                                                <h3>Slide {{ $index + 1 }}</h3>
                                                <button type="button" class="btn-remove-slide" onclick="removeSlide(this)">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                            <div class="slider-item-content">
                                                <div class="form-group">
                                                    <label>Title</label>
                                                    <input type="text" 
                                                           name="{{ $setting->key }}[{{ $index }}][title]" 
                                                           value="{{ $item['title'] ?? '' }}"
                                                           class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Subtitle</label>
                                                    <input type="text" 
                                                           name="{{ $setting->key }}[{{ $index }}][subtitle]" 
                                                           value="{{ $item['subtitle'] ?? '' }}"
                                                           class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label>Image</label>
                                                    @if(isset($item['image']))
                                                        <div class="current-image">
                                                            <img src="{{ asset('storage/' . $item['image']) }}" alt="Slide {{ $index + 1 }}">
                                                        </div>
                                                    @endif
                                                    <div class="file-upload-wrapper">
                                                        <input type="file" 
                                                               name="{{ $setting->key }}[{{ $index }}][image]" 
                                                               accept="image/*"
                                                               class="file-upload-input">
                                                        <label class="file-upload-label">
                                                            <i class="fas fa-cloud-upload-alt"></i>
                                                            <span>Choose Image</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <button type="button" class="btn-add-slide" onclick="addSlide()">
                                        <i class="fas fa-plus"></i> Add New Slide
                                    </button>
                                </div>

                            @else
                                <input type="text" 
                                       id="{{ $setting->key }}" 
                                       name="{{ $setting->key }}" 
                                       value="{{ $setting->value }}"
                                       class="form-control">
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="settings-actions">
            <button type="submit" class="btn-save-settings">
                <i class="fas fa-save"></i> Save Settings
            </button>
            <button type="reset" class="btn-reset-settings">
                <i class="fas fa-undo"></i> Reset Changes
            </button>
        </div>
    </form>
</div>

<style>
    .settings-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 2rem;
    }

    .settings-header {
        margin-bottom: 2rem;
        text-align: center;
    }

    .settings-header h1 {
        font-size: 2.5rem;
        color: var(--primary-color);
        margin-bottom: 0.5rem;
    }

    .settings-description {
        color: var(--text-color);
        opacity: 0.8;
    }

    .settings-group {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 2rem;
        overflow: hidden;
    }

    .settings-group-title {
        background: var(--primary-color);
        color: white;
        padding: 1rem 1.5rem;
        margin: 0;
        font-size: 1.25rem;
    }

    .settings-group-content {
        padding: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: var(--text-color);
    }

    .setting-description {
        font-size: 0.875rem;
        color: var(--text-color);
        opacity: 0.7;
        margin-bottom: 0.5rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid var(--border-color);
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.1);
        outline: none;
    }

    .file-upload-wrapper {
        position: relative;
        margin-top: 0.5rem;
    }

    .file-upload-input {
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
        width: 100%;
        height: 100%;
        cursor: pointer;
    }

    .file-upload-label {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        background: var(--light-gray);
        border: 2px dashed var(--border-color);
        border-radius: 8px;
        color: var(--text-color);
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .file-upload-label:hover {
        background: var(--border-color);
        border-color: var(--primary-color);
    }

    .current-image {
        margin: 1rem 0;
        max-width: 300px;
    }

    .current-image img {
        width: 100%;
        height: auto;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .slider-items {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .slider-item {
        background: var(--light-gray);
        border-radius: 8px;
        padding: 1.5rem;
    }

    .slider-item-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }

    .slider-item-header h3 {
        margin: 0;
        color: var(--text-color);
    }

    .btn-remove-slide {
        background: none;
        border: none;
        color: var(--error-color);
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 4px;
        transition: background-color 0.3s;
    }

    .btn-remove-slide:hover {
        background: rgba(229, 62, 62, 0.1);
    }

    .btn-add-slide {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem 1.5rem;
        background: var(--primary-color);
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background-color 0.3s;
        margin-top: 1rem;
    }

    .btn-add-slide:hover {
        background: var(--primary-hover);
    }

    .settings-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
        margin-top: 2rem;
    }

    .btn-save-settings,
    .btn-reset-settings {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border: none;
        border-radius: 8px;
        font-size: 1rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .btn-save-settings {
        background: var(--primary-color);
        color: white;
    }

    .btn-save-settings:hover {
        background: var(--primary-hover);
        transform: translateY(-1px);
    }

    .btn-reset-settings {
        background: var(--light-gray);
        color: var(--text-color);
    }

    .btn-reset-settings:hover {
        background: var(--border-color);
        transform: translateY(-1px);
    }

    .alert {
        padding: 1rem 1.5rem;
        border-radius: 8px;
        margin-bottom: 2rem;
    }

    .alert-success {
        background: #f0fff4;
        border: 1px solid #9ae6b4;
        color: var(--success-color);
    }
</style>

<script>
    function addSlide() {
        const sliderItems = document.querySelector('.slider-items');
        const slideCount = sliderItems.querySelectorAll('.slider-item').length;
        
        const newSlide = document.createElement('div');
        newSlide.className = 'slider-item';
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            @foreach($settings as $group => $groupSettings)
                <div class="settings-group">
                    <h2>{{ ucfirst($group) }} Settings</h2>
                    
                    @foreach($groupSettings as $setting)
                        <div class="setting-item">
                            <label for="{{ $setting->key }}">
                                {{ $setting->label }}
                                @if($setting->description)
                                    <small class="description">{{ $setting->description }}</small>
                                @endif
                            </label>

                            @if($setting->type === 'text')
                                <input type="text" 
                                       id="{{ $setting->key }}" 
                                       name="{{ $setting->key }}" 
                                       value="{{ $setting->value }}"
                                       class="form-input">
                            @elseif($setting->type === 'image')
                                @if($setting->value)
                                    <div class="current-image">
                                        <img src="{{ asset('storage/' . $setting->value) }}" alt="Current image">
                                    </div>
                                @endif
                                <input type="file" 
                                       id="{{ $setting->key }}" 
                                       name="{{ $setting->key }}" 
                                       accept="image/*"
                                       class="form-input">
                            @elseif($setting->type === 'json')
                                @if($setting->key === 'hero_slider')
                                    <div class="hero-slider-settings">
                                        @foreach(json_decode($setting->value, true) as $index => $slide)
                                            <div class="slide-settings">
                                                <h3>Slide {{ $index + 1 }}</h3>
                                                <input type="text" 
                                                       name="{{ $setting->key }}[{{ $index }}][title]" 
                                                       value="{{ $slide['title'] }}"
                                                       placeholder="Slide Title"
                                                       class="form-input">
                                                <input type="text" 
                                                       name="{{ $setting->key }}[{{ $index }}][subtitle]" 
                                                       value="{{ $slide['subtitle'] }}"
                                                       placeholder="Slide Subtitle"
                                                       class="form-input">
                                                @if(isset($slide['image']))
                                                    <div class="current-image">
                                                        <img src="{{ asset('storage/' . $slide['image']) }}" alt="Slide image">
                                                    </div>
                                                @endif
                                                <input type="file" 
                                                       name="{{ $setting->key }}[{{ $index }}][image]" 
                                                       accept="image/*"
                                                       class="form-input">
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <textarea id="{{ $setting->key }}" 
                                              name="{{ $setting->key }}" 
                                              class="form-input">{{ $setting->value }}</textarea>
                                @endif
                            @endif
                        </div>
                    @endforeach
                </div>
            @endforeach

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save Settings</button>
            </div>
        </form>
    </div>
</div>

<style>
.settings-page {
    max-width: 800px;
    margin: 2rem auto;
    padding: 2rem;
    background: white;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.settings-page h1 {
    margin-bottom: 2rem;
    color: var(--text-color);
}

.settings-group {
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border-color);
}

.settings-group h2 {
    margin-bottom: 1rem;
    color: var(--text-color);
    font-size: 1.5rem;
}

.setting-item {
    margin-bottom: 1.5rem;
}

.setting-item label {
    display: block;
    margin-bottom: 0.5rem;
    color: var(--text-color);
    font-weight: 500;
}

.setting-item .description {
    display: block;
    color: var(--dark-gray);
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.form-input {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid var(--border-color);
    border-radius: 4px;
    font-size: 1rem;
}

.current-image {
    margin: 1rem 0;
}

.current-image img {
    max-width: 200px;
    height: auto;
    border-radius: 4px;
}

.hero-slider-settings {
    display: grid;
    gap: 1.5rem;
}

.slide-settings {
    padding: 1rem;
    background: var(--light-gray);
    border-radius: 4px;
}

.slide-settings h3 {
    margin-bottom: 1rem;
    color: var(--text-color);
}

.form-actions {
    margin-top: 2rem;
    padding-top: 1rem;
    border-top: 1px solid var(--border-color);
}

.btn {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 4px;
    font-size: 1rem;
    cursor: pointer;
    transition: background-color 0.3s;
}

.btn-primary {
    background-color: var(--primary-color);
    color: white;
}

.btn-primary:hover {
    background-color: var(--primary-hover);
}

.alert {
    padding: 1rem;
    margin-bottom: 1rem;
    border-radius: 4px;
}

.alert-success {
    background-color: #d1fae5;
    color: #065f46;
    border: 1px solid #a7f3d0;
}
</style>
@endsection 