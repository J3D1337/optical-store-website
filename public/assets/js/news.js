const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

// Toggle edit form
function toggleEdit(newsId) {
    const form = document.getElementById(`edit-form-${newsId}`);
    form.classList.toggle("hidden");
}

// Update news

document.querySelectorAll(".update-btn").forEach((btn) => {
    btn.addEventListener("click", async () => {
        const container = btn.closest("[data-news-id]");
        const id = container.dataset.newsId;
        const title = container.querySelector(".title-input").value;
        const content = container.querySelector(".content-input").value;
        const form = document.getElementById(`edit-form-${id}`);

        try {
            const formData = new FormData();
            formData.append("_method", "PUT"); // Important for Laravel
            formData.append("title", title);
            formData.append("content", content);

            const fileInput = container.querySelector(".add-image-input");
            if (fileInput && fileInput.files.length > 0) {
                Array.from(fileInput.files).forEach((file) => {
                    formData.append("new_images[]", file);
                });
            }

            const res = await fetch(`/admin/novosti/${id}`, {
                method: "POST", // Laravel uses POST + _method=PUT for formData
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
                body: formData,
            });

            if (res.ok) {
                const json = await res.json();
                showNotification("Novost uspješno ažurirana!", "success");
                form.classList.add("hidden");

                // Update displayed title and content
                container.querySelector("h3").textContent = title;
                container.querySelector("p").textContent =
                    content.substring(0, 100) +
                    (content.length > 100 ? "..." : "");

                // Append new images to the gallery if any
                if (json.newImages && Array.isArray(json.newImages)) {
                    const gallery = container.querySelector(".grid");
                    json.newImages.forEach((path) => {
                        const wrapper = document.createElement("div");
                        wrapper.className = "relative group image-container";
                        wrapper.innerHTML = `
                            <img src="/storage/${path}"
                                 class="w-full h-32 object-cover rounded-lg cursor-pointer hover:shadow-md transition"
                                 onclick="openImageModal('/storage/${path}')">
                            <button
                                onclick="deleteImage('${id}', '${path}', this)"
                                class="absolute top-2 right-2 bg-red-600 text-white p-1 rounded-full opacity-0 group-hover:opacity-100 transition">
                                <i class="fas fa-times text-xs"></i>
                            </button>
                        `;
                        gallery.appendChild(wrapper);
                    });
                }

                // Reset file input after upload
                if (fileInput) fileInput.value = "";
            } else {
                const errorMsg = await res.text();
                throw new Error(errorMsg || "Greška pri ažuriranju");
            }
        } catch (error) {
            showNotification("Greška pri ažuriranju novosti", "error");
            console.error(error);
        }
    });
});

// Delete news
document.querySelectorAll(".delete-btn").forEach((btn) => {
    btn.addEventListener("click", async () => {
        if (!confirm("Jeste li sigurni da želite obrisati ovu novost?")) return;

        const container = btn.closest("[data-news-id]");
        const id = container.dataset.newsId;

        try {
            const res = await fetch(`/admin/novosti/${id}`, {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
            });

            if (res.ok) {
                showNotification("Novost uspješno obrisana!", "success");
                container.classList.add(
                    "opacity-0",
                    "translate-x-full",
                    "transition",
                    "duration-300"
                );
                setTimeout(() => container.remove(), 300);
            } else {
                throw new Error("Greška pri brisanju");
            }
        } catch (error) {
            showNotification("Greška pri brisanju novosti", "error");
            console.error(error);
        }
    });
});

// Delete image
function deleteImage(newsId, imagePath, btn) {
    if (!confirm("Jeste li sigurni da želite obrisati ovu sliku?")) return;

    fetch(`/admin/novosti/${newsId}/image`, {
        method: "DELETE",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
        },
        body: JSON.stringify({
            image_path: imagePath,
        }),
    })
        .then((res) => {
            if (res.ok) {
                showNotification("Slika uspješno obrisana!", "success");
                const imageContainer = btn.closest(".image-container");
                imageContainer.classList.add(
                    "opacity-0",
                    "scale-90",
                    "transition",
                    "duration-300"
                );
                setTimeout(() => imageContainer.remove(), 300);
            } else {
                throw new Error("Greška pri brisanju slike");
            }
        })
        .catch((error) => {
            showNotification("Greška pri brisanju slike", "error");
            console.error(error);
        });
}

// Image modal functions
function openImageModal(src) {
    const modal = document.getElementById("imageModal");
    const modalImage = document.getElementById("modalImage");
    modalImage.src = src;
    modal.classList.remove("hidden");
    document.body.style.overflow = "hidden";
}

function closeImageModal() {
    const modal = document.getElementById("imageModal");
    modal.classList.add("hidden");
    document.body.style.overflow = "auto";
}

// Close modal when clicking outside the image
document.getElementById("imageModal").addEventListener("click", (e) => {
    if (e.target.id === "imageModal") {
        closeImageModal();
    }
});

// Notification function
function showNotification(message, type) {
    const notification = document.createElement("div");
    notification.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white font-medium flex items-center ${
        type === "success" ? "bg-green-500" : "bg-red-500"
    }`;
    notification.innerHTML = `
                <i class="fas ${
                    type === "success"
                        ? "fa-check-circle"
                        : "fa-exclamation-circle"
                } mr-2"></i>
                ${message}
            `;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.classList.add(
            "opacity-0",
            "translate-x-full",
            "transition",
            "duration-300"
        );
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// File upload preview (optional enhancement)
document.getElementById("images")?.addEventListener("change", function (e) {
    const files = e.target.files;
    const previewContainer = document.createElement("div");
    previewContainer.className = "mt-3 grid grid-cols-3 gap-2";

    for (let i = 0; i < files.length; i++) {
        const reader = new FileReader();
        reader.onload = function (event) {
            const preview = document.createElement("div");
            preview.className = "relative";
            preview.innerHTML = `
                        <img src="${
                            event.target.result
                        }" class="w-full h-24 object-cover rounded-lg">
                        <span class="absolute top-1 right-1 bg-black bg-opacity-50 text-white text-xs px-1 rounded">
                            ${i + 1}
                        </span>
                    `;
            previewContainer.appendChild(preview);
        };
        reader.readAsDataURL(files[i]);
    }

    const existingPreview = document.getElementById("file-preview");
    if (existingPreview) {
        existingPreview.replaceWith(previewContainer);
    } else {
        const uploadArea = document.querySelector('label[for="images"]');
        uploadArea.parentNode.insertBefore(
            previewContainer,
            uploadArea.nextSibling
        );
    }
    previewContainer.id = "file-preview";
});

const MAX_WIDTH = 1280;
const MAX_HEIGHT = 1280;
const imageInput = document.getElementById("images");
const placeholder = document.getElementById("upload-placeholder");
const uploadSection = document.getElementById("upload-section");
let fileList = [];

imageInput.addEventListener("change", async () => {
    const files = Array.from(imageInput.files);
    for (const file of files) {
        if (!file.type.startsWith("image/")) continue;

        const resized = await resizeImage(file, MAX_WIDTH, MAX_HEIGHT);
        fileList.push(resized);
    }

    renderPreviews();
    updateFileInput();
});

async function resizeImage(file, maxWidth, maxHeight) {
    return new Promise((resolve) => {
        const reader = new FileReader();
        reader.onload = (event) => {
            const img = new Image();
            img.onload = () => {
                let width = img.width;
                let height = img.height;

                if (width > maxWidth || height > maxHeight) {
                    const scale = Math.min(
                        maxWidth / width,
                        maxHeight / height
                    );
                    width *= scale;
                    height *= scale;
                }

                const canvas = document.createElement("canvas");
                canvas.width = width;
                canvas.height = height;
                const ctx = canvas.getContext("2d");
                ctx.drawImage(img, 0, 0, width, height);

                canvas.toBlob(
                    (blob) => {
                        const resizedFile = new File([blob], file.name, {
                            type: file.type,
                        });
                        resolve(resizedFile);
                    },
                    file.type,
                    0.8
                ); // 0.8 = 80% quality
            };
            img.src = event.target.result;
        };
        reader.readAsDataURL(file);
    });
}

function renderPreviews() {
    const existing = document.getElementById("file-preview");
    if (existing) existing.remove();

    const previewContainer = document.createElement("div");
    previewContainer.className =
        "mt-4 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4";
    previewContainer.id = "file-preview";

    fileList.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = (event) => {
            const wrapper = document.createElement("div");
            wrapper.className = "relative";
            wrapper.innerHTML = `
                    <img src="${event.target.result}" class="w-full h-40 md:h-48 object-cover rounded-lg shadow">
                    <button type="button" onclick="removeImage(${index})"
                        class="absolute top-1 right-1 bg-red-600 text-white rounded-full p-1 hover:bg-red-700 transition">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                `;
            previewContainer.appendChild(wrapper);
        };
        reader.readAsDataURL(file);
    });

    placeholder.classList.toggle("hidden", fileList.length > 0);
    uploadSection.appendChild(previewContainer);
}

function removeImage(index) {
    fileList.splice(index, 1);
    renderPreviews();
    updateFileInput();
}

function updateFileInput() {
    const dataTransfer = new DataTransfer();
    fileList.forEach((file) => dataTransfer.items.add(file));
    imageInput.files = dataTransfer.files;
}
