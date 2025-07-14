@extends('layouts.admin')

@section('title', 'Upravljanje Novostima')

@section('content')

    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Upravljanje Novostima</h1>
        </div>

        <!-- Add News Form -->
        <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8 fade-in">
            <div class="p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-plus-circle mr-2 text-green-600"></i>
                    Dodaj Novost
                </h2>

                <form method="POST" action="{{ route('admin.news.store') }}" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Naslov</label>
                        <input type="text" id="title" name="title" placeholder="Unesite naslov novosti"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                            required>
                    </div>

                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700 mb-1">Sadržaj</label>
                        <textarea id="content" name="content" rows="4" placeholder="Unesite sadržaj novosti"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition"
                            required></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Slike</label>
                        <div class="w-full" id="upload-section">
                            <div class="flex items-center justify-center w-full">
                                <label for="images"
                                    class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition overflow-hidden">
                                    <div id="upload-placeholder"
                                        class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <i class="fas fa-cloud-upload-alt text-gray-400 text-3xl mb-2"></i>
                                        <p class="mb-2 text-sm text-gray-500">Povucite slike ovdje ili kliknite za
                                            odabir</p>
                                        <p class="text-xs text-gray-500">PNG, JPG, JPEG (MAX. 5MB)</p>
                                    </div>
                                    <input id="images" name="images[]" type="file" multiple class="hidden" />
                                </label>
                            </div>
                            <!-- Previews will be inserted here -->
                        </div>

                        <!-- Preview area -->
                        <div id="preview" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mt-4"></div>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                            class="px-6 py-2 bg-green-600 text-white font-medium rounded-lg hover:bg-green-700 transition flex items-center">
                            <i class="fas fa-save mr-2"></i>
                            Spremi
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- News List -->
        <h2 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
            <i class="fas fa-newspaper mr-2 text-blue-600"></i>
            Popis Novosti
        </h2>

        <div class="space-y-6">
            @foreach ($news as $item)
                <div class="bg-white rounded-xl shadow-md overflow-hidden news-card fade-in"
                    data-news-id="{{ $item->id }}">
                    <div class="p-6">
                        <!-- News Header -->
                        <div class="flex flex-col md:flex-row md:justify-between md:items-center mb-4 gap-4">
                            <div class="flex-1">
                                <h3 class="text-xl font-semibold text-gray-800">{{ $item->title }}</h3>
                                <p class="text-gray-600 mt-1">{{ Str::limit($item->content, 100) }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <button onclick="toggleEdit({{ $item->id }})"
                                    class="px-4 py-2 bg-blue-100 text-blue-600 rounded-lg hover:bg-blue-200 transition flex items-center">
                                    <i class="fas fa-edit mr-2"></i>
                                    Uredi
                                </button>
                                <button
                                    class="delete-btn px-4 py-2 bg-red-100 text-red-600 rounded-lg hover:bg-red-200 transition flex items-center">
                                    <i class="fas fa-trash-alt mr-2"></i>
                                    Obriši
                                </button>
                            </div>
                        </div>

                        <!-- Images Gallery -->
                        @if ($item->images)
                            <div class="mt-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-2 flex items-center">
                                    <i class="fas fa-images mr-2 text-purple-500"></i>
                                    Priložene slike
                                </h4>
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                                    @foreach ($item->images as $img)
                                        <div class="relative group image-container">
                                            <img src="{{ asset('storage/' . $img) }}"
                                                class="w-full h-40 md:h-48 object-cover rounded-lg cursor-pointer hover:shadow-md transition"
                                                onclick="openImageModal('{{ asset('storage/' . $img) }}')">
                                            <button
                                                onclick="deleteImage('{{ $item->id }}', '{{ $img }}', this)"
                                                class="absolute top-2 right-2 bg-red-600 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition">
                                                <i class="fas fa-times text-xs"></i>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Edit Form (Hidden by default) -->
                        <div id="edit-form-{{ $item->id }}" class="mt-6 hidden">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Dodaj nove slike</label>

                                    <div class="relative w-fit">
                                        <label for="add-images-{{ $item->id }}"
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg shadow hover:bg-blue-700 cursor-pointer transition">
                                            <i class="fas fa-upload mr-2"></i> Odaberi slike
                                        </label>

                                        <input id="add-images-{{ $item->id }}" type="file" name="new_images[]"
                                            multiple accept="image/*" class="hidden add-image-input">
                                    </div>

                                    <p class="text-xs text-gray-500 mt-1">PNG, JPG, JPEG (maks. 5MB po slici)</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Naslov</label>
                                    <input type="text"
                                        class="title-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                        value="{{ $item->title }}">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Sadržaj</label>
                                    <textarea
                                        class="content-input w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                                        rows="4">{{ $item->content }}</textarea>
                                </div>

                                <div class="flex justify-end space-x-3">
                                    <button onclick="toggleEdit({{ $item->id }})"
                                        class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                                        Odustani
                                    </button>
                                    <button
                                        class="update-btn px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center">
                                        <i class="fas fa-save mr-2"></i>
                                        Spremi promjene
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Image Modal -->
    {{-- <div id="imageModal" class="fixed inset-0 z-50 hidden bg-black/80 flex items-center justify-center p-4">
            <div class="relative">
                <button onclick="closeImageModal()"
                    class="absolute top-2 right-2 text-white hover:text-gray-300 transition z-50">
                    <i class="fas fa-times text-2xl"></i>
                </button>
                <img id="modalImage" src="" class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-xl">
            </div>
        </div> --}}
@endsection
