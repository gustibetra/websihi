/**
 * Agenda Manager JavaScript
 * Handles Choices.js initialization and event listeners for Agenda Management
 */

(function ($) {
    'use strict';

    let statusChoice = null;
    let perPageChoice = null;
    let periodChoice = null;
    let categoryChoice = null;
    let jurusanChoice = null;
    let editorInstance = null;
    let isDestroyingEditor = false;

    /**
     * Initialize CKEditor manually for modal
     */
    function initializeCKEditor() {
        const editorElement = document.getElementById('editor');
        if (!editorElement || editorInstance || isDestroyingEditor) return;

        const uploadUrl = editorElement.getAttribute('data-ckeditor-upload-url') || '/admin/news/upload-image';
        const initialContent = editorElement.getAttribute('data-ckeditor-content') || '';

        if (typeof DKApps !== 'undefined' && typeof DKApps.initCKEditor === 'function') {
            DKApps.initCKEditor('editor', initialContent, uploadUrl)
                .then(function(editor) {
                    editorInstance = editor;

                    editor.model.document.on('change:data', () => {
                        const content = editor.getData();
                        const textarea = document.getElementById('description');
                        if (textarea) {
                            textarea.value = content;
                            textarea.dispatchEvent(new Event('input', { bubbles: true }));
                        }
                    });
                })
                .catch(function(error) {
                    console.error('Failed to initialize CKEditor for agenda:', error);
                });
        }
    }

    /**
     * Destroy CKEditor instance
     */
    function destroyCKEditor() {
        if (!editorInstance || isDestroyingEditor) return;

        const instance = editorInstance;
        editorInstance = null;
        isDestroyingEditor = true;

        // Livewire can detach the source node before destroy runs.
        // In that case, skip destroy to avoid CKEditor internal errors.
        if (!instance.sourceElement || !instance.sourceElement.isConnected) {
            isDestroyingEditor = false;
            return;
        }

        Promise.resolve(instance.destroy())
            .catch(error => {
                console.warn('Skipping agenda CKEditor destroy due to detached DOM:', error);
            })
            .finally(() => {
                isDestroyingEditor = false;
            });
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
    let selectedAgendaIds = [];

    function initCheckboxHandlers() {
        // Select All checkbox
        $(document).on('change', '#selectAllCheckbox', function() {
            const isChecked = $(this).prop('checked');
            $('.agenda-checkbox').prop('checked', isChecked);
            updateSelectedItems();
        });

        // Individual checkboxes
        $(document).on('change', '.agenda-checkbox', function() {
            updateSelectedItems();
            
            // Update select all checkbox
            const totalCheckboxes = $('.agenda-checkbox').length;
            const checkedCheckboxes = $('.agenda-checkbox:checked').length;
            $('#selectAllCheckbox').prop('checked', totalCheckboxes === checkedCheckboxes);
        });
    }

    function updateSelectedItems() {
        selectedAgendaIds = [];
        $('.agenda-checkbox:checked').each(function() {
            selectedAgendaIds.push(parseInt($(this).val()));
        });

        // Update UI
        const count = selectedAgendaIds.length;
        $('#selectedCount').text(count);
        
        if (count > 0) {
            $('#bulkActionsBar').slideDown(200);
        } else {
            $('#bulkActionsBar').slideUp(200);
        }
    }

    function getSelectedIds() {
        return selectedAgendaIds;
    }

    /**
     * Bulk Action Handlers
     */
    window.handleBulkUpdateStatus = function(status) {
        const ids = getSelectedIds();
        if (ids.length === 0) {
            if (typeof showError === 'function') {
                showError('Pilih minimal satu agenda untuk diupdate');
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
                showError('Pilih minimal satu agenda untuk dihapus');
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
        } else if (confirm(`Apakah Anda yakin ingin menghapus ${ids.length} agenda?`)) {
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
        const message = `Agenda "${title}" akan dihapus secara permanen!`;
        
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
            if (confirm(`Apakah Anda yakin ingin menghapus agenda "${title}"?`)) {
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
        $('.agenda-checkbox').prop('checked', false);
        $('#selectAllCheckbox').prop('checked', false);
        selectedAgendaIds = [];
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
     * Listen for bulk action completed
     */
    if (window.Livewire) {
        document.addEventListener('livewire:initialized', () => {
            window.Livewire.on('bulk-action-completed', () => {
                resetCheckboxes();
            });

            window.Livewire.on('modal-opened', () => {
                setTimeout(() => {
                    initializeCKEditor();
                }, 300);
            });
        });

        window.Livewire.hook('morph.updated', () => {
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
