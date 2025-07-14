    <!-- Image Modal -->
    <div id="imageModal" class="fixed inset-0 z-50 hidden bg-black/80 flex items-center justify-center p-4">
        <div class="relative max-w-6xl w-full">
            <button onclick="closeImageModal()"
                class="absolute top-4 right-4 text-white hover:text-gray-300 transition z-50">
                <i class="fas fa-times text-2xl"></i>
            </button>
            <img id="modalImage" src="" class="max-h-[90vh] mx-auto object-contain rounded-lg shadow-xl w-auto">
        </div>
    </div>
