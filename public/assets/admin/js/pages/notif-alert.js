/**
 * Notification & Alert Helper
 * Centralized functions for SweetAlert2 (confirmations) and Bootstrap Toast (notifications)
 */

(function() {
    'use strict';

    /**
     * Show Toast Notification
     * @param {string} message - Message to display
     * @param {string} type - Type: 'success', 'error', 'warning', 'info'
     * @param {number} duration - Duration in milliseconds (default: 3000)
     */
    function showToast(message, type = 'success', duration = 3000) {
        // Tunggu sampai Bootstrap tersedia
        if (typeof bootstrap === 'undefined' || typeof bootstrap.Toast === 'undefined') {
            // Coba lagi setelah 100ms jika Bootstrap belum ter-load
            setTimeout(function() {
                showToast(message, type, duration);
            }, 100);
            return;
        }

        // Toast configuration based on type - menggunakan format template
        const config = {
            success: {
                icon: 'ri-checkbox-circle-line',
                borderClass: 'toast-border-success', // Warna success (hijau)
                title: 'Berhasil'
            },
            error: {
                icon: 'ri-error-warning-line',
                borderClass: 'toast-border-danger',
                title: 'Error'
            },
            warning: {
                icon: 'ri-alert-line',
                borderClass: 'toast-border-warning',
                title: 'Peringatan'
            },
            info: {
                icon: 'ri-information-line',
                borderClass: 'toast-border-info',
                title: 'Informasi'
            }
        };

        const toastConfig = config[type] || config.success;

        // Create toast HTML - menggunakan format seperti template
        const toastId = 'toast-' + Date.now() + '-' + Math.random().toString(36).substr(2, 9);
        const toastHTML = `
            <div id="${toastId}" class="toast ${toastConfig.borderClass} overflow-hidden mt-3" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 me-2">
                            <i class="${toastConfig.icon} align-middle"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-0">${message}</h6>
                        </div>
                    </div>
                </div>
            </div>
        `;

        // Get or create toast container - di pojok kanan atas
        let toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toast-container';
            toastContainer.className = 'toast-container';
            // Posisi di pojok kanan atas
            toastContainer.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999; min-width: 300px; max-width: 350px; pointer-events: none;';
            document.body.appendChild(toastContainer);
        }

        // Add toast to container
        toastContainer.insertAdjacentHTML('beforeend', toastHTML);

        // Initialize and show toast - gunakan setTimeout untuk memastikan DOM sudah di-update
        setTimeout(function() {
            const toastElement = document.getElementById(toastId);
            if (!toastElement) {
                console.error('Toast element not found');
                return;
            }

            // Pastikan Bootstrap Toast tersedia
            if (typeof bootstrap === 'undefined' || typeof bootstrap.Toast === 'undefined') {
                console.error('Bootstrap Toast is not available');
                // Fallback: show element manually dengan class show
                toastElement.style.pointerEvents = 'auto';
                toastElement.classList.add('show');
                setTimeout(function() {
                    toastElement.classList.remove('show');
                    setTimeout(function() {
                        toastElement.remove();
                        if (toastContainer && toastContainer.children.length === 0) {
                            toastContainer.remove();
                        }
                    }, 300);
                }, duration);
                return;
            }

            try {
                // Set pointer-events untuk toast element
                toastElement.style.pointerEvents = 'auto';
                
                // Initialize Bootstrap Toast
                const toast = new bootstrap.Toast(toastElement, {
                    autohide: true,
                    delay: duration
                });

                // Show toast
                toast.show();

                // Remove toast element after it's hidden
                toastElement.addEventListener('hidden.bs.toast', function() {
                    toastElement.remove();
                    // Remove container if empty
                    if (toastContainer && toastContainer.children.length === 0) {
                        toastContainer.remove();
                    }
                });
            } catch (e) {
                console.error('Error initializing toast:', e);
                // Fallback: show element manually
                toastElement.style.pointerEvents = 'auto';
                toastElement.classList.add('show');
                setTimeout(function() {
                    toastElement.classList.remove('show');
                    setTimeout(function() {
                        toastElement.remove();
                        if (toastContainer && toastContainer.children.length === 0) {
                            toastContainer.remove();
                        }
                    }, 300);
                }, duration);
            }
        }, 100);
    }

    /**
     * Show Confirmation Dialog with SweetAlert2
     * @param {string} title - Dialog title
     * @param {string} text - Dialog message
     * @param {string} icon - Icon type: 'warning', 'question', 'info', 'error'
     * @param {string} confirmButtonText - Confirm button text
     * @param {string} cancelButtonText - Cancel button text
     * @param {string} confirmButtonColor - Confirm button color
     * @returns {Promise} Promise that resolves to result object
     */
    function showConfirm(title, text, icon = 'question', confirmButtonText = 'Ya', cancelButtonText = 'Batal', confirmButtonColor = '#3b82f6') {
        return Swal.fire({
            title: title,
            text: text,
            icon: icon,
            showCancelButton: true,
            confirmButtonColor: confirmButtonColor,
            cancelButtonColor: '#6c757d',
            confirmButtonText: confirmButtonText,
            cancelButtonText: cancelButtonText,
            allowOutsideClick: false,
            allowEscapeKey: true
        });
    }

    /**
     * Show Delete Confirmation Dialog (Template Style with Lord Icon)
     * @param {string} text - Confirmation message
     * @param {number} count - Number of items (optional)
     * @returns {Promise} Promise that resolves to result object
     */
    function showDeleteConfirm(text = null, count = null) {
        // Build message
        const title = count ? `Apakah Anda yakin ingin menghapus ${count} item yang dipilih?` : (text || 'Apakah Anda yakin ingin menghapus item ini?');
        const subtitle = count ? '' : (text ? '' : 'Tindakan ini tidak dapat dibatalkan.');
        
        // Build HTML content dengan lord-icon seperti template
        const htmlContent = `
            <div class="mt-3">
                <lord-icon 
                    src="https://cdn.lordicon.com/gsqxdxog.json" 
                    trigger="loop" 
                    colors="primary:#f7b84b,secondary:#f06548" 
                    style="width:100px;height:100px">
                </lord-icon>
                <div class="mt-4 pt-2 fs-15 mx-5">
                    <h4>Apakah Anda Yakin?</h4>
                    <p class="text-muted mx-4 mb-0">${title}</p>
                    ${subtitle ? `<p class="text-muted mx-4 mb-0 mt-2">${subtitle}</p>` : ''}
                </div>
            </div>
        `;

        return Swal.fire({
            html: htmlContent,
            showCancelButton: true,
            customClass: {
                confirmButton: 'btn btn-primary w-xs me-2 mb-1',
                cancelButton: 'btn btn-danger w-xs mb-1'
            },
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            buttonsStyling: false,
            showCloseButton: true,
            allowOutsideClick: false,
            allowEscapeKey: true
        });
    }

    /**
     * Show Success Toast
     * @param {string} message - Success message
     */
    function showSuccess(message) {
        showToast(message, 'success');
    }

    /**
     * Show Error Toast
     * @param {string} message - Error message
     */
    function showError(message) {
        showToast(message, 'error');
    }

    /**
     * Show Warning Toast
     * @param {string} message - Warning message
     */
    function showWarning(message) {
        showToast(message, 'warning');
    }

    /**
     * Show Info Toast
     * @param {string} message - Info message
     */
    function showInfo(message) {
        showToast(message, 'info');
    }

    /**
     * Show Bulk Status Change Confirmation
     * @param {string} status - Status name (published, draft, archived)
     * @param {number} count - Number of items
     * @returns {Promise} Promise that resolves to result object
     */
    function showBulkStatusConfirm(status, count) {
        const statusLabels = {
            published: { label: 'Published', color: '#10b981' },
            draft: { label: 'Draft', color: '#f59e0b' },
            archived: { label: 'Archived', color: '#6c757d' }
        };
        
        const config = statusLabels[status] || { label: status, color: '#3b82f6' };
        
        return showConfirm(
            'Konfirmasi',
            `Apakah Anda yakin ingin mengubah status ${count} item menjadi ${config.label}?`,
            'question',
            'Ya, Ubah Status',
            'Batal',
            config.color
        );
    }

    /**
     * Show Bulk Featured Toggle Confirmation
     * @param {number} count - Number of items
     * @returns {Promise} Promise that resolves to result object
     */
    function showBulkFeaturedConfirm(count) {
        return showConfirm(
            'Konfirmasi',
            `Apakah Anda yakin ingin mengubah featured status ${count} item?`,
            'question',
            'Ya, Ubah Status',
            'Batal',
            '#3b82f6'
        );
    }

    /**
     * Show Bulk Delete Confirmation
     * @param {number} count - Number of items
     * @returns {Promise} Promise that resolves to result object
     */
    function showBulkDeleteConfirm(count) {
        return showDeleteConfirm(null, count);
    }

    /**
     * Show Individual Delete Confirmation (with callback)
     * @param {string} message - Confirmation message
     * @param {Function} onConfirm - Callback function when confirmed
     */
    function confirmDeleteWithCallback(message, onConfirm) {
        if (typeof onConfirm !== 'function') {
            console.error('onConfirm must be a function');
            return;
        }
        
        showDeleteConfirm(message).then((result) => {
            if (result.isConfirmed) {
                onConfirm();
            }
        });
    }

    // Expose functions to global scope
    window.NotifAlert = {
        toast: showToast,
        confirm: showConfirm,
        deleteConfirm: showDeleteConfirm,
        bulkStatusConfirm: showBulkStatusConfirm,
        bulkFeaturedConfirm: showBulkFeaturedConfirm,
        bulkDeleteConfirm: showBulkDeleteConfirm,
        confirmDeleteWithCallback: confirmDeleteWithCallback,
        success: showSuccess,
        error: showError,
        warning: showWarning,
        info: showInfo
    };

    // Also expose as shorter aliases
    window.showToast = showToast;
    window.showConfirm = showConfirm;
    window.showDeleteConfirm = showDeleteConfirm;
    window.showBulkStatusConfirm = showBulkStatusConfirm;
    window.showBulkFeaturedConfirm = showBulkFeaturedConfirm;
    window.showBulkDeleteConfirm = showBulkDeleteConfirm;
    window.confirmDeleteWithCallback = confirmDeleteWithCallback;
    window.showSuccess = showSuccess;
    window.showError = showError;
    window.showWarning = showWarning;
    window.showInfo = showInfo;

})();

