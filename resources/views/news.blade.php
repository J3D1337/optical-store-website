@extends('layouts.app')

@section('title', 'Novosti')

@section('content')
    <style>
        .fade-in {
            animation: fadeIn 0.3s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .modal {
            display: hidden;
        }

        .modal-overlay {
            background-color: rgba(0, 0, 0, 0.8);
            backdrop-filter: blur(4px);
        }

        .news-card {
            transition: all 0.2s ease;
        }

        .news-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .image-container {
            transition: transform 0.2s ease;
        }

        .image-container:hover {
            transform: scale(1.03);
        }
    </style>

    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="flex justify-start items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-newspaper mr-3 text-blue-600"></i>
                Novosti
            </h1>
        </div>

        <!-- News List -->
        <div class="space-y-6">
            @forelse ($news as $item)
                <div class="bg-white rounded-xl shadow-md overflow-hidden news-card fade-in">
                    <div class="p-6">
                        <!-- News Header -->
                        <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                            <div class="flex-1">
                                <div class="flex items-center mb-1">
                                    <span class="text-sm font-medium text-blue-600 bg-blue-50 px-2 py-1 rounded mr-3">
                                        {{ ucfirst($item->tag ?? 'Novost') }}
                                    </span>
                                    <p class="text-sm text-gray-500">
                                        <i class="far fa-clock mr-1"></i> {{ $item->created_at->format('d.m.Y') }}
                                    </p>
                                </div>
                                <h3 class="text-2xl font-bold text-gray-800">{{ $item->title }}</h3>
                            </div>
                        </div>

                        <!-- Content -->
                        <div class="mt-4">
                            <p class="text-gray-700">
                                {{ $item->content }}
                            </p>
                        </div>

                        <!-- Images Gallery -->
                        @if ($item->images)
                            <div class="mt-4">
                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                                    @foreach ($item->images as $img)
                                        <div class="relative group image-container">
                                            <img src="{{ asset('storage/' . $img) }}"
                                                class="w-full h-32 object-cover rounded-lg cursor-pointer hover:shadow-md transition"
                                                onclick="openImageModal('{{ asset('storage/' . $img) }}')">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                        <div class="bg-yellow-100 border border-yellow-300 text-yellow-800 px-6 py-4 rounded shadow text-center">
                <h3 class="text-lg font-semibold mb-1">Trenutno nema dostupnih novosti</h3>
                <p class="text-sm">Provjerite ponudu uskoro ili nas kontaktirajte za više informacija.</p>
            </div>
            @endforelse
        </div>


    </div>

    <!-- Image Modal -->
<div id="imageModal"
     class="fixed inset-0 z-50 hidden bg-black/80 flex items-center justify-center p-4">
    <div class="relative max-w-6xl w-full">
        <button onclick="closeImageModal()"
                class="absolute top-4 right-4 text-white hover:text-gray-300 transition z-50">
            <i class="fas fa-times text-2xl"></i>
        </button>
        <img id="modalImage"
             src=""
             class="max-h-[90vh] mx-auto object-contain rounded-lg shadow-xl w-auto">
    </div>
</div>





    <!-- Scripts -->
    <script>
        // Image modal functions
        function openImageModal(src) {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modalImage');
            modalImage.src = src;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // Close modal when clicking outside the image
        document.getElementById('imageModal').addEventListener('click', (e) => {
            if (e.target.id === 'imageModal') {
                closeImageModal();
            }
        });
    </script>
@endsection
