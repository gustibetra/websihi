/**
 * User Manager JavaScript
 * Handles Choices.js initialization and event listeners for User Management
 */

(function ($) {
    'use strict';

    let roleChoice = null;
    let statusChoice = null;
    let perPageChoice = null;

    /**
     * Initialize Choices.js for all select elements
     */
    function initializeChoices() {
        // Role Filter
        const $roleFilter = $('#roleFilter');
        if ($roleFilter.length && !$roleFilter.hasClass('choices-initialized')) {
            roleChoice = new Choices($roleFilter[0], {
                searchEnabled: false,
                itemSelectText: '',
                shouldSort: false,
            });

            $roleFilter.on('change', function () {
                const $component = $(this).closest('[wire\\:id]');
                if ($component.length && window.Livewire) {
                    window.Livewire.find($component.attr('wire:id')).set('roleFilter', $(this).val());
                }
            });

            $roleFilter.addClass('choices-initialized');
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

        // Per Page Filter
        const $perPageFilter = $('#perPageFilter');
        if ($perPageFilter.length && !$perPageFilter.hasClass('choices-initialized')) {
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
     * Destroy Choices.js instances
     */
    function destroyChoices() {
        if (roleChoice) {
            roleChoice.destroy();
            roleChoice = null;
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
     * Confirm delete action
     * Using notif-alert.js showDeleteConfirm
     */
    window.confirmDelete = function (id, name) {
        const message = `User "${name}" akan dihapus secara permanen!`;
        
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
            if (confirm(`Apakah Anda yakin ingin menghapus user "${name}"?`)) {
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
        handleFlashMessages();
    });

    /**
     * Re-initialize after Livewire updates
     */
    $(document).on('livewire:navigated', function () {
        destroyChoices();
        setTimeout(initializeChoices, 100);
    });

    /**
     * Listen for Livewire load event
     */
    if (window.Livewire) {
        window.Livewire.hook('morph.updated', () => {
            setTimeout(initializeChoices, 100);
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
