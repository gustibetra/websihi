/**
 * Announcement Manager JavaScript
 * Handles Choices.js initialization, CKEditor, and event listeners for Announcement Management
 */

(function ($) {
    'use strict';

    let statusChoice = null;
    let perPageChoice = null;
    let periodChoice = null;
    let categoryChoice = null;
    let jurusanChoice = null;
    let editorInstance = null;

    /**
     * Initialize CKEditor manually for modal
     */
    function initializeCKEditor() {
        const editorElement = document.getElementById('editor');
        if (!editorElement) return;
        
        // Check if already initialized
        if (editorInstance) {
            return;
        }
        
        const uploadUrl = editorElement.getAttribute('data-ckeditor-upload-url') || '/admin/announcements/upload-image';
        const initialContent = editorElement.getAttribute('data-ckeditor-content') || '';
        
        // Use DKApps to initialize
        if (typeof DKApps !== 'undefined' && typeof DKApps.initCKEditor === 'function') {
            DKApps.initCKEditor('editor', initialContent, uploadUrl)
                .then(function(editor) {
                    editorInstance = editor;
                    console.log('CKEditor initialized for announcement');
                    
                    // Sync with Livewire on change
                    editor.model.document.on('change:data', () => {
                        const content = editor.getData();
                        const textarea = document.getElementById('content');
                        if (textarea) {
                            textarea.value = content;
                            // Trigger Livewire update
                            textarea.dispatchEvent(new Event('input', { bubbles: true }));
                        }
                    });
                })
                .catch(function(error) {
                    console.error('Failed to initialize CKEditor:', error);
                });
        }
    }
    
    /**
     * Destroy CKEditor instance
     */
    function destroyCKEditor() {
        if (editorInstance) {
            editorInstance.destroy()
                .then(() => {
                    editorInstance = null;
                    console.log('CKEditor destroyed');
                })
                .catch(error => {
                    console.error('Error destroying CKEditor:', error);
                });
        }
    }


    /**
     * Initialize Choices.js for all select elements
     */
    function initializeChoices() {
        // Category Filter
        const $categoryFilter = $('#categoryFilter');
        if ($categoryFilter.length) {
            if ($categoryFilter[0].choices || $categoryFilter.hasClass('choices-initialized')) {
                return;
            }
            
            categoryChoice = new Choices($categoryFilter[0], {
                searchEnabled: false,
                itemSelectText: '',
                shouldSort: false,
            });

            $categoryFilter.on('change', function () {
                const $component = $(this).closest('[wire\\:id]');
                if ($component.length && window.Livewire) {
                    window.Livewire.find($component.attr('wire:id')).set('categoryFilter', $(this).val());
                }
            });

            $categoryFilter.addClass('choices-initialized');
        }

        // Jurusan Filter
        const $jurusanFilter = $('#jurusanFilter');
        if ($jurusanFilter.length) {
            if ($jurusanFilter[0].choices || $jurusanFilter.hasClass('choices-initialized')) {
                return;
            }
            
            jurusanChoice = new Choices($jurusanFilter[0], {
                searchEnabled: true,
                itemSelectText: '',
                shouldSort: false,
            });

            $jurusanFilter.on('change', function () {
                const $component = $(this).closest('[wire\\:id]');
                if ($component.length && window.Livewire) {
                    window.Livewire.find($component.attr('wire:id')).set('jurusanFilter', $(this).val());
                }
            });

            $jurusanFilter.addClass('choices-initialized');
        }

        // Period Filter
        const $periodFilter = $('#periodFilter');
        if ($periodFilter.length) {
            if ($periodFilter[0].choices || $periodFilter.hasClass('choices-initialized')) {
                return;
            }
            
            periodChoice = new Choices($periodFilter[0], {
                searchEnabled: false,
                itemSelectText: '',
                shouldSort: false,
            });

            $periodFilter.on('change', function () {
                const $component = $(this).closest('[wire\\:id]');
                if ($component.length && window.Livewire) {
                    window.Livewire.find($component.attr('wire:id')).set('periodFilter', $(this).val());
                }
            });

            $periodFilter.addClass('choices-initialized');
        }

        // Status Filter
        const $statusFilter = $('#statusFilter');
        if ($statusFilter.length) {
            if ($statusFilter[0].choices || $statusFilter.hasClass('choices-initialized')) {
                return;
            }
            
            statusChoice = new Choices($statusFilter[0], {
                searchEnabled: false,
                itemSelectText: '',
                shouldSort: false,
            });

            $statusFilter.on('change', function () {
                const $component = $(this).closest('[wire\\:id]');
                if ($component.length && window.Livewire) {
                    window.Livewire.find($component.attr('wire:id')).set('statusFilter', $(this).val());
                }
            });

            $statusFilter.addClass('choices-initialized');
        }

        // Per Page Filter
        const $perPageFilter = $('#perPageFilter');
        if ($perPageFilter.length) {
            if ($perPageFilter[0].choices || $perPageFilter.hasClass('choices-initialized')) {
                return;
            }
            
            perPageChoice = new Choices($perPageFilter[0], {
                searchEnabled: false,
                itemSelectText: '',
                shouldSort: false,
            });

            $perPageFilter.on('change', function () {
                const $component = $(this).closest('[wire\\:id]');
                if ($component.length && window.Livewire) {
                    window.Livewire.find($component.attr('wire:id')).set('perPage', parseInt($(this).val()));
                }
            });

            $perPageFilter.addClass('choices-initialized');
        }
    }

    /**
     * Get Livewire component
     */
    function getLivewireComponent() {
        if (!window.Livewire || !window.Livewire.find) {
            return null;
        }
        const livewireElement = document.querySelector('[wire\\:id]');
        const componentId = livewireElement ? livewireElement.getAttribute('wire:id') : null;
        if (!componentId) {
            return null;
        }
        try {
            return window.Livewire.find(componentId);
        } catch (e) {
            console.warn('Error finding Livewire component:', e);
            return null;
        }
    }

    /**
     * Destroy Choices.js instances
     */
    function destroyChoices() {
        if (categoryChoice) {
            categoryChoice.destroy();
            categoryChoice = null;
        }
        if (jurusanChoice) {
            jurusanChoice.destroy();
            jurusanChoice = null;
        }
        if (periodChoice) {
            periodChoice.destroy();
            periodChoice = null;
        }
        if (statusChoice) {
            statusChoice.destroy();
            statusChoice = null;
        }
        if (perPageChoice) {
            perPageChoice.destroy();
            perPageChoice = null;
        }

        $('.choices-initialized').removeClass('choices-initialized');
    }


    /**
     * Checkbox Management
     */
    let selectedAnnouncementIds = [];

    function initCheckboxHandlers() {
        // Select All checkbox
        $(document).on('change', '#selectAllCheckbox', function() {
            const isChecked = $(this).prop('checked');
            $('.announcement-checkbox').prop('checked', isChecked);
            updateSelectedItems();
        });

        // Individual checkboxes
        $(document).on('change', '.announcement-checkbox', function() {
            updateSelectedItems();
            
            // Update select all checkbox
            const totalCheckboxes = $('.announcement-checkbox').length;
            const checkedCheckboxes = $('.announcement-checkbox:checked').length;
            $('#selectAllCheckbox').prop('checked', totalCheckboxes === checkedCheckboxes);
        });
    }

    function updateSelectedItems() {
        selectedAnnouncementIds = [];
        $('.announcement-checkbox:checked').each(function() {
            selectedAnnouncementIds.push(parseInt($(this).val()));
        });

        // Update UI
        const count = selectedAnnouncementIds.length;
        $('#selectedCount').text(count);
        
        if (count > 0) {
            $('#bulkActionsBar').slideDown(200);
        } else {
            $('#bulkActionsBar').slideUp(200);
        }
    }

    function getSelectedIds() {
        return selectedAnnouncementIds;
    }

    /**
     * Bulk Action Handlers
     */
    window.handleBulkUpdateStatus = function(status) {
        const ids = getSelectedIds();
        if (ids.length === 0) {
            if (typeof showError === 'function') {
                showError('Pilih minimal satu pengumuman untuk diupdate');
            }
            return;
        }

        const $component = $('[wire\\:id]').first();
        if ($component.length && window.Livewire) {
            const component = window.Livewire.find($component.attr('wire:id'));
            component.set('selectedItems', ids);
            component.call('bulkUpdateStatus', status);
        }
    };

    window.handleBulkDelete = function() {
        const ids = getSelectedIds();
        if (ids.length === 0) {
            if (typeof showError === 'function') {
                showError('Pilih minimal satu pengumuman untuk dihapus');
            }
            return;
        }

        if (typeof showBulkDeleteConfirm === 'function') {
            showBulkDeleteConfirm(ids.length).then((result) => {
                if (result.isConfirmed) {
                    const $component = $('[wire\\:id]').first();
                    if ($component.length && window.Livewire) {
                        const component = window.Livewire.find($component.attr('wire:id'));
                        component.set('selectedItems', ids);
                        component.call('bulkDelete');
                    }
                }
            });
        } else if (confirm(`Apakah Anda yakin ingin menghapus ${ids.length} pengumuman?`)) {
            const $component = $('[wire\\:id]').first();
            if ($component.length && window.Livewire) {
                const component = window.Livewire.find($component.attr('wire:id'));
                component.set('selectedItems', ids);
                component.call('bulkDelete');
            }
        }
    };

    /**
     * Confirm delete action
     */
    window.confirmDelete = function (id, title) {
        const message = `Pengumuman "${title}" akan dihapus secara permanen!`;
        
        if (typeof showDeleteConfirm === 'function') {
            showDeleteConfirm(message).then((result) => {
                if (result.isConfirmed) {
                    const $component = $('[wire\\:id]').first();
                    if ($component.length && window.Livewire) {
                        window.Livewire.find($component.attr('wire:id')).call('delete', id);
                    }
                }
            });
        } else {
            if (confirm(`Apakah Anda yakin ingin menghapus pengumuman "${title}"?`)) {
                const $component = $('[wire\\:id]').first();
                if ($component.length && window.Livewire) {
                    window.Livewire.find($component.attr('wire:id')).call('delete', id);
                }
            }
        }
    };

    /**
     * Reset checkboxes after bulk action
     */
    function resetCheckboxes() {
        $('.announcement-checkbox').prop('checked', false);
        $('#selectAllCheckbox').prop('checked', false);
        selectedAnnouncementIds = [];
        $('#bulkActionsBar').slideUp(200);
    }

    /**
     * Handle flash messages
     */
    function handleFlashMessages() {
        // Success message
        const $successMsg = $('.flash-message-success');
        if ($successMsg.length) {
            const message = $successMsg.data('message');
            if (message) {
                if (typeof showSuccess === 'function') {
                    showSuccess(message);
                } else if (typeof showToast === 'function') {
                    showToast(message, 'success');
                }
                // Remove the element after showing to prevent duplicate notifications
                $successMsg.remove();
            }
        }

        // Error message
        const $errorMsg = $('.flash-message-error');
        if ($errorMsg.length) {
            const message = $errorMsg.data('message');
            if (message) {
                if (typeof showError === 'function') {
                    showError(message);
                } else if (typeof showToast === 'function') {
                    showToast(message, 'error');
                }
                // Remove the element after showing to prevent duplicate notifications
                $errorMsg.remove();
            }
        }
    }


    /**
     * Initialize slug field auto-generation
     */
    function initializeSlugField() {
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');
        
        if (titleInput && slugInput) {
            titleInput.addEventListener('input', function() {
                // Only auto-generate if slug is empty or was auto-generated
                if (!slugInput.value || slugInput.dataset.autoGenerated === 'true') {
                    const slug = this.value
                        .toLowerCase()
                        .replace(/[^a-z0-9\s-]/g, '') // Remove special characters
                        .replace(/\s+/g, '-')          // Replace spaces with -
                        .replace(/-+/g, '-')           // Replace multiple - with single -
                        .replace(/^-+|-+$/g, '');      // Remove leading/trailing -
                    
                    slugInput.value = slug;
                    slugInput.dataset.autoGenerated = 'true';
                    
                    // Trigger Livewire update
                    slugInput.dispatchEvent(new Event('input', { bubbles: true }));
                }
            });
            
            slugInput.addEventListener('input', function() {
                // Mark as manually edited
                if (this.value !== '') {
                    this.dataset.autoGenerated = 'false';
                }
            });
        }
    }

    /**
     * Initialize on page load
     */
    $(document).ready(function () {
        initializeChoices();
        handleFlashMessages();
        initCheckboxHandlers();
    });

    /**
     * Re-initialize after Livewire updates
     */
    $(document).on('livewire:navigated', function () {
        destroyChoices();
        setTimeout(function() {
            initializeChoices();
        }, 100);
    });

    /**
     * Listen for Livewire load event
     */
    if (window.Livewire) {
        window.Livewire.hook('morph.updated', () => {
            setTimeout(function() {
                initializeChoices();
                handleFlashMessages(); // Re-check flash messages after update
            }, 100);
        });
    }

    /**
     * Listen for bulk action completed and modal events
     */
    if (window.Livewire) {
        document.addEventListener('livewire:initialized', () => {
            window.Livewire.on('bulk-action-completed', () => {
                resetCheckboxes();
            });
            
            // Listen for modal opened event to initialize CKEditor and slug field
            window.Livewire.on('modal-opened', () => {
                setTimeout(() => {
                    initializeCKEditor();
                    initializeSlugField();
                }, 300);
            });
        });
        
        // Destroy CKEditor when modal closes
        window.Livewire.hook('morph.updated', () => {
            // Check if modal is closed
            const modal = document.querySelector('.modal.show');
            if (!modal) {
                destroyCKEditor();
            }
        });
    }

    /**
     * Listen for show-toast event from Livewire
     */
    window.addEventListener('show-toast', function (event) {
        const data = event.detail[0] || event.detail;
        const type = data.type || 'info';
        const message = data.message || 'Notification';
        
        if (typeof showToast === 'function') {
            showToast(message, type);
        } else if (typeof NotifAlert !== 'undefined' && typeof NotifAlert.toast === 'function') {
            NotifAlert.toast(message, type);
        } else {
            alert(message);
        }
    });

    /**
     * Listen for Livewire message.processed event
     * This fires after every Livewire request completes
     */
    document.addEventListener('livewire:initialized', () => {
        Livewire.hook('message.processed', (message, component) => {
            // Re-check flash messages after every Livewire action
            setTimeout(() => {
                handleFlashMessages();
            }, 50);
        });
    });

})(jQuery);
