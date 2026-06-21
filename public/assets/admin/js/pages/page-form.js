/**
 * Page Form Handler
 */

(function() {
    'use strict';
    
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize DKApps functions
        DKApps.initSlugField('title', 'slug');
        DKApps.initImagePreview('image', 'imagePreview', 'removeImage');
        DKApps.initFilePreview('attachment', 'fileInfo', 'fileName', 'fileSize', 'removeFile');
    
    // Page type toggle
    const typePage = document.getElementById('type_page');
    const typeStructure = document.getElementById('type_structure');
    const contentSection = document.getElementById('content_section');
    const structureSection = document.getElementById('structure_section');
    
    function togglePageType() {
        const isPage = typePage.checked;
        
        if (isPage) {
            contentSection.classList.remove('d-none');
            structureSection.classList.add('d-none');
            document.querySelectorAll('.content-required').forEach(el => el.style.display = '');
            document.querySelectorAll('.structure-required').forEach(el => el.style.display = 'none');
        } else {
            contentSection.classList.add('d-none');
            structureSection.classList.remove('d-none');
            document.querySelectorAll('.content-required').forEach(el => el.style.display = 'none');
            document.querySelectorAll('.structure-required').forEach(el => el.style.display = '');
        }
    }
    
    if (typePage && typeStructure) {
        typePage.addEventListener('change', togglePageType);
        typeStructure.addEventListener('change', togglePageType);
        togglePageType(); // Initial state
    }
    
    // Handle "Tampilkan Semua Struktur" checkbox
    const showAllCheckbox = document.getElementById('show_all_structures');
    const structureSelect = document.getElementById('structure_common_id');
    const structureRequired = document.getElementById('structure_required');
    
    function toggleStructureSelect() {
        if (showAllCheckbox && showAllCheckbox.checked) {
            structureSelect.disabled = true;
            structureSelect.value = '';
            structureSelect.classList.remove('is-invalid');
            if (structureRequired) structureRequired.style.display = 'none';
        } else {
            structureSelect.disabled = false;
            if (structureRequired) structureRequired.style.display = '';
        }
    }
    
    if (showAllCheckbox) {
        showAllCheckbox.addEventListener('change', toggleStructureSelect);
        toggleStructureSelect(); // Initial state
    }
    
    // Filter struktur berdasarkan tipe dan periode
    const structureTypeSelect = document.getElementById('structure_type');
    const periodSelect = document.getElementById('period_select');
    
    function filterStructures() {
        const selectedType = structureTypeSelect ? structureTypeSelect.value : '';
        const selectedPeriod = periodSelect ? periodSelect.value : '';
        
        if (!structureSelect) return;
        
        const options = structureSelect.querySelectorAll('option');
        let visibleCount = 0;
        
        // Debug: log first option to see data
        if (options.length > 1) {
            console.log('Sample option:', {
                type: options[1].getAttribute('data-type'),
                period: options[1].getAttribute('data-period'),
                text: options[1].textContent
            });
            console.log('Selected filters:', {
                type: selectedType,
                period: selectedPeriod
            });
        }
        
        options.forEach(option => {
            if (option.value === '') {
                option.style.display = '';
                return;
            }
            
            const optionType = option.getAttribute('data-type');
            const optionPeriod = option.getAttribute('data-period');
            
            let showOption = true;
            
            // Filter by type
            if (selectedType && optionType !== selectedType) {
                showOption = false;
            }
            
            // Filter by period - make it optional if no period selected
            if (selectedPeriod && selectedPeriod !== '' && optionPeriod && optionPeriod !== selectedPeriod) {
                showOption = false;
            }
            
            option.style.display = showOption ? '' : 'none';
            if (showOption) visibleCount++;
        });
        
        // Reset selection if current selection is hidden
        const currentOption = structureSelect.options[structureSelect.selectedIndex];
        if (currentOption && currentOption.style.display === 'none') {
            structureSelect.value = '';
        }
        
        // Update placeholder text
        const placeholder = structureSelect.querySelector('option[value=""]');
        if (placeholder) {
            if (visibleCount === 0) {
                placeholder.textContent = '-- Tidak ada struktur untuk filter ini --';
            } else {
                placeholder.textContent = `-- Pilih Struktur (${visibleCount} tersedia) --`;
            }
        }
        
        console.log('Visible count:', visibleCount);
    }
    
    if (structureTypeSelect) {
        structureTypeSelect.addEventListener('change', filterStructures);
    }
    
    if (periodSelect) {
        periodSelect.addEventListener('change', filterStructures);
    }
    
    // Initial filter
    filterStructures();
    
        // CKEditor is auto-initialized by dk-apps.js
        // No manual initialization needed here
        
        // Form validation with loading state
        const form = document.getElementById('pageForm');
        const submitBtn = document.getElementById('submitBtn');
        
        if (form && submitBtn) {
            form.addEventListener('submit', function(e) {
                const pageType = document.querySelector('input[name="page_type"]:checked').value;
                
                if (pageType === 'page') {
                    // Validate content for page type using CKEditor
                    const editorInstance = window.ckeditorInstances ? window.ckeditorInstances['editor'] : null;
                    
                    if (editorInstance) {
                        const content = editorInstance.getData();
                        const contentTextarea = document.getElementById('content');
                        
                        if (contentTextarea) {
                            contentTextarea.value = content;
                        }
                        
                        if (!content || content.trim() === '' || content === '<p>&nbsp;</p>' || content === '<p></p>') {
                            e.preventDefault();
                            
                            NotifAlert.error('Konten wajib diisi untuk tipe Page');
                            
                            const editorElement = document.getElementById('editor');
                            if (editorElement) {
                                editorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                            }
                            
                            return false;
                        }
                    }
                } else {
                    // Validate structure fields
                    const structureType = document.getElementById('structure_type').value;
                    const showAll = document.getElementById('show_all_structures');
                    const structureId = document.getElementById('structure_common_id').value;
                    
                    if (!structureType) {
                        e.preventDefault();
                        NotifAlert.error('Pilih tipe struktur untuk tipe halaman Structure');
                        return false;
                    }
                    
                    // If not "show all", structure must be selected
                    if (!showAll.checked && !structureId) {
                        e.preventDefault();
                        NotifAlert.error('Pilih struktur spesifik atau centang "Tampilkan Semua Struktur"');
                        return false;
                    }
                }
                
                // Show loading state on submit button
                submitBtn.disabled = true;
                submitBtn.innerHTML = `
                    <span class="d-flex align-items-center">
                        <span class="spinner-border spinner-border-sm flex-shrink-0" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </span>
                        <span class="flex-grow-1 ms-2">Menyimpan...</span>
                    </span>
                `;
            });
        }
    });
    
})();
