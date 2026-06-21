/**
 * Menu Manager JavaScript - Simple Implementation
 */

(function ($) {
    'use strict';

    console.log('[Menu Manager] JS file loaded');

    let parentSortable = null;
    let childSortables = [];

    /**
     * Initialize Sortable for menu list
     */
    function initializeSortable() {
        console.log('[Sortable] Initializing...');
        const menuList = document.getElementById('menuList');
        
        if (!menuList) {
            console.warn('[Sortable] Menu list not found');
            return;
        }
        
        console.log('[Sortable] Menu list found, creating sortable...');

        // Destroy existing instances
        if (parentSortable) {
            parentSortable.destroy();
        }
        childSortables.forEach(s => s.destroy());
        childSortables = [];

        // Initialize parent menu sortable
        if (typeof Sortable === 'undefined') {
            console.error('[Sortable] Sortable library not loaded!');
            return;
        }
        
        parentSortable = new Sortable(menuList, {
            animation: 150,
            handle: '.cursor-move',
            ghostClass: 'sortable-ghost',
            dragClass: 'sortable-drag',
            
            onEnd: function (evt) {
                const items = menuList.querySelectorAll(':scope > .menu-item');
                const orderedIds = [];
                
                items.forEach(item => {
                    orderedIds.push(parseInt(item.getAttribute('data-id')));
                });
                
                // Send to Livewire
                const componentEl = menuList.closest('[wire\\:id]');
                if (componentEl && window.Livewire) {
                    const componentId = componentEl.getAttribute('wire:id');
                    
                    try {
                        window.Livewire.find(componentId).call('handleReorder', orderedIds);
                    } catch(e) {
                        console.error('[Menu] Error:', e);
                    }
                }
            }
        });

        // Initialize child menu sortables (for all levels)
        const childLists = document.querySelectorAll('.child-menu-list');
        
        childLists.forEach(childList => {
            const childSortable = new Sortable(childList, {
                animation: 150,
                handle: '.cursor-move',
                ghostClass: 'sortable-ghost',
                dragClass: 'sortable-drag',
                
                onEnd: function (evt) {
                    // Find the direct parent menu item (not grandparent)
                    const parentWrapper = childList.closest('.child-menu-wrapper');
                    const parentEl = parentWrapper ? parentWrapper.closest('.menu-item, .child-menu-item') : null;
                    const parentId = parentEl ? parseInt(parentEl.getAttribute('data-id')) : null;
                    
                    // Get only direct children of this list (not nested grandchildren)
                    const items = Array.from(childList.children).filter(item => 
                        item.classList.contains('child-menu-item') && 
                        item.parentElement === childList
                    );
                    
                    const orderedIds = items.map(item => parseInt(item.getAttribute('data-id')));
                    
                    console.log('[Menu] Reordering children of parent:', parentId, 'Order:', orderedIds);
                    
                    // Send to Livewire
                    const menuList = document.getElementById('menuList');
                    const componentEl = menuList ? menuList.closest('[wire\\:id]') : null;
                    
                    if (componentEl && window.Livewire) {
                        const componentId = componentEl.getAttribute('wire:id');
                        
                        try {
                            window.Livewire.find(componentId).call('handleReorderChildren', parentId, orderedIds);
                        } catch(e) {
                            console.error('[Menu] Error:', e);
                        }
                    }
                }
            });
            
            childSortables.push(childSortable);
        });
    }

    // Expose globally
    window.initMenuManagerSortable = initializeSortable;

    /**
     * Confirm delete
     */
    window.confirmDelete = function (id, title) {
        const message = `Menu "${title}" akan dihapus secara permanen!`;
        
        if (typeof showDeleteConfirm === 'function') {
            showDeleteConfirm(message).then((result) => {
                if (result.isConfirmed) {
                    // Find menu-manager component specifically
                    const menuComponent = document.querySelector('.menu-wire-component[wire\\:id]');
                    if (menuComponent && window.Livewire) {
                        const componentId = menuComponent.getAttribute('wire:id');
                        window.Livewire.find(componentId).call('delete', id);
                    }
                }
            });
        } else {
            if (confirm(`Apakah Anda yakin ingin menghapus menu "${title}"?`)) {
                // Find menu-manager component specifically
                const menuComponent = document.querySelector('.menu-wire-component[wire\\:id]');
                if (menuComponent && window.Livewire) {
                    const componentId = menuComponent.getAttribute('wire:id');
                    window.Livewire.find(componentId).call('delete', id);
                }
            }
        }
    };

    /**
     * Handle flash messages
     */
    function handleFlashMessages() {
        const $successMsg = $('.flash-message-success');
        if ($successMsg.length) {
            const message = $successMsg.data('message');
            if (message && typeof showSuccess === 'function') {
                showSuccess(message);
                $successMsg.remove();
            }
        }

        const $errorMsg = $('.flash-message-error');
        if ($errorMsg.length) {
            const message = $errorMsg.data('message');
            if (message && typeof showError === 'function') {
                showError(message);
                $errorMsg.remove();
            }
        }
    }

    /**
     * Initialize on page load
     */
    $(document).ready(function () {
        handleFlashMessages();
    });

    /**
     * Initialize all
     */
    function initAll() {
        console.log('[Menu] Initializing all...');
        if (document.getElementById('menuList')) {
            initializeSortable();
        }
        handleFlashMessages();
    }

    /**
     * Initialize on page load
     */
    $(document).ready(function () {
        console.log('[Menu] Document ready');
        setTimeout(initAll, 500);
    });

    /**
     * Re-initialize after Livewire updates
     */
    if (window.Livewire) {
        Livewire.hook('morph.updated', () => {
            console.log('[Menu] Livewire updated');
            setTimeout(function() {
                if (document.getElementById('menuList')) {
                    initializeSortable();
                }
                handleFlashMessages();
            }, 100);
        });
    }

})(jQuery);
