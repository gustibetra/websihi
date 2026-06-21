/**
 * Common Data Manager JavaScript
 * 
 * Reusable functions for CRUD operations on common data management.
 * All functions are exposed via window.CommonDataManager object.
 * 
 * Usage in Blade templates:
 * - onclick="CommonDataManager.openCreateModal()"
 * - onclick="CommonDataManager.openEditModal({{ $id }})"
 * - onclick="CommonDataManager.confirmDelete({{ $id }}, '{{ $name }}')"
 * - onclick="CommonDataManager.togglePeriodActive({{ $id }})"
 * 
 * Or use wire:click for Livewire components:
 * - wire:click="openCreateModal"
 * - wire:click="openEditModal({{ $id }})"
 * - wire:click="delete({{ $id }})"
 */
(function() {
    'use strict';
    
    // ============================================
    // Helper Functions
    // ============================================
    
    function getLivewireComponent() {
        if (!window.Livewire || !window.Livewire.find) {
            return null;
        }
        let livewireElement = document.querySelector('[wire\\:id]');
        let componentId = null;
        if (livewireElement) {
            componentId = livewireElement.getAttribute('wire:id');
        }
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
    
    // ============================================
    // Livewire Integration
    // ============================================
    
    /**
     * Initialize Livewire event listeners and hooks
     */
    function initLivewireIntegration() {
        if (typeof window.Livewire === 'undefined') {
            console.warn('Livewire is not loaded');
            return;
        }
        
        // Listen for toast notifications
        window.Livewire.on('show-toast', (event) => {
            const data = event[0] || event;
            if (data.type === 'success') {
                showToast(data.message, 'success');
            } else if (data.type === 'error') {
                showToast(data.message, 'error');
            }
        });
        
        // Listen for modal open event
        window.Livewire.on('open-modal', () => {
            setTimeout(() => {
                initFlatpickr();
            }, 100);
        });
        
        // Re-initialize components after Livewire updates
        window.Livewire.hook('morph.updated', () => {
            setTimeout(() => {
                initPerPageFilter();
                initSortFilter();
                updateFlatpickrDates();
                updateSortFilter();
            }, 100);
        });
    }
    
    // ============================================
    // Choices.js - Per Page Filter
    // ============================================
    
    let perPageChoices = null;
    
    /**
     * Initialize Choices.js for perPage filter
     */
    function initPerPageFilter() {
        const perPageSelect = document.getElementById('perPageFilter');
        if (perPageSelect && !perPageSelect.classList.contains('choices-initialized')) {
            perPageChoices = new Choices(perPageSelect, {
                searchEnabled: false,
                itemSelectText: '',
                shouldSort: false
            });
            
            perPageSelect.classList.add('choices-initialized');
            
            perPageSelect.addEventListener('change', function(e) {
                const component = getLivewireComponent();
                if (component) {
                    component.set('perPage', parseInt(e.target.value));
                }
            });
        }
    }
    
    // ============================================
    // Sort Filter
    // ============================================
    
    let sortChoices = null;
    
    /**
     * Initialize Choices.js for sort filter
     */
    function initSortFilter() {
        const sortSelect = document.getElementById('sortSelect');
        if (sortSelect && !sortSelect.classList.contains('choices-initialized')) {
            sortChoices = new Choices(sortSelect, {
                searchEnabled: false,
                itemSelectText: '',
                shouldSort: false
            });
            
            sortSelect.classList.add('choices-initialized');
            
            sortSelect.addEventListener('change', function(e) {
                const sortValue = e.target.value;
                if (sortValue) {
                    const [column, direction] = sortValue.split('-');
                    const component = getLivewireComponent();
                    if (component) {
                        component.set('sortBy', column);
                        component.set('sortDirection', direction);
                    }
                }
            });
        }
    }
    
    /**
     * Update sort filter when data changes
     */
    function updateSortFilter() {
        const component = getLivewireComponent();
        if (!component) return;
        
        const sortSelect = document.getElementById('sortSelect');
        if (sortSelect && sortSelect._choices) {
            const sortBy = component.get('sortBy');
            const sortDirection = component.get('sortDirection');
            const sortValue = `${sortBy}-${sortDirection}`;
            sortSelect._choices.setChoiceByValue(sortValue);
        }
    }
    
    // ============================================
    // Flatpickr - Date Inputs
    // ============================================
    
    let date1Picker = null;
    let date2Picker = null;
    
    /**
     * Initialize Flatpickr for date inputs
     */
    function initFlatpickr() {
        const component = getLivewireComponent();
        if (!component) return;
        
        const date1Input = document.getElementById('date1Input');
        const date2Input = document.getElementById('date2Input');
        
        if (date1Input && !date1Input._flatpickr) {
            date1Picker = flatpickr(date1Input, {
                dateFormat: 'Y-m-d',
                defaultDate: component.get('form.date1') || null,
                onChange: function(selectedDates, dateStr) {
                    component.set('form.date1', dateStr);
                }
            });
        }
        
        if (date2Input && !date2Input._flatpickr) {
            date2Picker = flatpickr(date2Input, {
                dateFormat: 'Y-m-d',
                defaultDate: component.get('form.date2') || null,
                onChange: function(selectedDates, dateStr) {
                    component.set('form.date2', dateStr);
                }
            });
        }
    }
    
    /**
     * Update flatpickr dates when form data changes
     */
    function updateFlatpickrDates() {
        const component = getLivewireComponent();
        if (!component) return;
        
        const date1Input = document.getElementById('date1Input');
        const date2Input = document.getElementById('date2Input');
        
        if (date1Input && date1Input._flatpickr) {
            date1Input._flatpickr.setDate(component.get('form.date1') || null);
        }
        
        if (date2Input && date2Input._flatpickr) {
            date2Input._flatpickr.setDate(component.get('form.date2') || null);
        }
    }
    
    // ============================================
    // CRUD Operations - Reusable Functions
    // ============================================
    
    /**
     * Open create modal
     */
    function openCreateModal() {
        const component = getLivewireComponent();
        if (component) {
            component.call('openCreateModal');
        }
    }
    
    /**
     * Open edit modal
     * @param {number} id - Item ID to edit
     */
    function openEditModal(id) {
        const component = getLivewireComponent();
        if (component) {
            component.call('openEditModal', id);
        }
    }
    
    /**
     * Confirm and delete individual common data item
     * @param {number} id - Item ID
     * @param {string} name - Item name for confirmation message
     */
    function confirmDelete(id, name) {
        if (typeof window.confirmDeleteWithCallback === 'undefined') {
            console.error('confirmDeleteWithCallback helper is not defined. Make sure notif-alert.js is loaded.');
            return;
        }
        
        // Use helper from notif-alert.js
        window.confirmDeleteWithCallback(`Apakah Anda yakin ingin menghapus "${name}"?`, function() {
            const component = getLivewireComponent();
            if (component) {
                component.call('delete', id);
            }
        });
    }
    
    /**
     * Save form data (create or update)
     */
    function saveData() {
        const component = getLivewireComponent();
        if (component) {
            component.call('save');
        }
    }
    
    /**
     * Close modal
     */
    function closeModal() {
        const component = getLivewireComponent();
        if (component) {
            component.set('showModal', false);
        }
    }
    
    /**
     * Toggle period active status
     * @param {number} id - Period ID
     */
    function togglePeriodActive(id) {
        const component = getLivewireComponent();
        if (component) {
            component.call('togglePeriodActive', id);
        }
    }
    
    /**
     * Toggle status active/inactive (for categories and other data)
     * @param {number} id - Item ID
     */
    function toggleStatus(id) {
        const component = getLivewireComponent();
        if (component) {
            component.call('toggleStatus', id);
        }
    }
    
    // Export functions to window for use in onclick/wire:click
    window.CommonDataManager = {
        openCreateModal: openCreateModal,
        openEditModal: openEditModal,
        confirmDelete: confirmDelete,
        saveData: saveData,
        closeModal: closeModal,
        togglePeriodActive: togglePeriodActive,
        toggleStatus: toggleStatus
    };
    
    // Keep backward compatibility
    window.confirmDelete = confirmDelete;
    
    // ============================================
    // Initialization
    // ============================================
    
    /**
     * Initialize all components when Livewire is ready
     */
    function initializeComponents() {
        initPerPageFilter();
        initSortFilter();
        initLivewireIntegration();
    }
    
    // Wait for Livewire to be initialized
    document.addEventListener('livewire:initialized', () => {
        initializeComponents();
    });
    
    // ============================================
    // jQuery Ready
    // ============================================
    
    $(document).ready(function() {
        // Mobile sidebar toggle with jQuery
        $('.file-menu-btn').on('click', function() {
            var $sidebar = $('.file-manager-sidebar');
            var $overlay = $('.sidebar-overlay');
            
            // Create overlay if not exists
            if ($overlay.length === 0) {
                $overlay = $('<div class="sidebar-overlay"></div>').css({
                    'position': 'fixed',
                    'top': 0,
                    'left': 0,
                    'width': '100%',
                    'height': '100%',
                    'background': 'rgba(0,0,0,0.5)',
                    'z-index': 1040,
                    'display': 'none'
                });
                $('body').append($overlay);
                
                // Close sidebar when clicking overlay
                $overlay.on('click', function() {
                    $sidebar.removeClass('show');
                    $(this).fadeOut(200);
                });
            }
            
            // Toggle sidebar
            $sidebar.toggleClass('show');
            if ($sidebar.hasClass('show')) {
                $overlay.fadeIn(200);
            } else {
                $overlay.fadeOut(200);
            }
        });
        
        // Close sidebar when clicking outside on mobile
        $(document).on('click', function(e) {
            var $sidebar = $('.file-manager-sidebar');
            var $menuBtn = $('.file-menu-btn');
            var $overlay = $('.sidebar-overlay');
            
            if ($(window).width() < 992) {
                if (!$sidebar.is(e.target) && $sidebar.has(e.target).length === 0 && 
                    !$menuBtn.is(e.target) && $menuBtn.has(e.target).length === 0) {
                    if ($sidebar.hasClass('show')) {
                        $sidebar.removeClass('show');
                        $overlay.fadeOut(200);
                    }
                }
            }
        });
        
        // Initialize tooltips if needed
        if (typeof bootstrap !== 'undefined' && bootstrap.Tooltip) {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }
    });
    
})();
