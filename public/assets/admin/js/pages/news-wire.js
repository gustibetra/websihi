(function() {
    'use strict';

    const instances = {statusChoice: null, categoriesChoice: null, periodsChoice: null, dateRangePicker: null, perPageChoice: null, jurusanFilterChoice: null};
    const previousValues = {status: null, categories: null, periods: null, dateFrom: null, dateTo: null, perPage: null, showAllFilters: null, jurusanFilter: null};

    let isSyncing = false;
    let clientShowAllFilters = false;
    function initSingleSelectChoice(elementId, propertyName, choicesConfig, instanceStore, instanceKey, valueTransformer = null) {
        const el = document.getElementById(elementId);
        if (!el) return;
        if (!instanceStore[instanceKey]) {
            instanceStore[instanceKey] = initChoices(elementId, choicesConfig);
            el.addEventListener('change', function() {
                try {
                    const comp = getLivewireComponent();
                    if (!comp) return;
                    let val = valueTransformer ? valueTransformer(this.value) : this.value;
                    if (valueTransformer && (isNaN(val) || val <= 0)) return;
                    if (previousValues[propertyName] !== val) {
                        previousValues[propertyName] = val;
                        comp.set(propertyName, val);
                    }
                } catch (e) {
                    console.warn(`Error setting ${propertyName}:`, e);
                }
            });
        }
        try {
            const comp = getLivewireComponent();
            if (!instanceStore[instanceKey] || !comp) return;
            let v = comp[propertyName] ?? (propertyName === 'perPage' ? 10 : 'all');
            previousValues[propertyName] = v;
            instanceStore[instanceKey].setChoiceByValue(valueTransformer ? v.toString() : v);
        } catch (e) {}
    }

    function initMultipleSelectChoice(elementId, propertyName, choicesConfig, instanceStore, instanceKey, valueProcessor = null) {
        const element = document.getElementById(elementId);
        if (!element) return;

        if (!instanceStore[instanceKey]) {
            instanceStore[instanceKey] = initChoices(elementId, choicesConfig);
            if (instanceStore[instanceKey]) {
                const updateIfChanged = function() {
                    if (isSyncing) return;
                    try {
                        const comp = getLivewireComponent();
                        if (!comp) return;
                        const selectedValues = instanceStore[instanceKey].getValue(true) || [];
                        let processedValues = Array.isArray(selectedValues) ? selectedValues : (selectedValues ? [selectedValues] : []);
                        if (valueProcessor) {
                            processedValues = processedValues.map(valueProcessor).filter(val => val !== null && val !== undefined && !isNaN(val));
                        }
                        processedValues.sort((a, b) => {
                            if (typeof a === 'number' && typeof b === 'number') return a - b;
                            return String(a).localeCompare(String(b));
                        });
                        const prevValues = previousValues[propertyName] || [];
                        const prevSorted = [...prevValues].sort((a, b) => {
                            if (typeof a === 'number' && typeof b === 'number') return a - b;
                            return String(a).localeCompare(String(b));
                        });
                        if (JSON.stringify(processedValues) !== JSON.stringify(prevSorted)) {
                            previousValues[propertyName] = processedValues;
                            comp.set(propertyName, processedValues);
                        }
                    } catch (e) {
                        console.warn(`Error setting ${propertyName}:`, e);
                    }
                };
                element.addEventListener('change', updateIfChanged);
                element.closest('.choices')?.addEventListener('click', function(e) {
                    if (e.target.closest('.choices__button')) {
                        setTimeout(updateIfChanged, 50);
                    }
                });
            }
        }
        
        if (instanceStore[instanceKey]) {
            try {
                const component = getLivewireComponent();
                if (!component) return;
                const currentValues = component[propertyName] || [];
                const sorted = [...currentValues].sort((a, b) => {
                    if (typeof a === 'number' && typeof b === 'number') return a - b;
                    return String(a).localeCompare(String(b));
                });
                previousValues[propertyName] = sorted;
                const currentActive = instanceStore[instanceKey].getValue(true) || [];
                currentActive.forEach(val => {
                    try {
                        instanceStore[instanceKey].removeActiveItemsByValue(String(val));
                    } catch (e) {}
                });
                if (currentValues.length > 0) {
                    setTimeout(() => {
                        currentValues.forEach(val => {
                            try {
                                instanceStore[instanceKey].setChoiceByValue(String(val));
                            } catch (e) {}
                        });
                    }, 50);
                }
            } catch (e) {}
        }
    }

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
            livewireElement = document.querySelector('[wire\\:snapshot]');
            if (livewireElement) {
                try {
                    const snapshot = JSON.parse(livewireElement.getAttribute('wire:snapshot'));
                    if (snapshot && snapshot.memo && snapshot.memo.id) {
                        componentId = snapshot.memo.id;
                    }
                } catch (e) {}
            }
        }
        if (!componentId) {
            livewireElement = document.querySelector('[wire\\:key="news-wire-component"]');
            if (livewireElement) {
                let parent = livewireElement.parentElement;
                let depth = 0;
                while (parent && parent !== document.body && depth < 10) {
                    if (parent.hasAttribute('wire:id')) {
                        componentId = parent.getAttribute('wire:id');
                        break;
                    }
                    parent = parent.parentElement;
                    depth++;
                }
            }
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

    // Initialize Choices.js - menggunakan konfigurasi sama seperti template
    function initChoices(elementId, config = {}) {
        const element = document.getElementById(elementId);
        if (!element) return null;

        // Destroy existing instance
        if (element._choicesInstance) {
            try {
                element._choicesInstance.destroy();
            } catch (e) {
                console.warn('Error destroying Choices:', e);
            }
        }

        // Parse attributes seperti template app.js
        const attrs = element.attributes;
        const choicesConfig = { ...config };

        // Parse data-choices attributes
        if (attrs['data-choices-search-false']) choicesConfig.searchEnabled = false;
        if (attrs['data-choices-search-true']) choicesConfig.searchEnabled = true;
        if (attrs['data-choices-multiple-remove']) choicesConfig.removeItemButton = true;
        if (attrs['data-choices-limit']) choicesConfig.maxItemCount = parseInt(attrs['data-choices-limit'].value);

        // Default config
        if (element.multiple) {
            choicesConfig.removeItemButton = choicesConfig.removeItemButton !== undefined ? choicesConfig.removeItemButton : true;
            choicesConfig.searchEnabled = choicesConfig.searchEnabled !== undefined ? choicesConfig.searchEnabled : true;
            choicesConfig.placeholder = choicesConfig.placeholder !== undefined ? choicesConfig.placeholder : true;
        }

        try {
            const choiceInstance = new Choices(element, choicesConfig);
            element._choicesInstance = choiceInstance;
            
            // Show element after initialization - use setTimeout to ensure Choices.js wrapper is created
            setTimeout(() => {
                element.classList.remove('choices-init-hide');
                element.classList.add('choices-initialized');
            }, 10);
            
            return choiceInstance;
        } catch (e) {
            console.warn('Error initializing Choices:', e);
            // Show element even if initialization fails
            setTimeout(() => {
                element.classList.remove('choices-init-hide');
            }, 10);
            return null;
        }
    }

    // Initialize Flatpickr - menggunakan konfigurasi sama seperti template
    function initFlatpickr(elementId, config = {}) {
        const element = document.getElementById(elementId);
        if (!element) return null;

        // Destroy existing instance
        if (element._flatpickr) {
            try {
                element._flatpickr.destroy();
            } catch (e) {
                console.warn('Error destroying Flatpickr:', e);
            }
        }

        // Parse attributes seperti template app.js
        const attrs = element.attributes;
        const flatpickrConfig = { 
            disableMobile: true,
            ...config 
        };

        // Parse data-provider attributes
        if (attrs['data-date-format']) flatpickrConfig.dateFormat = attrs['data-date-format'].value;
        if (attrs['data-range-date']) flatpickrConfig.mode = 'range';
        if (attrs['data-multiple-date']) flatpickrConfig.mode = 'multiple';
        if (attrs['data-enable-time']) {
            flatpickrConfig.enableTime = true;
            flatpickrConfig.dateFormat = (attrs['data-date-format'] ? attrs['data-date-format'].value : 'Y-m-d') + ' H:i';
        }
        if (attrs['data-alt-format']) {
            flatpickrConfig.altInput = true;
            flatpickrConfig.altFormat = attrs['data-alt-format'].value;
        } else if (attrs['data-altFormat']) {
            flatpickrConfig.altInput = true;
            flatpickrConfig.altFormat = attrs['data-altFormat'].value;
        }
        if (attrs['data-minDate']) flatpickrConfig.minDate = attrs['data-minDate'].value;
        if (attrs['data-maxDate']) flatpickrConfig.maxDate = attrs['data-maxDate'].value;
        if (attrs['data-inline-date']) flatpickrConfig.inline = true;

        // Add onChange handler untuk sync dengan Livewire
        // Hanya update ketika kedua tanggal sudah dipilih (range complete) DAN nilai berbeda
        const originalOnChange = flatpickrConfig.onChange;
        flatpickrConfig.onChange = function(selectedDates, dateStr, instance) {
            if (elementId === 'dateRangeFilter') {
                const component = getLivewireComponent();
                if (!component) return;
                
                // Hanya update Livewire ketika kedua tanggal sudah dipilih
                if (selectedDates.length === 2) {
                    const dateFromStr = selectedDates[0].toISOString().split('T')[0];
                    const dateToStr = selectedDates[1].toISOString().split('T')[0];
                    
                    // Hanya update jika nilai berbeda dari previous values
                    if (previousValues.dateFrom !== dateFromStr || previousValues.dateTo !== dateToStr) {
                        previousValues.dateFrom = dateFromStr;
                        previousValues.dateTo = dateToStr;
                        component.set('dateFrom', dateFromStr);
                        component.set('dateTo', dateToStr);
                    }
                } else if (selectedDates.length === 0) {
                    // Clear dates hanya ketika semua tanggal dihapus DAN sebelumnya ada nilai
                    if (previousValues.dateFrom !== '' || previousValues.dateTo !== '') {
                        previousValues.dateFrom = '';
                        previousValues.dateTo = '';
                        component.set('dateFrom', '');
                        component.set('dateTo', '');
                    }
                }
                // Jika selectedDates.length === 1, jangan update Livewire (tunggu tanggal kedua)
            }
            if (originalOnChange) originalOnChange(selectedDates, dateStr, instance);
        };

        try {
            const fpInstance = flatpickr(element, flatpickrConfig);
            element._flatpickr = fpInstance;
            
            // Show element after initialization
            if (element.classList.contains('choices-init-hide')) {
                element.classList.remove('choices-init-hide');
                element.classList.add('choices-initialized');
            }
            
            return fpInstance;
        } catch (e) {
            console.warn('Error initializing Flatpickr:', e);
            // Show element even if initialization fails
            if (element.classList.contains('choices-init-hide')) {
                element.classList.remove('choices-init-hide');
            }
            return null;
        }
    }

    function initAll() {
        try {
            const component = getLivewireComponent();
            if (!component) {
                console.warn('Livewire component not found, retrying...');
                setTimeout(initAll, 100);
                return;
            }

            initSingleSelectChoice('statusFilter', 'status', {
                searchEnabled: false,
                placeholder: false,
                itemSelectText: '',
            }, instances, 'statusChoice');

            initSingleSelectChoice('jurusanFilter', 'jurusanFilter', {
                searchEnabled: true,
                placeholder: false,
                itemSelectText: '',
            }, instances, 'jurusanFilterChoice');

            initSingleSelectChoice('perPageFilter', 'perPage', {
                searchEnabled: false,
                placeholder: false,
                itemSelectText: '',
            }, instances, 'perPageChoice', parseInt);

            let showAllFilters = false;
            try {
                showAllFilters = component.showAllFilters || false;
            } catch (e) {
                return;
            }
            
            if (showAllFilters) {
                initMultipleSelectChoice('categoriesFilter', 'categories', {
                    removeItemButton: true,
                    searchEnabled: true,
                    placeholder: true,
                    placeholderValue: 'Pilih Kategori',
                    searchPlaceholderValue: 'Cari kategori...',
                }, instances, 'categoriesChoice', parseInt);

                initMultipleSelectChoice('periodsFilter', 'periods', {
                    removeItemButton: true,
                    searchEnabled: true,
                    placeholder: true,
                    placeholderValue: 'Pilih Period',
                    searchPlaceholderValue: 'Cari period...',
                }, instances, 'periodsChoice');

                const dateRangeInput = document.getElementById('dateRangeFilter');
                if (dateRangeInput && !instances.dateRangePicker) {
                    instances.dateRangePicker = initFlatpickr('dateRangeFilter', {
                        mode: 'range',
                        dateFormat: 'Y-m-d',
                        altInput: true,
                        altFormat: 'd M, Y',
                        disableMobile: true,
                    });
                }

                if (instances.dateRangePicker) {
                    try {
                        const dateFrom = component.dateFrom || '';
                        const dateTo = component.dateTo || '';
                        const currentDates = instances.dateRangePicker.selectedDates || [];
                        const hasCurrentDates = currentDates.length === 2;
                        
                        if (dateFrom && dateTo) {
                            let shouldSet = true;
                            if (hasCurrentDates) {
                                const currentFrom = currentDates[0].toISOString().split('T')[0];
                                const currentTo = currentDates[1].toISOString().split('T')[0];
                                if (currentFrom === dateFrom && currentTo === dateTo) {
                                    shouldSet = false;
                                }
                            }
                            if (shouldSet) {
                                previousValues.dateFrom = dateFrom;
                                previousValues.dateTo = dateTo;
                                instances.dateRangePicker.setDate([dateFrom, dateTo], false);
                            } else {
                                previousValues.dateFrom = dateFrom;
                                previousValues.dateTo = dateTo;
                            }
                        } else if (hasCurrentDates) {
                            instances.dateRangePicker.clear();
                            previousValues.dateFrom = '';
                            previousValues.dateTo = '';
                        } else {
                            previousValues.dateFrom = '';
                            previousValues.dateTo = '';
                        }
                    } catch (e) {
                        console.warn('Error setting Flatpickr initial dates:', e);
                    }
                }
            }
        } catch (e) {
            console.warn('Error in initAll:', e);
        }
    }

    // Update header buttons berdasarkan showAllFilters state
    function updateHeaderButtons() {
        try {
            const component = getLivewireComponent();
            if (!component) return;
            
            let showAllFilters = false;
            try {
                showAllFilters = component.showAllFilters || false;
            } catch (e) {
                // component belum tersedia, skip update
                return;
            }
            
            const toggleFilterBtn = document.getElementById('toggleFilterBtn');
            const closeFilterBtn = document.getElementById('closeFilterBtn');
            
            if (toggleFilterBtn) {
                if (showAllFilters) {
                    toggleFilterBtn.classList.add('d-none');
                } else {
                    toggleFilterBtn.classList.remove('d-none');
                }
            }
            
            if (closeFilterBtn) {
                if (showAllFilters) {
                    closeFilterBtn.classList.remove('d-none');
                } else {
                    closeFilterBtn.classList.add('d-none');
                }
            }
        } catch (e) {
            // Ignore jika komponen belum siap
        }
    }

    function setupHeaderButtons() {
        window.addEventListener('toggle-news-filters', function(event) {
            const show = event.detail.show;
            const component = getLivewireComponent();
            if (component) {
                try {
                    const currentShowAllFilters = component.showAllFilters || false;
                    if (currentShowAllFilters !== show) {
                        previousShowAllFilters = currentShowAllFilters;
                        component.set('showAllFilters', show);
                    }
                } catch (e) {
                    console.warn('Cannot access Livewire component:', e);
                }
            }
        });
    }

    // Show/hide bulk actions based on selected items
    function updateBulkActions() {
        try {
            // Use client-side selection count instead of server-side
            // This ensures buttons appear/hide immediately when checkboxes are clicked
            const selectedCount = clientSelectedItems ? clientSelectedItems.size : 0;
            const bulkActionsGroup = document.getElementById('bulkActionsGroup');
            const selectedCountSpan = document.getElementById('selectedCount');
            
            if (bulkActionsGroup) {
                if (selectedCount > 0) {
                    bulkActionsGroup.classList.remove('d-none');
                } else {
                    bulkActionsGroup.classList.add('d-none');
                }
            }
            
            // Update selected count in modal (di parent view)
            if (selectedCountSpan) {
                selectedCountSpan.textContent = selectedCount;
            }
        } catch (e) {
            // Ignore errors
        }
    }

    let previousShowAllFilters = null; // null = belum di-set

    // Re-initialize after Livewire updates
    document.addEventListener('livewire:init', function() {
        // Initialize previousShowAllFilters setelah Livewire ready
        const component = getLivewireComponent();
        if (component) {
            try {
                previousShowAllFilters = component.showAllFilters || false;
            } catch (e) {
                // component belum tersedia, akan di-set setelah component ready
                previousShowAllFilters = null;
            }
        }
        
        // Initialize semua filter fields setelah Livewire ready
        setTimeout(() => {
            initAll();
        }, 100);
        
        // Setup header buttons
        setupHeaderButtons();
        updateHeaderButtons();
        updateBulkActions();

        // Handle loading indicator in header
        Livewire.hook('morph.updating', () => {
            const indicator = document.querySelector('.news-loading-indicator');
            if (indicator) {
                indicator.classList.remove('d-none');
            }
        });
        
        Livewire.hook('morph.updated', ({ component, el }) => {
            const indicator = document.querySelector('.news-loading-indicator');
            if (indicator) {
                setTimeout(() => {
                    indicator.classList.add('d-none');
                }, 100);
            }

            setTimeout(() => {
                const component = getLivewireComponent();
                if (!component) return;
                
                let currentShowAllFilters = false;
                try {
                    currentShowAllFilters = component.showAllFilters || false;
                } catch (e) {
                    // component belum tersedia, skip
                    return;
                }
                
                // HANYA re-init filter fields jika showAllFilters BERUBAH dari false ke true
                // Jangan re-init setiap kali Livewire update jika showAllFilters tetap true
                const showAllFiltersChanged = (previousShowAllFilters === null) || 
                                             (previousShowAllFilters !== currentShowAllFilters);
                
                if (showAllFiltersChanged && currentShowAllFilters) {
                    // Update previous state
                    previousShowAllFilters = currentShowAllFilters;
                    setTimeout(() => {
                        // Init Categories - init ulang jika elemen ada di DOM tapi instance belum ada atau sudah di-destroy
                        const categoriesSelect = document.getElementById('categoriesFilter');
                        if (categoriesSelect) {
                            // Destroy instance lama jika ada (untuk re-init)
                            if (instances.categoriesChoice) {
                                try {
                                    instances.categoriesChoice.destroy();
                                } catch (e) {
                                    // Ignore
                                }
                                instances.categoriesChoice = null;
                            }
                            
                            // Init baru
                            instances.categoriesChoice = initChoices('categoriesFilter', {
                                removeItemButton: true,
                                searchEnabled: true,
                                placeholder: true,
                                placeholderValue: 'Pilih Kategori',
                                searchPlaceholderValue: 'Cari kategori...',
                            });
                            
                            // Attach event listeners dengan comparison logic
                            if (instances.categoriesChoice) {
                                // Helper function untuk update categories jika berubah
                                const updateCategoriesIfChanged = function() {
                                    // Skip jika sedang sync (avoid loop)
                                    if (isSyncing) return;
                                    
                                    try {
                                        const comp = getLivewireComponent();
                                        if (comp) {
                                            // Get selected values dari Choices.js (lebih reliable daripada selectedOptions)
                                            const selectedValues = instances.categoriesChoice.getValue(true) || [];
                                            const selectedIds = Array.isArray(selectedValues) 
                                                ? selectedValues.map(id => parseInt(id)).filter(id => !isNaN(id)).sort((a, b) => a - b)
                                                : (selectedValues ? [parseInt(selectedValues)].filter(id => !isNaN(id)) : []);
                                            
                                            // Compare dengan previous values
                                            const prevCategories = previousValues.categories || [];
                                            const prevSorted = [...prevCategories].sort((a, b) => a - b);
                                            
                                            // Hanya update jika berbeda
                                            if (JSON.stringify(selectedIds) !== JSON.stringify(prevSorted)) {
                                                // Update previous values SEBELUM update Livewire
                                                previousValues.categories = selectedIds;
                                                comp.set('categories', selectedIds);
                                            }
                                        }
                                    } catch (e) {
                                        console.warn('Error setting categories:', e);
                                    }
                                };

                                categoriesSelect.addEventListener('change', updateCategoriesIfChanged);
                                
                                categoriesSelect.closest('.choices')?.addEventListener('click', function(e) {
                                    if (e.target.closest('.choices__button')) {
                                        // Delay lebih lama untuk memastikan Choices.js sudah remove item dari DOM
                                        setTimeout(updateCategoriesIfChanged, 50);
                                    }
                                });
                                
                                try {
                                    const comp = getLivewireComponent();
                                    if (comp) {
                                        const currentCategories = comp.categories || [];
                                        previousValues.categories = [...currentCategories].sort((a, b) => a - b);
                                        
                                        const currentActive = instances.categoriesChoice.getValue(true) || [];
                                        currentActive.forEach(val => {
                                            try {
                                                instances.categoriesChoice.removeActiveItemsByValue(String(val));
                                            } catch (e) {}
                                        });
                                        if (currentCategories.length > 0) {
                                            setTimeout(() => {
                                                currentCategories.forEach(id => {
                                                    try {
                                                        instances.categoriesChoice.setChoiceByValue(id.toString());
                                                    } catch (e) {}
                                                });
                                            }, 100);
                                        }
                                    }
                                } catch (e) {}
                            }
                        }
                        
                        // Init Periods - init ulang jika elemen ada di DOM tapi instance belum ada atau sudah di-destroy
                        const periodsSelect = document.getElementById('periodsFilter');
                        if (periodsSelect) {
                            // Destroy instance lama jika ada (untuk re-init)
                            if (instances.periodsChoice) {
                                try {
                                    instances.periodsChoice.destroy();
                                } catch (e) {
                                    // Ignore
                                }
                                instances.periodsChoice = null;
                            }
                            
                            // Init baru
                            instances.periodsChoice = initChoices('periodsFilter', {
                                removeItemButton: true,
                                searchEnabled: true,
                                placeholder: true,
                                placeholderValue: 'Pilih Period',
                                searchPlaceholderValue: 'Cari period...',
                            });
                            
                            // Attach event listeners dengan comparison logic
                            if (instances.periodsChoice) {
                                // Helper function untuk update periods jika berubah
                                const updatePeriodsIfChanged = function() {
                                    // Skip jika sedang sync (avoid loop)
                                    if (isSyncing) return;
                                    
                                    try {
                                        const comp = getLivewireComponent();
                                        if (comp) {
                                            // Get selected values dari Choices.js (lebih reliable daripada selectedOptions)
                                            const selectedValues = instances.periodsChoice.getValue(true) || [];
                                            const selectedPeriods = Array.isArray(selectedValues) 
                                                ? selectedValues.filter(val => val).sort()
                                                : (selectedValues ? [selectedValues] : []);
                                            
                                            // Compare dengan previous values
                                            const prevPeriods = previousValues.periods || [];
                                            const prevSorted = [...prevPeriods].sort();
                                            
                                            // Hanya update jika berbeda
                                            if (JSON.stringify(selectedPeriods) !== JSON.stringify(prevSorted)) {
                                                // Update previous values SEBELUM update Livewire
                                                previousValues.periods = selectedPeriods;
                                                comp.set('periods', selectedPeriods);
                                            }
                                        }
                                    } catch (e) {
                                        console.warn('Error setting periods:', e);
                                    }
                                };

                                periodsSelect.addEventListener('change', updatePeriodsIfChanged);
                                
                                periodsSelect.closest('.choices')?.addEventListener('click', function(e) {
                                    if (e.target.closest('.choices__button')) {
                                        // Delay lebih lama untuk memastikan Choices.js sudah remove item dari DOM
                                        setTimeout(updatePeriodsIfChanged, 50);
                                    }
                                });
                                
                                try {
                                    const comp = getLivewireComponent();
                                    if (comp) {
                                        const currentPeriods = comp.periods || [];
                                        previousValues.periods = [...currentPeriods].sort();
                                        
                                        const currentActive = instances.periodsChoice.getValue(true) || [];
                                        currentActive.forEach(val => {
                                            try {
                                                instances.periodsChoice.removeActiveItemsByValue(String(val));
                                            } catch (e) {}
                                        });
                                        if (currentPeriods.length > 0) {
                                            setTimeout(() => {
                                                currentPeriods.forEach(period => {
                                                    try {
                                                        instances.periodsChoice.setChoiceByValue(period);
                                                    } catch (e) {}
                                                });
                                            }, 100);
                                        }
                                    }
                                } catch (e) {}
                            }
                        }
                        
                        // Init Date Range - init ulang jika elemen ada di DOM tapi instance belum ada atau sudah di-destroy
                        const dateRangeInput = document.getElementById('dateRangeFilter');
                        if (dateRangeInput) {
                            // Destroy instance lama jika ada (untuk re-init)
                            if (instances.dateRangePicker) {
                                try {
                                    instances.dateRangePicker.destroy();
                                } catch (e) {
                                    // Ignore
                                }
                                instances.dateRangePicker = null;
                            }
                            
                            // Init baru
                            instances.dateRangePicker = initFlatpickr('dateRangeFilter', {
                                mode: 'range',
                                dateFormat: 'Y-m-d',
                                altInput: true,
                                altFormat: 'd M, Y',
                                disableMobile: true,
                            });
                            
                            // Set initial dates dari Livewire dan simpan sebagai previous values
                            // HANYA set saat pertama kali init (saat showAllFilters berubah menjadi true)
                            // Jangan set jika user sudah memilih tanggal (untuk avoid override)
                            if (instances.dateRangePicker) {
                                try {
                                    const comp = getLivewireComponent();
                                    if (comp) {
                                        const dateFrom = comp.dateFrom || '';
                                        const dateTo = comp.dateTo || '';
                                        
                                        // Check current dates di Flatpickr (seharusnya masih kosong saat init)
                                        const currentDates = instances.dateRangePicker.selectedDates || [];
                                        
                                        // Set initial dates berdasarkan server values
                                        // Jika server punya tanggal, set ke Flatpickr
                                        // Jika server tidak punya tanggal, clear Flatpickr (clear all filters)
                                        if (dateFrom && dateTo) {
                                            // Server punya tanggal
                                            if (currentDates.length === 0) {
                                                // Flatpickr belum punya tanggal, set dari server
                                                previousValues.dateFrom = dateFrom;
                                                previousValues.dateTo = dateTo;
                                                instances.dateRangePicker.setDate([dateFrom, dateTo], false);
                                            } else if (currentDates.length === 2) {
                                                // Flatpickr sudah punya 2 tanggal, check apakah berbeda
                                                const currentFrom = currentDates[0].toISOString().split('T')[0];
                                                const currentTo = currentDates[1].toISOString().split('T')[0];
                                                if (currentFrom !== dateFrom || currentTo !== dateTo) {
                                                    // Berbeda, update dari server
                                                    previousValues.dateFrom = dateFrom;
                                                    previousValues.dateTo = dateTo;
                                                    instances.dateRangePicker.setDate([dateFrom, dateTo], false);
                                                } else {
                                                    // Sama, hanya update previous values
                                                    previousValues.dateFrom = dateFrom;
                                                    previousValues.dateTo = dateTo;
                                                }
                                            } else {
                                                // Flatpickr punya 1 tanggal (user sedang memilih), update previous values saja
                                                previousValues.dateFrom = dateFrom;
                                                previousValues.dateTo = dateTo;
                                            }
                                        } else {
                                            // Server tidak punya tanggal (cleared oleh clear all filters), clear Flatpickr
                                            if (currentDates.length > 0) {
                                                // Clear Flatpickr jika ada tanggal
                                                instances.dateRangePicker.clear();
                                            }
                                            // Update previous values
                                            previousValues.dateFrom = '';
                                            previousValues.dateTo = '';
                                        }
                                    }
                                } catch (e) {
                                    // Ignore
                                }
                            }
                        }
                    }, 300);
                }
                
                if (currentShowAllFilters && !showAllFiltersChanged) {
                    if (instances.categoriesChoice) {
                        try {
                            const serverCategories = component.categories || [];
                            const currentSelected = instances.categoriesChoice.getValue(true) || [];
                            const selectedIds = Array.isArray(currentSelected) 
                                ? currentSelected.map(id => parseInt(id)).filter(id => !isNaN(id)).sort((a, b) => a - b)
                                : [];
                            const serverSorted = [...serverCategories].sort((a, b) => a - b);
                            if (JSON.stringify(selectedIds) !== JSON.stringify(serverSorted)) {
                                previousValues.categories = serverSorted;
                                const currentActive = instances.categoriesChoice.getValue(true) || [];
                                currentActive.forEach(val => {
                                    try {
                                        instances.categoriesChoice.removeActiveItemsByValue(String(val));
                                    } catch (e) {}
                                });
                                if (serverCategories.length > 0) {
                                    setTimeout(() => {
                                        serverCategories.forEach(id => {
                                            try {
                                                instances.categoriesChoice.setChoiceByValue(id.toString());
                                            } catch (e) {}
                                        });
                                    }, 50);
                                }
                            }
                        } catch (e) {}
                    }
                    
                    if (instances.periodsChoice) {
                        try {
                            const serverPeriods = component.periods || [];
                            const currentSelected = instances.periodsChoice.getValue(true) || [];
                            const selectedPeriods = Array.isArray(currentSelected) 
                                ? currentSelected.filter(val => val).sort()
                                : [];
                            const serverSorted = [...serverPeriods].sort();
                            if (JSON.stringify(selectedPeriods) !== JSON.stringify(serverSorted)) {
                                previousValues.periods = serverSorted;
                                const currentActive = instances.periodsChoice.getValue(true) || [];
                                currentActive.forEach(val => {
                                    try {
                                        instances.periodsChoice.removeActiveItemsByValue(String(val));
                                    } catch (e) {}
                                });
                                if (serverPeriods.length > 0) {
                                    setTimeout(() => {
                                        serverPeriods.forEach(period => {
                                            try {
                                                instances.periodsChoice.setChoiceByValue(period);
                                            } catch (e) {}
                                        });
                                    }, 50);
                                }
                            }
                        } catch (e) {}
                    }
                } else if (showAllFiltersChanged && !currentShowAllFilters) {
                    // Jika showAllFilters berubah dari true ke false, destroy instances untuk free memory
                    // Tapi jangan destroy statusChoice karena selalu visible
                    if (instances.categoriesChoice) {
                        try {
                            instances.categoriesChoice.destroy();
                        } catch (e) {
                            // Ignore
                        }
                        instances.categoriesChoice = null;
                    }
                    if (instances.periodsChoice) {
                        try {
                            instances.periodsChoice.destroy();
                        } catch (e) {
                            // Ignore
                        }
                        instances.periodsChoice = null;
                    }
                    if (instances.dateRangePicker) {
                        try {
                            // Clear date range sebelum destroy
                            instances.dateRangePicker.clear();
                            instances.dateRangePicker.destroy();
                        } catch (e) {
                            // Ignore
                        }
                        instances.dateRangePicker = null;
                    }
                    
                    // Reset previous values untuk filter fields yang di-destroy
                    previousValues.categories = [];
                    previousValues.periods = [];
                    previousValues.dateFrom = '';
                    previousValues.dateTo = '';
                    
                    // Update previous state
                    previousShowAllFilters = currentShowAllFilters;
                } else {
                    // showAllFilters tidak berubah, hanya update previous state
                    previousShowAllFilters = currentShowAllFilters;
                }

                if (instances.statusChoice) {
                    try {
                        const serverStatus = component.status || 'all';
                        const currentValue = instances.statusChoice.getValue(true);
                        if (currentValue !== serverStatus && previousValues.status !== serverStatus) {
                            previousValues.status = serverStatus;
                            instances.statusChoice.setChoiceByValue(serverStatus);
                        }
                    } catch (e) {
                        // Ignore
                    }
                }
                
                if (instances.jurusanFilterChoice) {
                    try {
                        const serverJurusan = component.jurusanFilter || '';
                        const currentValue = instances.jurusanFilterChoice.getValue(true);
                        if (currentValue !== serverJurusan && previousValues.jurusanFilter !== serverJurusan) {
                            previousValues.jurusanFilter = serverJurusan;
                            instances.jurusanFilterChoice.setChoiceByValue(serverJurusan);
                        }
                    } catch (e) {
                        // Ignore
                    }
                }
                
                // Sync Per Page - hanya jika instance sudah ada DAN nilai berbeda
                if (instances.perPageChoice) {
                    try {
                        const serverPerPage = component.perPage || 10;
                        const currentValue = instances.perPageChoice.getValue(true);
                        const serverPerPageStr = serverPerPage.toString();
                        if (currentValue !== serverPerPageStr && previousValues.perPage !== serverPerPage) {
                            previousValues.perPage = serverPerPage;
                            instances.perPageChoice.setChoiceByValue(serverPerPageStr);
                        }
                    } catch (e) {
                        // Ignore
                    }
                }
                
                // Sync Categories - hanya jika instance sudah ada DAN nilai berbeda
                if (instances.categoriesChoice && currentShowAllFilters && !isSyncing) {
                    try {
                        const serverCategories = component.categories || [];
                        const serverCategoriesSorted = [...serverCategories].sort((a, b) => a - b);
                        const prevCategoriesSorted = (previousValues.categories || []).sort((a, b) => a - b);
                        
                        // Hanya sync jika nilai di server berbeda dengan previous values
                        // (ini berarti server update karena clear filters atau remove filter)
                        if (JSON.stringify(serverCategoriesSorted) !== JSON.stringify(prevCategoriesSorted)) {
                            // Get current selected values dari Choices (setelah user action)
                            const currentSelected = instances.categoriesChoice.getValue(true) || [];
                            const currentSelectedIds = Array.isArray(currentSelected) 
                                ? currentSelected.map(id => parseInt(id)).filter(id => !isNaN(id)).sort((a, b) => a - b)
                                : [];
                            
                            // Compare current selected dengan server values
                            const currentMatchesServer = JSON.stringify(currentSelectedIds) === JSON.stringify(serverCategoriesSorted);
                            
                            if (!currentMatchesServer) {
                                // Current selected berbeda dengan server
                                // TAPI: jika current selected adalah hasil dari user action (remove button),
                                // dan current selected sudah sesuai dengan nilai yang user inginkan,
                                // maka kita tidak perlu sync karena user action sudah benar.
                                // Sync hanya diperlukan jika server values berbeda karena alasan lain
                                // (misalnya clear all filters, atau remove filter dari badge)
                                
                                // Check apakah current selected adalah subset dari previous values
                                // (ini berarti user remove item, dan Choices.js sudah update dengan benar)
                                const prevCategoriesSorted = (previousValues.categories || []).sort((a, b) => a - b);
                                const isUserRemoveAction = currentSelectedIds.length < prevCategoriesSorted.length &&
                                                          currentSelectedIds.every(id => prevCategoriesSorted.includes(id));
                                
                                if (isUserRemoveAction && JSON.stringify(currentSelectedIds) === JSON.stringify(serverCategoriesSorted)) {
                                    // User remove item, dan current selected sudah sesuai dengan server
                                    // Ini berarti user action sudah benar, hanya update previous values
                                    previousValues.categories = serverCategoriesSorted;
                                    // Tidak perlu sync, Choices.js sudah benar
                                } else {
                                    // Perlu sync (bukan dari user remove action, atau server values berbeda)
                                    isSyncing = true; // Set flag untuk avoid loop
                                    
                                    // Find items to remove (ada di current tapi tidak ada di server)
                                    const itemsToRemove = currentSelectedIds.filter(id => !serverCategoriesSorted.includes(id));
                                    
                                    // Find items to add (ada di server tapi tidak ada di current)
                                    const itemsToAdd = serverCategoriesSorted.filter(id => !currentSelectedIds.includes(id));
                                
                                    // Remove items yang tidak ada di server (hanya remove yang perlu di-remove)
                                    // Gunakan method Choices.js yang tepat untuk remove item spesifik
                                    itemsToRemove.forEach(id => {
                                        try {
                                            // Remove item dari Choices.js menggunakan removeActiveItemsByValue
                                            instances.categoriesChoice.removeActiveItemsByValue(id.toString());
                                        } catch (e) {
                                            // Jika removeActiveItemsByValue tidak work, coba cara lain
                                            console.warn('Error removing category item:', e);
                                        }
                                    });
                                    
                                    // Add items yang ada di server tapi belum selected (hanya add yang perlu di-add)
                                    itemsToAdd.forEach(id => {
                                        try {
                                            instances.categoriesChoice.setChoiceByValue(id.toString());
                                        } catch (e) {
                                            // Ignore
                                        }
                                    });
                                    
                                    // Update previous values
                                    previousValues.categories = serverCategoriesSorted;
                                    
                                    // Reset flag setelah sync selesai
                                    setTimeout(() => {
                                        isSyncing = false;
                                    }, 100);
                                }
                            } else {
                                // Current selected sudah sesuai dengan server, hanya update previous values
                                previousValues.categories = serverCategoriesSorted;
                            }
                        }
                    } catch (e) {
                        isSyncing = false; // Reset flag jika error
                        // Ignore
                    }
                }
                
                // Sync Periods - hanya jika instance sudah ada DAN nilai berbeda
                if (instances.periodsChoice && currentShowAllFilters && !isSyncing) {
                    try {
                        const serverPeriods = component.periods || [];
                        const serverPeriodsSorted = [...serverPeriods].sort();
                        const prevPeriodsSorted = (previousValues.periods || []).sort();
                        
                        // Hanya sync jika nilai di server berbeda dengan previous values
                        if (JSON.stringify(serverPeriodsSorted) !== JSON.stringify(prevPeriodsSorted)) {
                            // Get current selected values dari Choices (setelah user action)
                            const currentSelected = instances.periodsChoice.getValue(true) || [];
                            const currentSelectedPeriods = Array.isArray(currentSelected) 
                                ? currentSelected.sort()
                                : (currentSelected ? [currentSelected] : []);
                            
                            // Compare current selected dengan server values
                            const currentMatchesServer = JSON.stringify(currentSelectedPeriods) === JSON.stringify(serverPeriodsSorted);
                            
                            if (!currentMatchesServer) {
                                // Current selected berbeda dengan server
                                // TAPI: jika current selected adalah hasil dari user action (remove button),
                                // dan current selected sudah sesuai dengan nilai yang user inginkan,
                                // maka kita tidak perlu sync karena user action sudah benar.
                                
                                // Check apakah current selected adalah subset dari previous values
                                // (ini berarti user remove item, dan Choices.js sudah update dengan benar)
                                const prevPeriodsSorted = (previousValues.periods || []).sort();
                                const isUserRemoveAction = currentSelectedPeriods.length < prevPeriodsSorted.length &&
                                                          currentSelectedPeriods.every(period => prevPeriodsSorted.includes(period));
                                
                                if (isUserRemoveAction && JSON.stringify(currentSelectedPeriods) === JSON.stringify(serverPeriodsSorted)) {
                                    // User remove item, dan current selected sudah sesuai dengan server
                                    // Ini berarti user action sudah benar, hanya update previous values
                                    previousValues.periods = serverPeriodsSorted;
                                    // Tidak perlu sync, Choices.js sudah benar
                                } else {
                                    // Perlu sync (bukan dari user remove action, atau server values berbeda)
                                    isSyncing = true; // Set flag untuk avoid loop
                                    
                                    // Find items to remove (ada di current tapi tidak ada di server)
                                    const itemsToRemove = currentSelectedPeriods.filter(period => !serverPeriodsSorted.includes(period));
                                    
                                    // Find items to add (ada di server tapi tidak ada di current)
                                    const itemsToAdd = serverPeriodsSorted.filter(period => !currentSelectedPeriods.includes(period));
                                    
                                    // Remove items yang tidak ada di server (hanya remove yang perlu di-remove)
                                    itemsToRemove.forEach(period => {
                                        try {
                                            // Remove item dari Choices.js menggunakan removeActiveItemsByValue
                                            instances.periodsChoice.removeActiveItemsByValue(period);
                                        } catch (e) {
                                            // Jika removeActiveItemsByValue tidak work, coba cara lain
                                            console.warn('Error removing period item:', e);
                                        }
                                    });
                                    
                                    // Add items yang ada di server tapi belum selected (hanya add yang perlu di-add)
                                    itemsToAdd.forEach(period => {
                                        try {
                                            instances.periodsChoice.setChoiceByValue(period);
                                        } catch (e) {
                                            // Ignore
                                        }
                                    });
                                    
                                    // Update previous values
                                    previousValues.periods = serverPeriodsSorted;
                                    
                                    // Reset flag setelah sync selesai
                                    setTimeout(() => {
                                        isSyncing = false;
                                    }, 100);
                                }
                            } else {
                                // Current selected sudah sesuai dengan server, hanya update previous values
                                previousValues.periods = serverPeriodsSorted;
                            }
                        }
                    } catch (e) {
                        isSyncing = false; // Reset flag jika error
                        // Ignore
                    }
                }
                
                // Sync Date Range - hanya jika instance sudah ada DAN nilai berbeda
                if (instances.dateRangePicker && currentShowAllFilters) {
                    try {
                        const serverDateFrom = component.dateFrom || '';
                        const serverDateTo = component.dateTo || '';
                        const prevDateFrom = previousValues.dateFrom || '';
                        const prevDateTo = previousValues.dateTo || '';
                        
                        const serverChanged = (serverDateFrom !== prevDateFrom) || (serverDateTo !== prevDateTo);
                        
                        if (serverChanged) {
                            // Update previous values
                            previousValues.dateFrom = serverDateFrom;
                            previousValues.dateTo = serverDateTo;

                            const currentDates = instances.dateRangePicker.selectedDates || [];
                            const hasCurrentDates = currentDates.length === 2;
                            
                            if (serverDateFrom && serverDateTo) {
                                if (!hasCurrentDates) {
                                    instances.dateRangePicker.setDate([serverDateFrom, serverDateTo], false);
                                } else {
                                    const currentFrom = currentDates[0].toISOString().split('T')[0];
                                    const currentTo = currentDates[1].toISOString().split('T')[0];
                                    if (currentFrom !== serverDateFrom || currentTo !== serverDateTo) {
                                        instances.dateRangePicker.setDate([serverDateFrom, serverDateTo], false);
                                    }
                                }
                            } else {

                                if (hasCurrentDates) {
                                    instances.dateRangePicker.clear();
                                } else if (currentDates.length === 1) {
                                    instances.dateRangePicker.clear();
                                }
                            }
                        }
                    } catch (e) {
                        // Ignore
                    }
                }
                
                // Update header buttons
                updateHeaderButtons();
                
                // Update bulk actions
                updateBulkActions();
            }, 100);
        });
    });

    // ============================================
    // Client-side Checkbox Selection Management
    // ============================================
    // Store selected items in JavaScript (client-side) to avoid server round-trip on every checkbox click
    let clientSelectedItems = new Set();
    let isInitialized = false;

    // Initialize client-side selection from server state
    function initClientSelection() {
        const component = getLivewireComponent();
        if (!component) return;

        // Get initial selected items from Livewire component
        const serverSelectedItems = component.selectedItems || [];
        clientSelectedItems = new Set(serverSelectedItems.map(id => parseInt(id)));

        // Update checkboxes based on client state
        updateCheckboxesFromClientState();
        updateSelectAllCheckbox();
        
        // Update bulk action buttons visibility
        updateBulkActions();
    }

    // Update checkboxes based on client-side state
    function updateCheckboxesFromClientState() {
        document.querySelectorAll('.checkbox-item').forEach(checkbox => {
            const itemId = parseInt(checkbox.getAttribute('data-item-id') || checkbox.value);
            checkbox.checked = clientSelectedItems.has(itemId);
        });
    }

    // Update select all checkbox based on current page items
    function updateSelectAllCheckbox() {
        const checkAll = document.getElementById('checkAll');
        if (!checkAll) return;

        const currentPageCheckboxes = Array.from(document.querySelectorAll('.checkbox-item'));
        if (currentPageCheckboxes.length === 0) {
            checkAll.checked = false;
            checkAll.indeterminate = false;
            return;
        }

        const currentPageIds = currentPageCheckboxes.map(cb => parseInt(cb.getAttribute('data-item-id') || cb.value));
        const allSelected = currentPageIds.every(id => clientSelectedItems.has(id));
        const someSelected = currentPageIds.some(id => clientSelectedItems.has(id));

        checkAll.checked = allSelected && currentPageIds.length > 0;
        checkAll.indeterminate = someSelected && !allSelected;
    }

    // Sync client-side selection to Livewire (only when needed)
    function syncSelectionToServer() {
        const component = getLivewireComponent();
        if (!component) return;

        // Convert Set to Array
        const selectedArray = Array.from(clientSelectedItems);
        
        // Call Livewire method to sync
        component.call('syncSelectedItems', selectedArray);
    }

    // Handle individual checkbox click (client-side only)
    function handleCheckboxClick(event) {
        const checkbox = event.target;
        const itemId = parseInt(checkbox.getAttribute('data-item-id') || checkbox.value);

        if (checkbox.checked) {
            clientSelectedItems.add(itemId);
        } else {
            clientSelectedItems.delete(itemId);
        }

        // Update select all checkbox state
        updateSelectAllCheckbox();
        
        // Update bulk action buttons visibility
        updateBulkActions();

        // NO server sync here - only sync when needed (bulk actions, select all, etc.)
    }

    // Handle select all checkbox click
    function handleSelectAllClick(event) {
        const checkAll = event.target;
        const currentPageCheckboxes = Array.from(document.querySelectorAll('.checkbox-item'));
        const currentPageIds = currentPageCheckboxes.map(cb => parseInt(cb.getAttribute('data-item-id') || cb.value));

        if (checkAll.checked) {
            // Add all current page items
            currentPageIds.forEach(id => clientSelectedItems.add(id));
        } else {
            // Remove all current page items
            currentPageIds.forEach(id => clientSelectedItems.delete(id));
        }

        // Update all checkboxes
        currentPageCheckboxes.forEach(checkbox => {
            checkbox.checked = checkAll.checked;
        });

        // Update bulk action buttons visibility
        updateBulkActions();

        // Sync to server when select all is used
        syncSelectionToServer();
    }

    // Initialize checkbox handlers
    function initCheckboxHandlers() {
        if (isInitialized) return;

        // Handle individual checkbox clicks
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('checkbox-item')) {
                handleCheckboxClick(event);
            }
        });

        // Handle select all checkbox
        const checkAll = document.getElementById('checkAll');
        if (checkAll) {
            checkAll.addEventListener('click', handleSelectAllClick);
        }

        // Initialize from server state
        document.addEventListener('livewire:init', function() {
            setTimeout(() => {
                initClientSelection();
            }, 100);
        });

        // Re-initialize after Livewire updates
        document.addEventListener('livewire:updated', function() {
            setTimeout(() => {
                // Check if selection should be cleared (after bulk action)
                const component = getLivewireComponent();
                if (component) {
                    const serverSelectedItems = component.selectedItems || [];
                    // If server has no selected items but client has, clear client selection
                    if (serverSelectedItems.length === 0 && clientSelectedItems.size > 0) {
                        // This likely means bulk action completed, clear selection
                        clientSelectedItems.clear();
                    } else if (serverSelectedItems.length > 0) {
                        // Sync from server to client (in case server state changed)
                        clientSelectedItems = new Set(serverSelectedItems.map(id => parseInt(id)));
                    }
                }
                
                // Update checkboxes from client state
                updateCheckboxesFromClientState();
                updateSelectAllCheckbox();
                
                // Update bulk action buttons visibility
                updateBulkActions();
            }, 100);
        });

        isInitialized = true;
    }

    // Get selected items for bulk actions (from client-side)
    function getSelectedItems() {
        return Array.from(clientSelectedItems);
    }

    // Clear selection (after bulk action)
    function clearSelection() {
        clientSelectedItems.clear();
        updateCheckboxesFromClientState();
        updateSelectAllCheckbox();
        updateBulkActions(); // Hide bulk action buttons after clearing
    }

    // Export functions for use in other scripts
    window.newsWireSelection = {
        getSelectedItems: getSelectedItems,
        clearSelection: clearSelection,
        syncSelectionToServer: syncSelectionToServer
    };

    // ============================================
    // Individual Delete Handler
    // ============================================
    /**
     * Confirm and delete individual news item
     * @param {number} id - News item ID
     */
    function confirmDelete(id) {
        if (typeof window.confirmDeleteWithCallback === 'undefined') {
            console.error('confirmDeleteWithCallback helper is not defined. Make sure notif-alert.js is loaded.');
            return;
        }
        
        // Use helper from notif-alert.js
        window.confirmDeleteWithCallback('Apakah Anda yakin ingin menghapus berita ini?', function() {
            // Get Livewire component dan call delete method
            const component = getLivewireComponent();
            if (component) {
                component.call('delete', id);
            }
        });
    }

    // Export confirmDelete untuk digunakan di onclick (keep original name for backward compatibility with blade template)
    window.confirmDelete = confirmDelete;

    // ============================================
    // Flash Messages Handler
    // ============================================
    /**
     * Check and display flash messages from Livewire
     */
    function checkFlashMessages() {
        // Check untuk success message
        const successMsg = document.querySelector('.flash-message-success');
        if (successMsg && typeof showSuccess !== 'undefined') {
            const message = successMsg.getAttribute('data-message');
            if (message) {
                showSuccess(message);
                // Remove element setelah ditampilkan
                successMsg.remove();
            }
        }

        // Check untuk error message
        const errorMsg = document.querySelector('.flash-message-error');
        if (errorMsg && typeof showError !== 'undefined') {
            const message = errorMsg.getAttribute('data-message');
            if (message) {
                showError(message);
                // Remove element setelah ditampilkan
                errorMsg.remove();
            }
        }
    }

    // Listen untuk flash messages dari Livewire
    document.addEventListener('livewire:init', function() {
        // Check flash messages setelah Livewire update
        Livewire.hook('morph.updated', ({ component, el }) => {
            setTimeout(() => {
                checkFlashMessages();
            }, 100);
        });

        // Check flash messages saat pertama kali load
        setTimeout(() => {
            checkFlashMessages();
        }, 200);
    });

    // ============================================
    // Bulk Action Buttons Handler
    // ============================================
    /**
     * Helper function to get selected items from client-side and sync to server
     * @param {Object} component - Livewire component instance
     * @returns {Array|null} - Array of selected item IDs or null if empty
     */
    function getSelectedItemsAndSync(component) {
        // Get selected items from client-side JavaScript
        const selectedItems = window.newsWireSelection ? window.newsWireSelection.getSelectedItems() : [];
        
        if (selectedItems.length === 0) {
            return null;
        }
        
        // Sync to server before bulk action
        if (window.newsWireSelection && window.newsWireSelection.syncSelectionToServer) {
            window.newsWireSelection.syncSelectionToServer();
        }
        
        return selectedItems;
    }

    /**
     * Setup bulk action buttons event listeners
     */
    function initBulkActionButtons() {
        const component = getLivewireComponent();
        if (!component) {
            // Retry after a short delay if component not ready
            setTimeout(initBulkActionButtons, 100);
            return;
        }

        // Bulk Published Button
        const bulkPublishedBtn = document.getElementById('bulkPublishedBtn');
        if (bulkPublishedBtn && !bulkPublishedBtn.hasAttribute('data-listener-attached')) {
            bulkPublishedBtn.setAttribute('data-listener-attached', 'true');
            bulkPublishedBtn.addEventListener('click', function() {
                const selectedItems = getSelectedItemsAndSync(component);
                if (!selectedItems || selectedItems.length === 0) {
                    if (typeof showWarning !== 'undefined') {
                        showWarning('Pilih setidaknya satu item.');
                    }
                    return;
                }
                if (typeof showBulkStatusConfirm !== 'undefined') {
                    showBulkStatusConfirm('published', selectedItems.length).then((result) => {
                        if (result.isConfirmed) {
                            setTimeout(() => {
                                component.call('bulkUpdateStatus', 'published');
                                if (window.newsWireSelection && window.newsWireSelection.clearSelection) {
                                    window.newsWireSelection.clearSelection();
                                }
                            }, 100);
                        }
                    });
                }
            });
        }

        // Bulk Draft Button
        const bulkDraftBtn = document.getElementById('bulkDraftBtn');
        if (bulkDraftBtn && !bulkDraftBtn.hasAttribute('data-listener-attached')) {
            bulkDraftBtn.setAttribute('data-listener-attached', 'true');
            bulkDraftBtn.addEventListener('click', function() {
                const selectedItems = getSelectedItemsAndSync(component);
                if (!selectedItems || selectedItems.length === 0) {
                    if (typeof showWarning !== 'undefined') {
                        showWarning('Pilih setidaknya satu item.');
                    }
                    return;
                }
                if (typeof showBulkStatusConfirm !== 'undefined') {
                    showBulkStatusConfirm('draft', selectedItems.length).then((result) => {
                        if (result.isConfirmed) {
                            setTimeout(() => {
                                component.call('bulkUpdateStatus', 'draft');
                                if (window.newsWireSelection && window.newsWireSelection.clearSelection) {
                                    window.newsWireSelection.clearSelection();
                                }
                            }, 100);
                        }
                    });
                }
            });
        }

        // Bulk Archived Button
        const bulkArchivedBtn = document.getElementById('bulkArchivedBtn');
        if (bulkArchivedBtn && !bulkArchivedBtn.hasAttribute('data-listener-attached')) {
            bulkArchivedBtn.setAttribute('data-listener-attached', 'true');
            bulkArchivedBtn.addEventListener('click', function() {
                const selectedItems = getSelectedItemsAndSync(component);
                if (!selectedItems || selectedItems.length === 0) {
                    if (typeof showWarning !== 'undefined') {
                        showWarning('Pilih setidaknya satu item.');
                    }
                    return;
                }
                if (typeof showBulkStatusConfirm !== 'undefined') {
                    showBulkStatusConfirm('archived', selectedItems.length).then((result) => {
                        if (result.isConfirmed) {
                            setTimeout(() => {
                                component.call('bulkUpdateStatus', 'archived');
                                if (window.newsWireSelection && window.newsWireSelection.clearSelection) {
                                    window.newsWireSelection.clearSelection();
                                }
                            }, 100);
                        }
                    });
                }
            });
        }

        // Bulk Featured Button
        const bulkFeaturedBtn = document.getElementById('bulkFeaturedBtn');
        if (bulkFeaturedBtn && !bulkFeaturedBtn.hasAttribute('data-listener-attached')) {
            bulkFeaturedBtn.setAttribute('data-listener-attached', 'true');
            bulkFeaturedBtn.addEventListener('click', function() {
                const selectedItems = getSelectedItemsAndSync(component);
                if (!selectedItems || selectedItems.length === 0) {
                    if (typeof showWarning !== 'undefined') {
                        showWarning('Pilih setidaknya satu item.');
                    }
                    return;
                }
                if (typeof showBulkFeaturedConfirm !== 'undefined') {
                    showBulkFeaturedConfirm(selectedItems.length).then((result) => {
                        if (result.isConfirmed) {
                            setTimeout(() => {
                                component.call('bulkToggleFeatured');
                                if (window.newsWireSelection && window.newsWireSelection.clearSelection) {
                                    window.newsWireSelection.clearSelection();
                                }
                            }, 100);
                        }
                    });
                }
            });
        }

        // Bulk Delete Button
        const bulkDeleteBtn = document.getElementById('bulkDeleteBtn');
        if (bulkDeleteBtn && !bulkDeleteBtn.hasAttribute('data-listener-attached')) {
            bulkDeleteBtn.setAttribute('data-listener-attached', 'true');
            bulkDeleteBtn.addEventListener('click', function() {
                const selectedItems = getSelectedItemsAndSync(component);
                if (!selectedItems || selectedItems.length === 0) {
                    if (typeof showWarning !== 'undefined') {
                        showWarning('Pilih setidaknya satu item.');
                    }
                    return;
                }
                if (typeof showBulkDeleteConfirm !== 'undefined') {
                    showBulkDeleteConfirm(selectedItems.length).then((result) => {
                        if (result.isConfirmed) {
                            setTimeout(() => {
                                component.call('bulkDelete');
                                if (window.newsWireSelection && window.newsWireSelection.clearSelection) {
                                    window.newsWireSelection.clearSelection();
                                }
                            }, 100);
                        }
                    });
                }
            });
        }
    }

    // Initialize bulk action buttons after Livewire is ready
    document.addEventListener('livewire:init', function() {
        // Initialize bulk action buttons after a short delay to ensure DOM is ready
        setTimeout(() => {
            initBulkActionButtons();
        }, 300);
    });

    // Re-initialize bulk action buttons after Livewire updates (in case buttons are re-rendered)
    document.addEventListener('livewire:updated', function() {
        setTimeout(() => {
            initBulkActionButtons();
        }, 100);
    });

    // Initialize on DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCheckboxHandlers);
    } else {
        initCheckboxHandlers();
    }
})();

