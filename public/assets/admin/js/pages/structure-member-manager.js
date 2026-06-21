/**
 * Structure Member Manager JavaScript
 * Handles Sortable.js for drag & drop functionality across sections
 */

(function ($) {
    'use strict';

    let sortableInstances = [];

    /**
     * Initialize Sortable.js for each section members list
     */
    function initializeSortable() {
        const lists = document.querySelectorAll('.section-members-list');
        
        if (lists.length === 0) {
            return;
        }

        // Destroy existing instances if any
        sortableInstances.forEach(instance => {
            if (instance && typeof instance.destroy === 'function') {
                instance.destroy();
            }
        });
        sortableInstances = [];

        // Initialize Sortable for each list
        lists.forEach(list => {
            const instance = new Sortable(list, {
                group: 'section-members', // Allows dragging between lists in this group
                animation: 150,
                handle: '.drag-handle',
                ghostClass: 'sortable-ghost',
                dragClass: 'sortable-drag',
                
                onAdd: function (evt) {
                    // Triggered when an item from the available list is dropped here
                    const memberId = evt.item.getAttribute('data-member-id');
                    const sectionId = evt.to.getAttribute('data-section-id');
                    
                    // Remove the cloned node from the DOM immediately to prevent duplicates before Livewire rerenders
                    if (evt.item.parentNode) {
                        evt.item.parentNode.removeChild(evt.item);
                    }
                    
                    if (memberId && sectionId) {
                        const component = document.querySelector('[wire\\:id]');
                        if (component && window.Livewire) {
                            window.Livewire.find(component.getAttribute('wire:id')).call('addMember', parseInt(memberId), parseInt(sectionId));
                        }
                    }
                },
                
                onEnd: function () {
                    // Collect payload from ALL lists on drop
                    const payload = {};
                    
                    document.querySelectorAll('.section-members-list').forEach(l => {
                        const sectionId = l.getAttribute('data-section-id') || 'unassigned';
                        const memberItems = l.querySelectorAll('.assigned-member');
                        const memberIds = [];
                        
                        memberItems.forEach(item => {
                            const id = item.getAttribute('data-id');
                            if (id) {
                                memberIds.push(parseInt(id));
                            }
                        });
                        
                        payload[sectionId] = memberIds;
                    });

                    // Send payload to Livewire
                    const component = document.querySelector('[wire\\:id]');
                    if (component && window.Livewire) {
                        window.Livewire.find(component.getAttribute('wire:id')).call('updateStructureOrders', payload);
                    }
                }
            });
            
            sortableInstances.push(instance);
        });

        // Initialize Sortable for the available list as a source only
        const availableList = document.querySelector('.available-members-list');
        if (availableList) {
            const instance = new Sortable(availableList, {
                group: {
                    name: 'section-members',
                    pull: 'clone', // Allows cloning items out of the list
                    put: false     // Prevents dropping items into the available list
                },
                sort: false, // Disables sorting within the available list itself
                animation: 150,
                handle: '.drag-handle',
                ghostClass: 'sortable-ghost',
                dragClass: 'sortable-drag'
            });
            sortableInstances.push(instance);
        }
    }

    /**
     * Initialize on page load
     */
    $(document).ready(function () {
        initializeSortable();
        handleFlashMessages();
    });

    /**
     * Re-initialize after Livewire updates
     */
    $(document).on('livewire:navigated', function () {
        setTimeout(initializeSortable, 100);
    });

    /**
     * Listen for Livewire load event
     */
    if (window.Livewire) {
        window.Livewire.hook('morph.updated', () => {
            setTimeout(initializeSortable, 100);
        });

        // Re-initialize after member added or section updated
        window.addEventListener('member-added', function () {
            setTimeout(initializeSortable, 100);
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

    /**
     * Confirm delete member
     */
    window.confirmDeleteMember = function(structureMemberId, memberName) {
        if (typeof confirmDeleteWithCallback === 'function') {
            confirmDeleteWithCallback(
                `Apakah Anda yakin ingin menghapus <strong>${memberName}</strong> dari struktur ini?`,
                function() {
                    const component = document.querySelector('[wire\\:id]');
                    if (component && window.Livewire) {
                        window.Livewire.find(component.getAttribute('wire:id')).call('removeMember', structureMemberId);
                    }
                }
            );
        } else {
            if (confirm(`Apakah Anda yakin ingin menghapus ${memberName} dari struktur ini?`)) {
                const component = document.querySelector('[wire\\:id]');
                if (component && window.Livewire) {
                    window.Livewire.find(component.getAttribute('wire:id')).call('removeMember', structureMemberId);
                }
            }
        }
    };

    /**
     * Confirm delete section
     */
    window.confirmDeleteSection = function(sectionId, sectionName) {
        if (typeof confirmDeleteWithCallback === 'function') {
            confirmDeleteWithCallback(
                `Apakah Anda yakin ingin menghapus section <strong>${sectionName}</strong>? Anggota di dalamnya akan diatur menjadi tanpa section (tidak dihapus dari struktur).`,
                function() {
                    const component = document.querySelector('[wire\\:id]');
                    if (component && window.Livewire) {
                        window.Livewire.find(component.getAttribute('wire:id')).call('deleteSection', sectionId);
                    }
                }
            );
        } else {
            if (confirm(`Apakah Anda yakin ingin menghapus section ${sectionName}? Anggota di dalamnya akan menjadi tanpa section.`)) {
                const component = document.querySelector('[wire\\:id]');
                if (component && window.Livewire) {
                    window.Livewire.find(component.getAttribute('wire:id')).call('deleteSection', sectionId);
                }
            }
        }
    };

})(jQuery);
