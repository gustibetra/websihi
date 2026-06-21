/**
 * Secretariat Manager JavaScript
 * Handles Choices.js initialization and event listeners
 */

(function ($) {
    'use strict';

    let divisionChoice = null;
    let statusChoice = null;
    let perPageChoice = null;
    let selectedSecretariatIds = [];

    /**
     * Initialize Choices.js for all select elements
     */
    function initializeChoices() {
        // Division Filter
        const $divisionFilter = $('#divisionFilter');
        if ($divisionFilter.length && !$divisionFilter[0].choices) {
            divisionChoice = new Choices($divisionFilter[0], {
                searchEnabled: false,
                itemSelectText: '',
                shouldSort: false,
            });

            $divisionFilter.on('change', function () {
                const $component = $(this).closest('[wire\\:id]');
                if ($component.length && window.Livewire) {
                    window.Livewire.find($component.attr('wire:id')).set('divisionFilter', $(this).val());
                }
            });
        }

        // Status Filter
        const $statusFilter = $('#statusFilter');
        if ($statusFilter.length && !$statusFilter[0].choices) {
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
        }

        // Per Page Filter
        const $perPageFilter = $('#perPageFilter');
        if ($perPageFilter.length && !$perPageFilter[0].choices) {
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
        }
    }

    /**
     * Checkbox Management
     */
    function initCheckboxHandlers() {
        // Select All checkbox
        $(document).on('change', '#selectAllCheckbox', function() {
            const isChecked = $(this).prop('checked');
            $('.secretariat-checkbox').prop('checked', isChecked);
            updateSelectedItems();
        });

        // Individual checkboxes
        $(document).on('change', '.secretariat-checkbox', function() {
            updateSelectedItems();
            
            const totalCheckboxes = $('.secretariat-checkbox').length;
            const checkedCheckboxes = $('.secretariat-checkbox:checked').length;
            $('#selectAllCheckbox').prop('checked', totalCheckboxes === checkedCheckboxes);
        });
    }

    function updateSelectedItems() {
        selectedSecretariatIds = [];
        $('.secretariat-checkbox:checked').each(function() {
            selectedSecretariatIds.push(parseInt($(this).val()));
        });

        const count = selectedSecretariatIds.length;
        $('#selectedCount').text(count);
        
        if (count > 0) {
            $('#bulkActionsBar').slideDown(200);
        } else {
            $('#bulkActionsBar').slideUp(200);
        }
    }

    function getSelectedIds() {
        return selectedSecretariatIds;
    }

    /**
     * Bulk Action Handlers
     */
    window.handleBulkUpdateStatus = function(status) {
        const ids = getSelectedIds();
        if (ids.length === 0) {
            if (typeof showError === 'function') {
                showError('Pilih minimal satu data untuk diupdate');
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
                showError('Pilih minimal satu data untuk dihapus');
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
        } else if (confirm(`Apakah Anda yakin ingin menghapus ${ids.length} data?`)) {
            const $component = $('[wire\\:id]').first();
            if ($component.length && window.Livewire) {
                const component = window.Livewire.find($component.attr('wire:id'));
                component.set('selectedItems', ids);
                component.call('bulkDelete');
            }
        }
    };

    /**
     * Reset checkboxes after bulk action
     */
    function resetCheckboxes() {
        $('.secretariat-checkbox').prop('checked', false);
        $('#selectAllCheckbox').prop('checked', false);
        selectedSecretariatIds = [];
        $('#bulkActionsBar').slideUp(200);
    }

    /**
     * Confirm delete action
     */
    window.confirmDelete = function (id, name) {
        const message = `Data "${name}" akan dihapus secara permanen!`;
        
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
            if (confirm(`Apakah Anda yakin ingin menghapus data "${name}"?`)) {
                const $component = $('[wire\\:id]').first();
                if ($component.length && window.Livewire) {
                    window.Livewire.find($component.attr('wire:id')).call('delete', id);
                }
            }
        }
    };

    /**
     * Initialize on page load
     */
    $(document).ready(function () {
        initializeChoices();
        initCheckboxHandlers();
        handleFlashMessages();
    });

    /**
     * Listen for bulk action completed
     */
    if (window.Livewire) {
        document.addEventListener('livewire:initialized', () => {
            window.Livewire.on('bulk-action-completed', () => {
                resetCheckboxes();
            });
        });
    }

    /**
     * Listen for show-toast event
     */
    window.addEventListener('show-toast', function (event) {
        const data = event.detail[0] || event.detail;
        const type = data.type || 'info';
        const message = data.message || 'Notification';
        
        if (typeof showToast === 'function') {
            showToast(message, type);
        } else {
            alert(message);
        }
    });

    /**
     * Handle flash messages
     */
    function handleFlashMessages() {
        const $successMsg = $('.flash-message-success');
        if ($successMsg.length) {
            const message = $successMsg.data('message');
            if (message && typeof showSuccess === 'function') {
                showSuccess(message);
            }
        }

        const $errorMsg = $('.flash-message-error');
        if ($errorMsg.length) {
            const message = $errorMsg.data('message');
            if (message && typeof showError === 'function') {
                showError(message);
            }
        }
    }

})(jQuery);
