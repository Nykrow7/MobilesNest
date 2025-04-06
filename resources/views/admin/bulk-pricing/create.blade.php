@extends('layouts.admin')

@section('title', 'Add Bulk Pricing Tier')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Add Bulk Pricing Tier for {{ $product->name }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.bulk-pricing.index', $product->id) }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to Tiers
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.bulk-pricing.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <div class="form-group">
                            <label for="min_quantity">Minimum Quantity <span class="text-danger">*</span></label>
                            <input type="number" name="min_quantity" id="min_quantity" class="form-control @error('min_quantity') is-invalid @enderror" value="{{ old('min_quantity') }}" min="2" required>
                            @error('min_quantity')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">The minimum quantity required to get this pricing.</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="max_quantity">Maximum Quantity</label>
                            <input type="number" name="max_quantity" id="max_quantity" class="form-control @error('max_quantity') is-invalid @enderror" value="{{ old('max_quantity') }}" min="2">
                            @error('max_quantity')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Leave empty for no upper limit.</small>
                        </div>
                        
                        <div class="form-group">
                            <label for="price">Unit Price <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price') }}" step="0.01" min="0" required>
                            </div>
                            @error('price')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="discount_percentage">Discount Percentage</label>
                            <div class="input-group">
                                <input type="number" name="discount_percentage" id="discount_percentage" class="form-control @error('discount_percentage') is-invalid @enderror" value="{{ old('discount_percentage') }}" step="0.01" min="0" max="100">
                                <div class="input-group-append">
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>
                            @error('discount_percentage')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Optional. The percentage discount from the regular price.</small>
                        </div>
                        
                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" checked>
                                <label class="custom-control-label" for="is_active">Active</label>
                            </div>
                            <small class="form-text text-muted">Enable or disable this pricing tier.</small>
                        </div>
                        
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Save Tier</button>
                            <a href="{{ route('admin.bulk-pricing.index', $product->id) }}" class="btn btn-default">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection