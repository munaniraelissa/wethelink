/**
 * Authentication Helper
 * Manages API authentication tokens and user session
 */

const AuthHelper = {
    tokenKey: 'auth_token',
    userKey: 'user',

    /**
     * Get stored authentication token
     */
    getToken() {
        return localStorage.getItem(this.tokenKey);
    },

    /**
     * Set authentication token
     */
    setToken(token) {
        localStorage.setItem(this.tokenKey, token);
    },

    /**
     * Get stored user data
     */
    getUser() {
        const user = localStorage.getItem(this.userKey);
        return user ? JSON.parse(user) : null;
    },

    /**
     * Set user data
     */
    setUser(user) {
        localStorage.setItem(this.userKey, JSON.stringify(user));
    },

    /**
     * Check if user is authenticated
     */
    isAuthenticated() {
        return !!this.getToken();
    },

    /**
     * Get authorization headers
     */
    getHeaders() {
        const token = this.getToken();
        return {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            ...(token && { 'Authorization': `Bearer ${token}` }),
        };
    },

    /**
     * Make authenticated API call
     */
    async apiCall(endpoint, options = {}) {
        const defaultOptions = {
            method: 'GET',
            headers: this.getHeaders(),
        };

        const finalOptions = { ...defaultOptions, ...options };
        finalOptions.headers = { ...defaultOptions.headers, ...options.headers };

        try {
            const response = await fetch(endpoint, finalOptions);
            const data = await response.json();

            if (!response.ok) {
                if (response.status === 401) {
                    this.logout();
                    window.location.href = '/login';
                }
                throw new Error(data.message || `API error: ${response.statusText}`);
            }

            return { success: true, data, response };
        } catch (error) {
            return { success: false, error: error.message };
        }
    },

    /**
     * Clear stored authentication data
     */
    logout() {
        localStorage.removeItem(this.tokenKey);
        localStorage.removeItem(this.userKey);
    },

    /**
     * Redirect to login if not authenticated
     */
    requireAuth() {
        if (!this.isAuthenticated()) {
            window.location.href = '/login';
            return false;
        }
        return true;
    },

    /**
     * Redirect to dashboard if already authenticated
     */
    redirectIfAuth() {
        if (this.isAuthenticated()) {
            window.location.href = '/main-dashboard';
        }
    },
};

// Export for use in modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = AuthHelper;
}
