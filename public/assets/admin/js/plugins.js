(function() {
    var assetBasePath = window.__assetBasePath || window.assetAdminUrl || window.assetBaseUrl + 'assets/admin';
    if (!assetBasePath.endsWith('/')) assetBasePath += '/';
    
    // Auto-load Choices.js, Flatpickr, Toastify
    (document.querySelectorAll("[toast-list]")||document.querySelectorAll("[data-choices]")||document.querySelectorAll("[data-provider]"))&&(document.writeln("<script type='text/javascript' src='https://cdn.jsdelivr.net/npm/toastify-js'><\/script>"),document.writeln("<script type='text/javascript' src='" + assetBasePath + "libs/choices.js/public/assets/scripts/choices.min.js'><\/script>"),document.writeln("<script type='text/javascript' src='" + assetBasePath + "libs/flatpickr/flatpickr.min.js'><\/script>"));
    
    // Auto-load CKEditor if data-ckeditor exists
    document.querySelectorAll("[data-ckeditor]").length > 0 && document.writeln("<script type='text/javascript' src='" + assetBasePath + "libs/ckeditor5/build/ckeditor.js'><\/script>");
})();