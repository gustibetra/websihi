// Fix asset paths for admin template
(function() {
    // Get base URL from window.assetAdminUrl or construct it
    var baseUrl = window.assetAdminUrl || (window.assetBaseUrl ? window.assetBaseUrl + 'assets/admin' : '/assets/admin');
    
    // Ensure it ends with /
    if (!baseUrl.endsWith('/')) {
        baseUrl += '/';
    }
    
    // Set global variables for plugins.js to use
    window.__assetBasePath = baseUrl;
    if (!window.assetAdminUrl) {
        window.assetAdminUrl = baseUrl;
    }
    
    // Override XMLHttpRequest for language files
    var originalOpen = XMLHttpRequest.prototype.open;
    XMLHttpRequest.prototype.open = function(method, url, async, user, password) {
        if (url && url.startsWith('assets/')) {
            url = baseUrl + '/' + url.replace('assets/', '');
        }
        return originalOpen.call(this, method, url, async, user, password);
    };
    
    // Fix image src attributes
    function fixImagePaths() {
        var images = document.querySelectorAll('img[src*="assets/"]');
        images.forEach(function(img) {
            if (img.src && img.src.indexOf('assets/') !== -1 && !img.src.startsWith(baseUrl)) {
                var relativePath = img.src.substring(img.src.indexOf('assets/'));
                img.src = baseUrl + '/' + relativePath;
            }
        });
    }
    
    // Fix dynamically created elements and attribute changes
    var observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            // Handle attribute changes (like img.src)
            if (mutation.type === 'attributes' && mutation.attributeName === 'src') {
                var img = mutation.target;
                if (img.tagName === 'IMG' && img.src && img.src.indexOf('assets/') !== -1 && !img.src.startsWith(baseUrl)) {
                    var relativePath = img.src.substring(img.src.indexOf('assets/'));
                    img.src = baseUrl + '/' + relativePath;
                }
            }
            
            // Handle newly added nodes
            if (mutation.addedNodes.length) {
                mutation.addedNodes.forEach(function(node) {
                    if (node.nodeType === 1) { // Element node
                        // Fix img src
                        var imgs = node.querySelectorAll ? node.querySelectorAll('img[src*="assets/"]') : [];
                        imgs.forEach(function(img) {
                            if (img.src && img.src.indexOf('assets/') !== -1 && !img.src.startsWith(baseUrl)) {
                                var relativePath = img.src.substring(img.src.indexOf('assets/'));
                                img.src = baseUrl + '/' + relativePath;
                            }
                        });
                        
                        // Fix if it's an img element itself
                        if (node.tagName === 'IMG' && node.src && node.src.indexOf('assets/') !== -1 && !node.src.startsWith(baseUrl)) {
                            var relativePath = node.src.substring(node.src.indexOf('assets/'));
                            node.src = baseUrl + '/' + relativePath;
                        }
                    }
                });
            }
        });
    });
    
    // Start observing when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            fixImagePaths();
            observer.observe(document.body, {
                childList: true,
                subtree: true,
                attributes: true,
                attributeFilter: ['src']
            });
        });
    } else {
        fixImagePaths();
        observer.observe(document.body, {
            childList: true,
            subtree: true,
            attributes: true,
            attributeFilter: ['src']
        });
    }
    
    // Store base URL globally for use in other scripts
    window.__assetBasePath = baseUrl;
})();
