// Portal Gallery Logic
document.addEventListener('DOMContentLoaded', () => {
    initGallery();
});

function initGallery() {
    const photoInput = document.getElementById('photo');
    const addPhotoBtn = document.getElementById('addPhotoBtn');
    const addPhotoBtnText = document.getElementById('addPhotoBtnText');
    const addPhotoBtnIcon = document.getElementById('addPhotoBtnIcon');
    const galleryGrid = document.getElementById('galleryGrid');
    const emptyGalleryState = document.getElementById('emptyGalleryState');
    const galleryAlert = document.getElementById('galleryAlert');

    // Only run if we are on the portal page where the gallery exists
    if (!photoInput) {
        return;
    }

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    function showAlert(message, type = 'success') {
        if (!galleryAlert) {
            alert(message);
            return;
        }

        galleryAlert.textContent = message;
        galleryAlert.className = type === 'success'
            ? 'mt-6 rounded-2xl border border-emerald-500/20 bg-emerald-500/10 px-5 py-4 text-sm text-emerald-400 block'
            : 'mt-6 rounded-2xl border border-red-500/20 bg-red-500/10 px-5 py-4 text-sm text-red-400 block';

        if (type === 'success') {
            setTimeout(() => {
                galleryAlert.classList.add('hidden');
            }, 6000);
        }
    }

    function setBtnLoading(isLoading) {
        if (!addPhotoBtn) return;
        addPhotoBtn.disabled = isLoading;
        if (isLoading) {
            if (addPhotoBtnIcon) {
                addPhotoBtnIcon.innerHTML = `
                    <svg class="h-4 w-4 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                `;
            }
            if (addPhotoBtnText) {
                addPhotoBtnText.textContent = 'Uploading...';
            }
        } else {
            if (addPhotoBtnIcon) {
                addPhotoBtnIcon.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                `;
            }
            if (addPhotoBtnText) {
                addPhotoBtnText.textContent = '+ Add Photo';
            }
        }
    }

    photoInput.addEventListener('change', async function () {
        const file = this.files[0];
        if (!file) return;

        // Validation
        const validTypes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!validTypes.includes(file.type)) {
            showAlert('Please select a valid image file (JPG, PNG, or WEBP).', 'error');
            this.value = '';
            return;
        }

        const maxSize = 5 * 1024 * 1024; // 5MB
        if (file.size > maxSize) {
            showAlert('Photo file size must not exceed 5MB.', 'error');
            this.value = '';
            return;
        }

        const formData = new FormData();
        formData.append('photo', file);

        setBtnLoading(true);

        try {
            const response = await fetch('/portal/gallery', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: formData,
            });

            const data = await response.json();

            if (!response.ok) {
                const errorMsg = data.message || (data.errors && Object.values(data.errors).flat().join(', ')) || 'Failed to upload photo.';
                throw new Error(errorMsg);
            }

            const photoUrl = data.photo;
            if (galleryGrid && photoUrl) {
                const itemDiv = document.createElement('div');
                itemDiv.className = 'gallery-item group relative aspect-square overflow-hidden rounded-2xl border border-white/10 bg-zinc-900 transition duration-300';
                itemDiv.setAttribute('data-photo', photoUrl);
                itemDiv.innerHTML = `
                    <img src="${photoUrl}" alt="Gallery photo" class="h-full w-full object-cover transition duration-500 group-hover:scale-110" loading="lazy">
                    <div class="absolute inset-0 flex items-end bg-gradient-to-t from-black/80 via-black/20 to-transparent opacity-0 transition duration-200 group-hover:opacity-100">
                        <div class="w-full p-3">
                            <button type="button" class="remove-photo-btn rounded-lg bg-red-600/90 px-3 py-1.5 text-xs font-semibold text-white shadow backdrop-blur transition hover:bg-red-500 disabled:opacity-50">
                                Remove
                            </button>
                        </div>
                    </div>
                `;

                const removeBtn = itemDiv.querySelector('.remove-photo-btn');
                removeBtn.addEventListener('click', () => {
                    deletePhoto(photoUrl, itemDiv, removeBtn);
                });

                galleryGrid.prepend(itemDiv);
                galleryGrid.classList.remove('hidden');
                galleryGrid.classList.add('grid');
                if (emptyGalleryState) {
                    emptyGalleryState.classList.add('hidden');
                }
            }

            showAlert('Photo added to gallery successfully!', 'success');

        } catch (error) {
            console.error('Upload error:', error);
            showAlert(error.message || 'Failed to upload photo.', 'error');
        } finally {
            photoInput.value = '';
            setBtnLoading(false);
        }
    });

    async function deletePhoto(photoUrl, cardElement, btn) {
        if (!confirm('Are you sure you want to remove this photo?')) {
            return;
        }

        btn.disabled = true;
        btn.textContent = 'Removing...';

        try {
            const response = await fetch('/portal/gallery', {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                },
                body: JSON.stringify({ photo: photoUrl }),
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.message || 'Failed to remove photo.');
            }

            cardElement.remove();

            if (galleryGrid && galleryGrid.querySelectorAll('.gallery-item').length === 0) {
                galleryGrid.classList.add('hidden');
                galleryGrid.classList.remove('grid');
                if (emptyGalleryState) {
                    emptyGalleryState.classList.remove('hidden');
                }
            }

            showAlert('Photo removed successfully.', 'success');

        } catch (error) {
            console.error('Delete error:', error);
            showAlert(error.message || 'Failed to remove photo.', 'error');
            btn.disabled = false;
            btn.textContent = 'Remove';
        }
    }

    // Expose for pre-rendered items in Blade
    window.deleteGalleryPhoto = function (photoUrl, btnElement) {
        const cardElement = btnElement.closest('.gallery-item');
        deletePhoto(photoUrl, cardElement, btnElement);
    };
}
