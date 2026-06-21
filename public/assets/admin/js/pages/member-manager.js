/**
 * User Manager JavaScript
 * Handles Choices.js initialization and event listeners for User Management
 */

(function ($) {
    'use strict';

    let statusChoice = null;
    let perPageChoice = null;
    let periodChoice = null;
    let fractionChoice = null;

    /**
     * Initialize Choices.js for all select elements
     */
    function initializeChoices() {
        // Period Filter
        const $periodFilter = $('#periodFilter');
        if ($periodFilter.length) {
            // Skip if already initialized (check for Choices instance)
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

        // Fraction Filter
        const $fractionFilter = $('#fractionFilter');
        if ($fractionFilter.length) {
            // Skip if already initialized
            if ($fractionFilter[0].choices || $fractionFilter.hasClass('choices-initialized')) {
                return;
            }
            
            fractionChoice = new Choices($fractionFilter[0], {
                searchEnabled: false,
                itemSelectText: '',
                shouldSort: false,
            });

            $fractionFilter.on('change', function () {
                const $component = $(this).closest('[wire\\:id]');
                if ($component.length && window.Livewire) {
                    window.Livewire.find($component.attr('wire:id')).set('fractionFilter', $(this).val());
                }
            });

            $fractionFilter.addClass('choices-initialized');
        }

        // Status Filter
        const $statusFilter = $('#statusFilter');
        if ($statusFilter.length) {
            // Skip if already initialized
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
            // Skip if already initialized
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
     * Initialize Flatpickr for date inputs
     */
    function initializeFlatpickr() {
        const component = getLivewireComponent();
        if (!component) return;
        
        const birthDateInput = document.getElementById('birth_date');
        
        if (birthDateInput && !birthDateInput._flatpickr) {
            flatpickr(birthDateInput, {
                dateFormat: 'Y-m-d',
                allowInput: true,
                defaultDate: component.get('form.birth_date') || null,
                onChange: function(_selectedDates, dateStr) {
                    component.set('form.birth_date', dateStr);
                }
            });
        }
    }

    /**
     * Update flatpickr date when form data changes
     */
    function updateFlatpickrDate() {
        const component = getLivewireComponent();
        if (!component) return;
        
        const birthDateInput = document.getElementById('birth_date');
        
        if (birthDateInput && birthDateInput._flatpickr) {
            birthDateInput._flatpickr.setDate(component.get('form.birth_date') || null);
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
        if (periodChoice) {
            periodChoice.destroy();
            periodChoice = null;
        }
        if (fractionChoice) {
            fractionChoice.destroy();
            fractionChoice = null;
        }
        if (statusChoice) {
            statusChoice.destroy();
            statusChoice = null;
        }
        if (perPageChoice) {
            perPageChoice.destroy();
            perPageChoice = null;
        }

        // Remove initialized class
        $('.choices-initialized').removeClass('choices-initialized');
    }

    /**
     * Reinitialize fraction filter choices
     */
    function reinitializeFractionFilter() {
        const $fractionFilter = $('#fractionFilter');
        if (!$fractionFilter.length) return;
        
        // Destroy existing instance
        if (fractionChoice) {
            try {
                fractionChoice.destroy();
            } catch (e) {
                console.warn('Error destroying fraction choice:', e);
            }
            fractionChoice = null;
        }
        
        // Remove initialized class
        $fractionFilter.removeClass('choices-initialized');
        
        // Small delay to ensure DOM is updated
        setTimeout(() => {
            if (!$fractionFilter.length || $fractionFilter.hasClass('choices-initialized')) {
                return;
            }
            
            // Reinitialize
            fractionChoice = new Choices($fractionFilter[0], {
                searchEnabled: false,
                itemSelectText: '',
                shouldSort: false,
            });

            $fractionFilter.on('change', function () {
                const $component = $(this).closest('[wire\\:id]');
                if ($component.length && window.Livewire) {
                    window.Livewire.find($component.attr('wire:id')).set('fractionFilter', $(this).val());
                }
            });

            $fractionFilter.addClass('choices-initialized');
        }, 50);
    }

    /**
     * Update period filter value
     */
    function updatePeriodFilterValue() {
        const component = getLivewireComponent();
        if (!component) return;
        
        const periodValue = component.get('periodFilter');
        const $periodFilter = $('#periodFilter');
        
        if ($periodFilter.length && periodChoice) {
            periodChoice.setChoiceByValue(periodValue);
        }
    }

    /**
     * Destroy Flatpickr instances
     */
    function destroyFlatpickr() {
        const birthDateInput = document.getElementById('birth_date');
        
        if (birthDateInput && birthDateInput._flatpickr) {
            birthDateInput._flatpickr.destroy();
        }
    }

    /**
     * Checkbox Management
     */
    let selectedMemberIds = [];

    function initCheckboxHandlers() {
        // Select All checkbox
        $(document).on('change', '#selectAllCheckbox', function() {
            const isChecked = $(this).prop('checked');
            $('.member-checkbox').prop('checked', isChecked);
            updateSelectedItems();
        });

        // Individual checkboxes
        $(document).on('change', '.member-checkbox', function() {
            updateSelectedItems();
            
            // Update select all checkbox
            const totalCheckboxes = $('.member-checkbox').length;
            const checkedCheckboxes = $('.member-checkbox:checked').length;
            $('#selectAllCheckbox').prop('checked', totalCheckboxes === checkedCheckboxes);
        });
    }

    function updateSelectedItems() {
        selectedMemberIds = [];
        $('.member-checkbox:checked').each(function() {
            selectedMemberIds.push(parseInt($(this).val()));
        });

        // Update UI
        const count = selectedMemberIds.length;
        $('#selectedCount').text(count);
        
        if (count > 0) {
            $('#bulkActionsBar').slideDown(200);
        } else {
            $('#bulkActionsBar').slideUp(200);
        }
    }

    function getSelectedIds() {
        return selectedMemberIds;
    }

    /**
     * Export Members
     */
    window.exportMembers = function() {
        // TODO: Implement export functionality
        if (typeof showToast === 'function') {
            showToast('Fitur export akan segera tersedia', 'info');
        } else {
            alert('Fitur export akan segera tersedia');
        }
    };

    /**
     * Open Import Modal
     */
    window.openImportModal = function() {
        // TODO: Implement import functionality
        if (typeof showToast === 'function') {
            showToast('Fitur import akan segera tersedia', 'info');
        } else {
            alert('Fitur import akan segera tersedia');
        }
    };

    /**
     * Bulk Action Handlers
     */
    window.handleBulkClone = function() {
        const ids = getSelectedIds();
        if (ids.length === 0) {
            if (typeof showError === 'function') {
                showError('Pilih minimal satu anggota untuk di-clone');
            }
            return;
        }

        const $component = $('[wire\\:id]').first();
        if ($component.length && window.Livewire) {
            const component = window.Livewire.find($component.attr('wire:id'));
            component.set('selectedItems', ids);
            component.call('openBulkCloneModal');
        }
    };

    window.handleBulkUpdateStatus = function(status) {
        const ids = getSelectedIds();
        if (ids.length === 0) {
            if (typeof showError === 'function') {
                showError('Pilih minimal satu anggota untuk diupdate');
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
                showError('Pilih minimal satu anggota untuk dihapus');
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
        } else if (confirm(`Apakah Anda yakin ingin menghapus ${ids.length} anggota?`)) {
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
     * Using notif-alert.js showDeleteConfirm
     */
    window.confirmDelete = function (id, name) {
        const message = `Anggota "${name}" akan dihapus secara permanen!`;
        
        // Use showDeleteConfirm from notif-alert.js
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
            // Fallback to native confirm
            if (confirm(`Apakah Anda yakin ingin menghapus anggota "${name}"?`)) {
                const $component = $('[wire\\:id]').first();
                if ($component.length && window.Livewire) {
                    window.Livewire.find($component.attr('wire:id')).call('delete', id);
                }
            }
        }
    };

    /**
     * Confirm bulk delete
     */
    window.confirmBulkDelete = function () {
        const $component = $('[wire\\:id]').first();
        if (!$component.length || !window.Livewire) return;
        
        const component = window.Livewire.find($component.attr('wire:id'));
        const count = component.get('selectedItems').length;
        
        if (count === 0) {
            if (typeof showError === 'function') {
                showError('Pilih minimal satu anggota untuk dihapus');
            }
            return;
        }
        
        if (typeof showBulkDeleteConfirm === 'function') {
            showBulkDeleteConfirm(count).then((result) => {
                if (result.isConfirmed) {
                    component.call('bulkDelete');
                }
            });
        } else if (confirm(`Apakah Anda yakin ingin menghapus ${count} anggota?`)) {
            component.call('bulkDelete');
        }
    };

    /**
     * Initialize on page load
     */
    $(document).ready(function () {
        initializeChoices();
        initializeFlatpickr();
        handleFlashMessages();
        initCheckboxHandlers();
    });

    /**
     * Re-initialize after Livewire updates
     */
    $(document).on('livewire:navigated', function () {
        destroyChoices();
        destroyFlatpickr();
        setTimeout(function() {
            initializeChoices();
            initializeFlatpickr();
        }, 100);
    });

    /**
     * Listen for Livewire load event
     */
    if (window.Livewire) {
        window.Livewire.hook('morph.updated', () => {
            setTimeout(function() {
                // Reinitialize all choices except fraction (will be handled separately)
                const $fractionFilter = $('#fractionFilter');
                const needsFractionReinit = $fractionFilter.length && !$fractionFilter.hasClass('choices-initialized');
                
                initializeChoices();
                initializeFlatpickr();
                updateFlatpickrDate();
                updatePeriodFilterValue();
                
                // If fraction filter was recreated by Livewire, reinitialize it
                if (needsFractionReinit) {
                    reinitializeFractionFilter();
                }
            }, 100);
        });
        
        // Listen for modal open event
        window.Livewire.on('open-modal', () => {
            setTimeout(() => {
                initializeFlatpickr();
            }, 100);
        });
    }
    
    /**
     * Listen for period filter change event
     */
    document.addEventListener('livewire:initialized', () => {
        window.Livewire.on('period-filter-updated', () => {
            setTimeout(() => {
                updatePeriodFilterValue();
                reinitializeFractionFilter();
            }, 200);
        });
    });

    /**
     * Reset checkboxes after bulk action
     */
    function resetCheckboxes() {
        $('.member-checkbox').prop('checked', false);
        $('#selectAllCheckbox').prop('checked', false);
        selectedMemberIds = [];
        $('#bulkActionsBar').slideUp(200);
    }

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
     * Listen for show-toast event from Livewire
     * Using notif-alert.js showToast function
     */
    window.addEventListener('show-toast', function (event) {
        const data = event.detail[0] || event.detail;
        const type = data.type || 'info';
        const message = data.message || 'Notification';
        
        // Use showToast from notif-alert.js
        if (typeof showToast === 'function') {
            showToast(message, type);
        } else if (typeof NotifAlert !== 'undefined' && typeof NotifAlert.toast === 'function') {
            NotifAlert.toast(message, type);
        } else {
            // Fallback to alert
            alert(message);
        }
    });

    /**
     * Handle flash messages
     * Using notif-alert.js functions
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
            }
        }
    }

})(jQuery);
