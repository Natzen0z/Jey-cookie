@extends('admin.layout')

@section('title', isset($category) ? 'Edit Category' : 'Add Category')

@section('content')

<div class="mb-4">
    <a href="{{ route('admin.categories.index') }}" class="text-decoration-none">
        <i class="fa-solid fa-arrow-left me-2"></i> Back to Categories
    </a>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <i class="fa-solid fa-{{ isset($category) ? 'edit' : 'plus' }} me-2"></i> 
                {{ isset($category) ? 'Edit Category' : 'Add New Category' }}
            </div>
            <div class="card-body">
                <form action="{{ isset($category) ? route('admin.categories.update', $category) : route('admin.categories.store') }}" 
                      method="POST" 
                      enctype="multipart/form-data">
                    @csrf
                    @if(isset($category))
                        @method('PUT')
                    @endif
                    
                    <div class="mb-3">
                        <label for="name" class="form-label">Category Name <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', $category->name ?? '') }}"
                               required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="3">{{ old('description', $category->description ?? '') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="sort_order" class="form-label">Sort Order</label>
                        <input type="number" 
                               class="form-control @error('sort_order') is-invalid @enderror" 
                               id="sort_order" 
                               name="sort_order" 
                               value="{{ old('sort_order', $category->sort_order ?? 0) }}"
                               min="0">
                        @error('sort_order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="form-text">Lower numbers appear first</div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                   {{ old('is_active', $category->is_active ?? true) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_active">Active</label>
                        </div>
                    </div>

                    <hr>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-pink">
                            <i class="fa-solid fa-save me-2"></i> {{ isset($category) ? 'Update' : 'Save' }} Category
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
