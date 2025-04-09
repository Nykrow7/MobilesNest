@extends('admin.layouts.app')

@section('admin-content')
<div class="container mx-auto px-4 py-8 max-w-4xl">
    <div class="bg-white shadow-lg rounded-lg p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Phone</h2>
        <form action="{{ route('admin.phones.update', $phone) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Phone Name</label>
                    <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" id="name" name="name" value="{{ $phone->name }}" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="brand" class="block text-sm font-medium text-gray-700 mb-1">Brand</label>
                    @php
                        $description = json_decode($phone->description, true);
                        $brand = $description['brand'] ?? '';
                        $specs = $description['specs'] ?? [];
                    @endphp
                    <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" id="brand" name="brand" value="{{ $brand }}" required>
                    @error('brand')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="processor" class="block text-sm font-medium text-gray-700 mb-1">Processor</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" id="processor" name="specs[processor]" value="{{ $specs['processor'] ?? '' }}" required>
                        @error('specs.processor')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="memory" class="block text-sm font-medium text-gray-700 mb-1">Memory</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" id="memory" name="specs[memory]" value="{{ $specs['memory'] ?? '' }}" required>
                        @error('specs.memory')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="display" class="block text-sm font-medium text-gray-700 mb-1">Display</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" id="display" name="specs[display]" value="{{ $specs['display'] ?? '' }}" required>
                        @error('specs.display')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="battery" class="block text-sm font-medium text-gray-700 mb-1">Battery</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" id="battery" name="specs[battery]" value="{{ $specs['battery'] ?? '' }}" required>
                        @error('specs.battery')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="camera" class="block text-sm font-medium text-gray-700 mb-1">Camera</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" id="camera" name="specs[camera]" value="{{ $specs['camera'] ?? '' }}" required>
                        @error('specs.camera')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="os" class="block text-sm font-medium text-gray-700 mb-1">Operating System</label>
                        <input type="text" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" id="os" name="specs[os]" value="{{ $specs['os'] ?? '' }}" required>
                        @error('specs.os')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-500">$</span>
                        <input type="number" step="0.01" class="w-full pl-8 pr-4 py-2 border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500" id="price" name="price" value="{{ $phone->price }}" required>
                    </div>
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="col-span-2">
                    <label for="images" class="block text-sm font-medium text-gray-700 mb-1">Phone Images</label>
                    <div class="mt-1 flex flex-col space-y-2">
                        @if($phone->images->isNotEmpty())
                            <div class="mb-3">
                                <p class="text-sm text-gray-600 mb-2">Current images:</p>
                                <div class="grid grid-cols-5 gap-4">
                                    @foreach($phone->images as $image)
                                        <div class="relative group">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $phone->name }}" class="h-24 w-24 object-cover rounded-md">
                                            @if($image->is_primary)
                                                <span class="absolute top-0 left-0 bg-indigo-600 text-white text-xs px-2 py-1 rounded-tl-md rounded-br-md">Primary</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                <p class="text-sm text-gray-600 mt-2">Upload new images to replace the current ones.</p>
                            </div>
                        @endif
                        
                        <!-- Main image upload area -->
                        <div class="flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md relative" 
                             id="dropzone"
                             x-data="{ 
                                isHovering: false,
                                previewUrls: [],
                                previewCount: 0,
                                handleFiles(e) {
                                    let files = e.dataTransfer ? [...e.dataTransfer.files] : [...e.target.files];
                                    files = files.filter(file => file.type.match('image.*'));
                                    if (files.length > 0) {
                                        this.previewCount = Math.min(files.length, 5);
                                        this.previewUrls = [];
                                        for (let i = 0; i < this.previewCount; i++) {
                                            this.previewUrls.push(URL.createObjectURL(files[i]));
                                        }
                                    }
                                }
                             }"
                             x-on:dragover.prevent="isHovering = true"
                             x-on:dragleave.prevent="isHovering = false"
                             x-on:drop.prevent="isHovering = false; handleFiles($event)"
                             x-bind:class="{ 'bg-indigo-50 border-indigo-300': isHovering }">
                            
                            <!-- Upload icon and text -->
                            <div class="space-y-1 text-center" x-show="previewUrls.length === 0">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            
                            <!-- Preview area -->
                            <div class="w-full" x-show="previewUrls.length > 0">
                                <div class="grid grid-cols-5 gap-4 mb-4">
                                    <template x-for="(url, index) in previewUrls" :key="index">
                                        <div class="relative group">
                                            <img :src="url" class="h-24 w-24 object-cover rounded-md mx-auto" />
                                            <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity rounded-md">
                                                <span class="text-white text-xs">Image <span x-text="index + 1"></span></span>
                                            </div>
                                        </div>
                                    </template>
                                </div>
                                <div class="text-center">
                                    <p class="text-sm text-gray-600 font-medium"><span x-text="previewCount"></span> images selected</p>
                                </div>
                            </div>
                            
                            <div class="flex text-sm text-gray-600 justify-center" :class="{'mt-2': previewUrls.length > 0}">
                                <label for="images" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                                    <span x-text="previewUrls.length === 0 ? 'Upload images' : 'Change images'"></span>
                                    <input id="images" name="images[]" type="file" class="sr-only" accept="image/jpeg, image/png" multiple @change="handleFiles($event)">
                                </label>
                                <p class="pl-1" x-show="previewUrls.length === 0">or drag and drop</p>
                            </div>
                            <p class="text-xs text-gray-500 text-center" x-show="previewUrls.length === 0">PNG, JPG up to 10MB (Upload up to 5 images)</p>
                        </div>
                        
                        <!-- Help text -->
                        <p class="text-xs text-gray-500">The first image will be used as the main product image. You can upload up to 5 images.</p>
                    </div>
                    @error('images')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    @error('images.*')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex justify-end space-x-4 mt-6">
                <a href="{{ route('admin.phones.index') }}" class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancel</a>
                <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Update Phone</button>
            </div>
        </form>
    </div>
</div>
@endsection