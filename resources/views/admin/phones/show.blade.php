@extends('admin.layouts.app')

@section('admin-content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Phone Details</h2>
        <div>
            <a href="{{ route('admin.phones.edit', $phone) }}" class="btn btn-warning">Edit</a>
            <a href="{{ route('admin.phones.index') }}" class="btn btn-secondary">Back to List</a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    @if($phone->images->isNotEmpty())
                        <img src="{{ asset('storage/' . $phone->images->first()->image_path) }}" alt="{{ $phone->name }}" class="img-fluid rounded">
                    @else
                        <div class="text-center p-5 bg-light rounded">
                            <p class="text-muted">No image available</p>
                        </div>
                    @endif
                </div>
                <div class="col-md-8">
                    <h3>{{ $phone->name }}</h3>
                    @php
                        $description = json_decode($phone->description, true);
                        $brand = $description['brand'] ?? 'N/A';
                        $specs = $description['specs'] ?? [];
                    @endphp
                    
                    <p><strong>Brand:</strong> {{ $brand }}</p>
                    <p><strong>Price:</strong> ${{ number_format($phone->price, 2) }}</p>
                    <p><strong>SKU:</strong> {{ $phone->sku }}</p>
                    <p><strong>Stock:</strong> {{ $phone->inventory->quantity ?? 0 }}</p>
                    
                    <h4 class="mt-4">Specifications</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tbody>
                                @if(is_array($specs))
                                    @foreach($specs as $key => $value)
                                        <tr>
                                            <th>{{ ucfirst(str_replace('_', ' ', $key)) }}</th>
                                            <td>
                                                @if(is_array($value))
                                                    <ul class="mb-0">
                                                        @foreach($value as $subKey => $subValue)
                                                            <li><strong>{{ ucfirst(str_replace('_', ' ', $subKey)) }}:</strong> {{ $subValue }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    {{ $value }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="2">No specifications available</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection