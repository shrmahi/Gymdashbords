/**
 * URL Management Functions
 * Clean and manage URLs across all pages
 */

// Function to remove all query parameters from URL
function cleanURL() {
    const cleanPath = window.location.pathname;
    window.history.replaceState(null, '', cleanPath);
}

// Function to remove specific query parameters
function removeQueryParams(...params) {
    const url = new URL(window.location);
    params.forEach(param => url.searchParams.delete(param));
    window.history.replaceState(null, '', url.toString());
}

// Function to remove query parameters and keep only specific ones
function keepOnlyParams(...params) {
    const url = new URL(window.location);
    const newParams = new URLSearchParams();
    
    params.forEach(param => {
        if (url.searchParams.has(param)) {
            newParams.set(param, url.searchParams.get(param));
        }
    });
    
    const newUrl = window.location.pathname + (newParams.toString() ? '?' + newParams.toString() : '');
    window.history.replaceState(null, '', newUrl);
}

// Function to clean URL after successful action
function cleanURLAfterAction(delay = 1000) {
    setTimeout(() => {
        cleanURL();
    }, delay);
}

// Function to remove action and redirect ID from URL
function removeActionParams() {
    removeQueryParams('action', 'rid', 'id', 'uid', 'bid', 'pid');
}

// Auto-clean URL on page load (optional)
function autoCleanURL() {
    const excludePages = []; // Add pages where you don't want auto-clean
    const currentPage = window.location.pathname.split('/').pop();
    
    if (!excludePages.includes(currentPage)) {
        // Uncomment to enable auto-clean:
        // cleanURL();
    }
}

// Clean URL after AJAX requests
function cleanURLAfterAjax(response) {
    if (response && response.success) {
        cleanURL();
        return true;
    }
    return false;
}

// Remove query params after form submission
document.addEventListener('DOMContentLoaded', function() {
    // Listen for successful alerts/messages
    const alertElement = document.querySelector('.alert-success, .alert-info');
    if (alertElement) {
        setTimeout(() => {
            removeActionParams();
        }, 2000);
    }
});

// Export functions for module systems if needed
if (typeof module !== 'undefined' && module.exports) {
    module.exports = {
        cleanURL,
        removeQueryParams,
        keepOnlyParams,
        cleanURLAfterAction,
        removeActionParams,
        autoCleanURL,
        cleanURLAfterAjax
    };
}
