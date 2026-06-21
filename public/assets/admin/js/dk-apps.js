/**
 * DK Apps - Reusable JavaScript Functions
 * Common functions that can be used across multiple pages
 */

const DKApps = {
    /**
     * Initialize CKEditor5 (Old Version - Working Upload Image + Custom Fullscreen)
     */
    initCKEditor: function(elementId, initialContent = '', uploadUrl = '/admin/news/upload-image') {
        const element = document.querySelector(`#${elementId}`);
        if (!element) {
            console.error(`Element #${elementId} not found`);
            return Promise.reject(new Error(`Element #${elementId} not found`));
        }

        // Use Editor from custom build or ClassicEditor from classic build
        const EditorClass = window.ClassicEditor || window.Editor;
        if (!EditorClass) {
            console.error('CKEditor5 not loaded. Make sure ckeditor.js is loaded before this script.');
            return Promise.reject(new Error('CKEditor5 not loaded'));
        }

        return EditorClass
            .create(element, {
                toolbar: {
                    items: [
                        'heading', '|',
                        'bold', 'italic', 'underline', 'strikethrough', '|',
                        'fontSize', 'fontColor', 'fontBackgroundColor', '|',
                        'bulletedList', 'numberedList', '|',
                        'alignment', '|',
                        'link', 'uploadImage', 'insertTable', 'mediaEmbed', '|',
                        'blockQuote', 'codeBlock', '|',
                        'undo', 'redo','fullScreen'
                    ]
                },
                language: 'id',
                image: {
                    toolbar: [
                        'imageTextAlternative',
                        'toggleImageCaption',
                        'imageStyle:inline',
                        'imageStyle:block',
                        'imageStyle:side',
                        'linkImage'
                    ]
                },
                table: {
                    contentToolbar: [
                        'tableColumn',
                        'tableRow',
                        'mergeTableCells',
                        'tableCellProperties',
                        'tableProperties'
                    ]
                },
                simpleUpload: {
                    uploadUrl: uploadUrl,
                    withCredentials: true,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content')
                    }
                }
            })
            .then(editor => {
                if (initialContent) {
                    editor.setData(initialContent);
                }
                
                // Add custom fullscreen button
                this.addFullscreenButton(editor);
            
                return editor;
            })
            .catch(error => {
                console.error('Error initializing CKEditor:', error);
                throw error;
            });
    },

    /**
     * Add fullscreen button to CKEditor with proper height handling
     */
    addFullscreenButton: function(editor) {
        const editorElement = editor.ui.view.element;
        const toolbar = editorElement.querySelector('.ck-toolbar');
        const editableElement = editorElement.querySelector('.ck-editor__editable');
        
        if (!toolbar || !editableElement) return;
        
        // Create fullscreen button
        const fullscreenBtn = document.createElement('button');
        fullscreenBtn.className = 'ck ck-button ck-off';
        fullscreenBtn.type = 'button';
        fullscreenBtn.title = 'Toggle Fullscreen (ESC to exit)';
        fullscreenBtn.innerHTML = '<svg class="ck ck-icon ck-button__icon" viewBox="0 0 20 20"><path d="M2 2h7v2H4v5H2V2zm0 16h7v-2H4v-5H2v7zm16 0h-7v-2h5v-5h2v7zm0-16h-7v2h5v5h2V2z"/></svg>';
        
        // Add to toolbar
        toolbar.appendChild(fullscreenBtn);
        
        // Fullscreen state
        let isFullscreen = false;
        let originalStyles = {};
        
        // Toggle fullscreen function
        function toggleFullscreen() {
            isFullscreen = !isFullscreen;
            
            if (isFullscreen) {
                // Save original styles
                originalStyles = {
                    position: editorElement.style.position,
                    top: editorElement.style.top,
                    left: editorElement.style.left,
                    width: editorElement.style.width,
                    height: editorElement.style.height,
                    zIndex: editorElement.style.zIndex,
                    backgroundColor: editorElement.style.backgroundColor,
                    editableHeight: editableElement.style.height
                };
                
                // Enter fullscreen
                editorElement.style.position = 'fixed';
                editorElement.style.top = '0';
                editorElement.style.left = '0';
                editorElement.style.width = '100%';
                editorElement.style.height = '100vh';
                editorElement.style.zIndex = '9999';
                editorElement.style.backgroundColor = '#fff';
                editorElement.style.padding = '20px';
                
                // Calculate toolbar height and set editable height
                const toolbarHeight = toolbar.offsetHeight;
                editableElement.style.height = `calc(100vh - ${toolbarHeight + 60}px)`;
                editableElement.style.minHeight = `calc(100vh - ${toolbarHeight + 60}px)`;
                
                // Update button state
                fullscreenBtn.classList.add('ck-on');
                fullscreenBtn.title = 'Exit Fullscreen (ESC)';
                
                // Hide scrollbar on body
                document.body.style.overflow = 'hidden';
            } else {
                // Exit fullscreen - restore original styles
                editorElement.style.position = originalStyles.position;
                editorElement.style.top = originalStyles.top;
                editorElement.style.left = originalStyles.left;
                editorElement.style.width = originalStyles.width;
                editorElement.style.height = originalStyles.height;
                editorElement.style.zIndex = originalStyles.zIndex;
                editorElement.style.backgroundColor = originalStyles.backgroundColor;
                editorElement.style.padding = '';
                editableElement.style.height = originalStyles.editableHeight;
                editableElement.style.minHeight = '';
                
                // Update button state
                fullscreenBtn.classList.remove('ck-on');
                fullscreenBtn.title = 'Toggle Fullscreen (ESC to exit)';
                
                // Restore scrollbar on body
                document.body.style.overflow = '';
            }
        }
        
        // Button click handler
        fullscreenBtn.addEventListener('click', function(e) {
            e.preventDefault();
            toggleFullscreen();
        });
        
        // ESC key to exit fullscreen
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && isFullscreen) {
                toggleFullscreen();
            }
        });
    },

    /**
     * Generate slug from text
     */
    generateSlug: function(text) {
        return text
            .toString()
            .toLowerCase()
            .trim()
            .replace(/\s+/g, '-')
            .replace(/[^\w\-]+/g, '')
            .replace(/\-\-+/g, '-')
            .replace(/^-+/, '')
            .replace(/-+$/, '');
    },

    /**
     * Initialize Slug Field (auto-generate from title, but editable)
     */
    initSlugField: function(titleId, slugId) {
        const $title = $('#' + titleId);
        const $slug = $('#' + slugId);
        let isSlugManuallyEdited = false;

        if ($title.length === 0 || $slug.length === 0) return;

        // Auto-generate slug from title
        $title.on('input', function() {
            if (!isSlugManuallyEdited) {
                $slug.val(DKApps.generateSlug($(this).val()));
            }
        });

        // Mark as manually edited when user types in slug field
        $slug.on('input', function() {
            isSlugManuallyEdited = true;
        });

        // Reset flag when slug is cleared
        $slug.on('focus', function() {
            if (!$(this).val()) {
                isSlugManuallyEdited = false;
            }
        });
    },

    /**
     * Format file size to human readable
     */
    formatFileSize: function(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    },

    /**
     * Initialize Image Preview
     */
    initImagePreview: function(inputId, previewId, removeButtonId) {
        const $input = $('#' + inputId);
        const $preview = $('#' + previewId);
        const $removeBtn = $('#' + removeButtonId);

        if ($input.length === 0) return;

        // Find existing image container in edit mode
        const $existingImage = $input.closest('.card-body').find('.mb-3.text-center').first();

        // Handle file selection
        $input.on('change', function(e) {
            const file = e.target.files[0];
            
            if (file) {
                // Validate file type
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                if (!validTypes.includes(file.type)) {
                    alert('Format file tidak valid. Gunakan JPG, PNG, atau GIF.');
                    $(this).val('');
                    return;
                }

                // Validate file size (2MB)
                const maxSize = 2 * 1024 * 1024; // 2MB in bytes
                if (file.size > maxSize) {
                    alert('Ukuran file terlalu besar. Maksimal 2 MB.');
                    $(this).val('');
                    return;
                }

                // Hide existing image if in edit mode
                if ($existingImage.length > 0) {
                    $existingImage.hide();
                }

                // Reset delete flag when new image is uploaded
                const $deleteFlag = $('#deleteImageFlag');
                if ($deleteFlag.length > 0) {
                    $deleteFlag.val('0');
                }

                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    $preview.attr('src', e.target.result).addClass('show');
                    $removeBtn.addClass('show');
                };
                reader.readAsDataURL(file);
            }
        });

        // Handle remove button
        $removeBtn.on('click', function() {
            $input.val('');
            $preview.attr('src', '').removeClass('show');
            $(this).removeClass('show');
            // Show existing image again if in edit mode
            if ($existingImage.length > 0) {
                $existingImage.show();
            }
        });
    },

    /**
     * Initialize File Preview
     */
    initFilePreview: function(inputId, infoId, fileNameId, fileSizeId, removeButtonId) {
        const $input = $('#' + inputId);
        const $info = $('#' + infoId);
        const $fileName = $('#' + fileNameId);
        const $fileSize = $('#' + fileSizeId);
        const $removeBtn = $('#' + removeButtonId);

        if ($input.length === 0) return;

        // Find existing file link in edit mode
        const $existingFile = $input.closest('.card-body').find('.mb-3').first();

        // Handle file selection
        $input.on('change', function(e) {
            const file = e.target.files[0];
            
            if (file) {
                // Validate file type
                const validTypes = [
                    'application/pdf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
                ];
                const validExtensions = ['.pdf', '.doc', '.docx'];
                const fileExtension = '.' + file.name.split('.').pop().toLowerCase();
                
                if (!validTypes.includes(file.type) && !validExtensions.includes(fileExtension)) {
                    alert('Format file tidak valid. Gunakan PDF, DOC, atau DOCX.');
                    $(this).val('');
                    return;
                }

                // Validate file size (5MB)
                const maxSize = 5 * 1024 * 1024; // 5MB in bytes
                if (file.size > maxSize) {
                    alert('Ukuran file terlalu besar. Maksimal 5 MB.');
                    $(this).val('');
                    return;
                }

                // Hide existing file link if in edit mode
                if ($existingFile.length > 0 && $existingFile.find('a.btn').length > 0) {
                    $existingFile.hide();
                }

                // Reset delete flag when new file is uploaded
                const $deleteFlag = $('#deleteFileFlag');
                if ($deleteFlag.length > 0) {
                    $deleteFlag.val('0');
                }

                // Show file info
                $fileName.text(file.name);
                $fileSize.text(DKApps.formatFileSize(file.size));
                $info.addClass('show');
            }
        });

        // Handle remove button
        $removeBtn.on('click', function() {
            $input.val('');
            $fileName.text('');
            $fileSize.text('');
            $info.removeClass('show');
            // Show existing file link again if in edit mode
            if ($existingFile.length > 0 && $existingFile.find('a.btn').length > 0) {
                $existingFile.show();
            }
        });
    },

    /**
     * Initialize Delete Existing Image Handler
     */
    initDeleteExistingImage: function() {
        const $deleteBtn = $('#deleteExistingImage');
        if ($deleteBtn.length === 0) return;
        
        $deleteBtn.on('click', function() {
            const newsId = $(this).data('news-id');
            
            // Show confirmation using NotifAlert
            NotifAlert.confirm(
                'Hapus Gambar?',
                'Gambar akan dihapus. Anda yakin?',
                'warning',
                'Ya, Hapus!',
                'Batal',
                '#d33'
            ).then((result) => {
                if (result.isConfirmed) {
                    $('#deleteImageFlag').val('1');
                    $('#existingImageContainer').hide();
                    $('#imageInputContainer').show();
                    NotifAlert.success('Gambar akan dihapus saat form disimpan.');
                }
            });
        });
    },

    /**
     * Initialize Delete Existing File Handler
     */
    initDeleteExistingFile: function() {
        const $deleteBtn = $('#deleteExistingFile');
        if ($deleteBtn.length === 0) return;
        
        $deleteBtn.on('click', function() {
            const newsId = $(this).data('news-id');
            
            NotifAlert.confirm(
                'Hapus File?',
                'File lampiran akan dihapus. Anda yakin?',
                'warning',
                'Ya, Hapus!',
                'Batal',
                '#d33'
            ).then((result) => {
                if (result.isConfirmed) {
                    $('#deleteFileFlag').val('1');
                    $('#existingFileContainer').hide();
                    $('#fileInputContainer').show();
                    NotifAlert.success('File akan dihapus saat form disimpan.');
                }
            });
        });
    }
};


/**
 * Auto-initialize CKEditor on elements with data-ckeditor attribute
 * Similar to Choices.js auto-init
 */
(function() {
    'use strict';
    
    // Auto-initialize CKEditor when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        // Find all elements with data-ckeditor attribute
        const ckeditorElements = document.querySelectorAll('[data-ckeditor]');
        
        if (ckeditorElements.length === 0) return;
        
        // Initialize each CKEditor element
        ckeditorElements.forEach(function(element) {
            const elementId = element.id;
            if (!elementId) {
                console.warn('CKEditor element must have an ID attribute');
                return;
            }
            
            // Get configuration from data attributes
            const uploadUrl = element.getAttribute('data-ckeditor-upload-url') || '/admin/news/upload-image';
            const initialContent = element.getAttribute('data-ckeditor-content') || '';
            
            // Initialize CKEditor using DKApps
            DKApps.initCKEditor(elementId, initialContent, uploadUrl)
                .then(function(editor) {
                    console.log('CKEditor auto-initialized for #' + elementId);
                    
                    // Store editor instance globally with element ID
                    if (!window.ckeditorInstances) {
                        window.ckeditorInstances = {};
                    }
                    window.ckeditorInstances[elementId] = editor;
                    
                    // Setup form submit handler if form exists
                    const form = element.closest('form');
                    if (form) {
                        form.addEventListener('submit', function(e) {
                            // Find hidden textarea for this editor
                            const textarea = form.querySelector('textarea[name="content"]');
                            if (textarea && window.ckeditorInstances[elementId]) {
                                const content = window.ckeditorInstances[elementId].getData();
                                textarea.value = content;
                            }
                        });
                    }
                })
                .catch(function(error) {
                    console.error('Failed to auto-initialize CKEditor for #' + elementId, error);
                });
        });
    });
})();

/**
 * Add handleFormSubmit to DKApps object
 */
DKApps.handleFormSubmit = function(formId, submitBtnId, options = {}) {
        const form = document.getElementById(formId);
        const submitBtn = document.getElementById(submitBtnId);
        
        if (!form || !submitBtn) return;
        
        const defaultOptions = {
            loadingText: 'Menyimpan...',
            disableInputs: true,
            onSubmit: null,
            onError: null
        };
        
        const config = { ...defaultOptions, ...options };
        
        let isSubmitting = false;
        
        form.addEventListener('submit', function(e) {
            // Prevent double submit
            if (isSubmitting) {
                e.preventDefault();
                return false;
            }
            
            // Call custom onSubmit if provided
            if (config.onSubmit && typeof config.onSubmit === 'function') {
                const result = config.onSubmit(e);
                if (result === false) {
                    e.preventDefault();
                    return false;
                }
            }
            
            // Set submitting state
            isSubmitting = true;
            
            // Get original button content
            const originalContent = submitBtn.innerHTML;
            
            // Disable submit button
            submitBtn.disabled = true;
            
            // Change button to loading state (template style)
            submitBtn.innerHTML = `
                <span class="d-flex align-items-center">
                    <span class="spinner-border flex-shrink-0" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </span>
                    <span class="flex-grow-1 ms-2">
                        ${config.loadingText}
                    </span>
                </span>
            `;
            
            // Disable all form inputs if configured
            if (config.disableInputs) {
                const inputs = form.querySelectorAll('input, select, textarea, button');
                inputs.forEach(input => {
                    if (input.id !== submitBtnId) {
                        input.disabled = true;
                    }
                });
            }
            
            // Re-enable on error (if form validation fails)
            setTimeout(function() {
                // Check if form is still on the page (not redirected)
                if (document.getElementById(formId)) {
                    // Check if there are validation errors
                    const hasErrors = form.querySelector('.is-invalid') || form.querySelector('.invalid-feedback:not([style*="display: none"])');
                    
                    if (hasErrors) {
                        // Reset button
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = originalContent;
                        isSubmitting = false;
                        
                        // Re-enable inputs
                        if (config.disableInputs) {
                            const inputs = form.querySelectorAll('input, select, textarea, button');
                            inputs.forEach(input => {
                                input.disabled = false;
                            });
                        }
                        
                        // Call custom onError if provided
                        if (config.onError && typeof config.onError === 'function') {
                            config.onError();
                        }
                    }
                }
            }, 100);
        });
    };
