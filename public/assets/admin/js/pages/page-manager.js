/**
 * Page Manager JavaScript
 * Handles Choices.js filters, bulk actions, and event listeners
 */

(function ($) {
    'use strict';

    let typeChoice = null;
    let jurusanChoice = null;
    let periodChoice = null;
    let statusChoice = null;

    /**
     * Initialize Choices.js for filter selects
     */
    function initializeChoices() {
        // Type Filter
        const $typeFilter = $('#typeFilter');
        if ($typeFilter.length && !$typeFilter.hasClass('choices-initialized')) {
            typeChoice = new Choices($typeFilter[0], {
                searchEnabled: false,
                itemSelectText: '',
                shouldSort: false,
            });

            $typeFilter.on('change', function () {
                const $component = $(this).closest('[wire\\:id]');
                if ($component.length && window.Livewire) {
                    window.Livewire.find($component.attr('wire:id')).set('typeFilter', $(this).val());
                }
            });

            $typeFilter.addClass('choices-initialized');
        }

        // Jurusan Filter
        const $jurusanFilter = $('#jurusanFilter');
        if ($jurusanFilter.length && !$jurusanFilter.hasClass('choices-initialized')) {
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
        if ($periodFilter.length && !$periodFilter.hasClass('choices-initialized')) {
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
        if ($statusFilter.length && !$statusFilter.hasClass('choices-initialized')) {
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
    }

    /**
     * Destroy Choices.js instances
     */
    function destroyChoices() {
        if (typeChoice) {
            typeChoice.destroy();
            typeChoice = null;
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

        $('.choices-initialized').removeClass('choices-initialized');
    }

    /**
     * Initialize bulk action checkboxes
     */
    function initializeBulkActions() {
        const $selectAll = $('#selectAllCheckbox');
        const $checkboxes = $('.page-checkbox');
        const $bulkBar = $('#bulkActionsBar');
        const $selectedCount = $('#selectedCount');

        // Select all checkbox
        $selectAll.off('change').on('change', function () {
            const isChecked = $(this).is(':checked');
            $checkboxes.prop('checked', isChecked);
            updateBulkActionsBar();
        });

        // Individual checkboxes
        $checkboxes.off('change').on('change', function () {
            updateBulkActionsBar();
            
            // Update select all checkbox
            const allChecked = $checkboxes.length === $checkboxes.filter(':checked').length;
            $selectAll.prop('checked', allChecked);
        });

        function updateBulkActionsBar() {
            const checkedCount = $checkboxes.filter(':checked').length;
            $selectedCount.text(checkedCount);
            
            if (checkedCount > 0) {
                $bulkBar.slideDown();
            } else {
                $bulkBar.slideUp();
            }
        }
    }

    /**
     * Handle bulk update status
     */
    window.handleBulkUpdateStatus = function (status) {
        const $checkboxes = $('.page-checkbox:checked');
        const ids = $checkboxes.map(function () {
            return parseInt($(this).val());
        }).get();

        if (ids.length === 0) {
            NotifAlert.error('Pilih setidaknya satu halaman');
            return;
        }

        const $component = $('[wire\\:id]').first();
        if ($component.length && window.Livewire) {
            const component = window.Livewire.find($component.attr('wire:id'));
            component.set('selectedItems', ids);
            component.call('bulkUpdateStatus', status);
        }
    };

    /**
     * Handle bulk delete
     */
    window.handleBulkDelete = function () {
        const $checkboxes = $('.page-checkbox:checked');
        const ids = $checkboxes.map(function () {
            return parseInt($(this).val());
        }).get();

        if (ids.length === 0) {
            NotifAlert.error('Pilih setidaknya satu halaman');
            return;
        }

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
    };

    /**
     * Confirm delete action
     */
    window.confirmDelete = function (id, title) {
        const message = `Halaman "${title}" akan dihapus secara permanen!`;
        
        showDeleteConfirm(message).then((result) => {
            if (result.isConfirmed) {
                const $component = $('[wire\\:id]').first();
                if ($component.length && window.Livewire) {
                    window.Livewire.find($component.attr('wire:id')).call('delete', id);
                }
            }
        });
    };

    /**
     * Handle flash messages
     */
    function handleFlashMessages() {
        const $successMsg = $('.flash-message-success');
        if ($successMsg.length) {
            const message = $successMsg.data('message');
            if (message) {
                NotifAlert.success(message);
                $successMsg.remove(); // Remove after showing to prevent duplicate
            }
        }

        const $errorMsg = $('.flash-message-error');
        if ($errorMsg.length) {
            const message = $errorMsg.data('message');
            if (message) {
                NotifAlert.error(message);
                $errorMsg.remove(); // Remove after showing to prevent duplicate
            }
        }
    }

    /**
     * Reset checkboxes after bulk action
     */
    function resetCheckboxes() {
        $('.page-checkbox, #selectAllCheckbox').prop('checked', false);
        $('#bulkActionsBar').slideUp();
    }

    /**
     * Initialize on page load
     */
    $(document).ready(function () {
        initializeChoices();
        initializeBulkActions();
        handleFlashMessages();
    });

    /**
     * Re-initialize after Livewire updates
     */
    if (window.Livewire) {
        window.Livewire.hook('morph.updated', () => {
            setTimeout(function () {
                initializeChoices();
                initializeBulkActions();
                handleFlashMessages();
            }, 100);
        });

        // Listen for bulk action completed event
        document.addEventListener('livewire:initialized', () => {
            window.Livewire.on('bulk-action-completed', () => {
                resetCheckboxes();
            });
        });
    }

})(jQuery);
