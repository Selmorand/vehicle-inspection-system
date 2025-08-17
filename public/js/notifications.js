/**
 * Modern Notification System for Vehicle Inspection
 * Replaces basic alert() with styled toast notifications
 */

const VehicleNotifications = (function() {
    'use strict';

    // Notification container
    let container = null;

    // Default options
    const defaults = {
        duration: 4000,
        position: 'top-right',
        showProgress: true,
        closable: true,
        maxNotifications: 5
    };

    // Notification types with colors matching the inspection system
    const types = {
        success: {
            color: '#28a745',
            icon: 'bi-check-circle-fill',
            title: 'Success'
        },
        error: {
            color: '#dc3545',
            icon: 'bi-exclamation-triangle-fill',
            title: 'Error'
        },
        warning: {
            color: '#ffc107',
            icon: 'bi-exclamation-circle-fill',
            title: 'Warning',
            textColor: '#212529'
        },
        info: {
            color: '#4f959b',
            icon: 'bi-info-circle-fill',
            title: 'Info'
        },
        draft: {
            color: '#ffc107',
            icon: 'bi-file-earmark-check-fill',
            title: 'Draft Saved',
            textColor: '#212529'
        }
    };

    /**
     * Initialize the notification system
     */
    function init() {
        if (!container) {
            createContainer();
        }
    }

    /**
     * Create the notification container
     */
    function createContainer() {
        container = document.createElement('div');
        container.id = 'vehicle-notifications';
        container.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 10000;
            pointer-events: none;
            max-width: 400px;
            width: 100%;
        `;
        document.body.appendChild(container);
    }

    /**
     * Show a notification
     */
    function show(message, type = 'info', options = {}) {
        init();

        const config = { ...defaults, ...options };
        const typeConfig = types[type] || types.info;
        
        // Limit number of notifications
        const existingNotifications = container.children;
        if (existingNotifications.length >= config.maxNotifications) {
            // Remove oldest notification
            existingNotifications[0].remove();
        }

        const notification = createNotification(message, typeConfig, config);
        container.appendChild(notification);

        // Animate in
        requestAnimationFrame(() => {
            notification.style.transform = 'translateX(0)';
            notification.style.opacity = '1';
        });

        // Auto remove
        if (config.duration > 0) {
            setTimeout(() => {
                removeNotification(notification);
            }, config.duration);
        }

        return notification;
    }

    /**
     * Create notification element
     */
    function createNotification(message, typeConfig, config) {
        const notification = document.createElement('div');
        const notificationId = 'notification-' + Date.now() + Math.random().toString(36).substr(2, 9);
        
        notification.id = notificationId;
        notification.style.cssText = `
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            margin-bottom: 12px;
            overflow: hidden;
            transform: translateX(100%);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            pointer-events: auto;
            border-left: 4px solid ${typeConfig.color};
            max-width: 400px;
            position: relative;
        `;

        const progressBar = config.showProgress && config.duration > 0 ? `
            <div class="notification-progress" style="
                position: absolute;
                bottom: 0;
                left: 0;
                height: 3px;
                background: ${typeConfig.color};
                width: 100%;
                transform-origin: left;
                animation: notificationProgress ${config.duration}ms linear forwards;
            "></div>
        ` : '';

        notification.innerHTML = `
            <div style="
                padding: 16px 20px;
                display: flex;
                align-items: flex-start;
                gap: 12px;
                position: relative;
            ">
                <div style="
                    flex-shrink: 0;
                    width: 24px;
                    height: 24px;
                    border-radius: 50%;
                    background: ${typeConfig.color};
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: ${typeConfig.textColor || 'white'};
                    font-size: 14px;
                ">
                    <i class="bi ${typeConfig.icon}"></i>
                </div>
                <div style="flex: 1; min-width: 0;">
                    <div style="
                        font-weight: 600;
                        font-size: 14px;
                        color: #2b2b2b;
                        margin-bottom: 4px;
                        line-height: 1.2;
                    ">${typeConfig.title}</div>
                    <div style="
                        font-size: 14px;
                        color: #5a5a5a;
                        line-height: 1.4;
                        word-wrap: break-word;
                    ">${message}</div>
                </div>
                ${config.closable ? `
                    <button onclick="VehicleNotifications.remove('${notificationId}')" style="
                        background: none;
                        border: none;
                        color: #999;
                        cursor: pointer;
                        padding: 4px;
                        margin: -4px -4px -4px 8px;
                        border-radius: 4px;
                        flex-shrink: 0;
                        font-size: 16px;
                        line-height: 1;
                        transition: color 0.2s;
                    " onmouseover="this.style.color='#666'" onmouseout="this.style.color='#999'">
                        <i class="bi bi-x"></i>
                    </button>
                ` : ''}
            </div>
            ${progressBar}
        `;

        return notification;
    }

    /**
     * Remove a notification
     */
    function removeNotification(notification) {
        if (!notification || !notification.parentNode) return;

        notification.style.transform = 'translateX(100%)';
        notification.style.opacity = '0';
        
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 300);
    }

    /**
     * Remove notification by ID
     */
    function remove(notificationId) {
        const notification = document.getElementById(notificationId);
        if (notification) {
            removeNotification(notification);
        }
    }

    /**
     * Clear all notifications
     */
    function clear() {
        if (container) {
            while (container.firstChild) {
                removeNotification(container.firstChild);
            }
        }
    }

    /**
     * Convenience methods for different types
     */
    function success(message, options = {}) {
        return show(message, 'success', options);
    }

    function error(message, options = {}) {
        return show(message, 'error', { duration: 6000, ...options });
    }

    function warning(message, options = {}) {
        return show(message, 'warning', options);
    }

    function info(message, options = {}) {
        return show(message, 'info', options);
    }

    function draft(message, options = {}) {
        return show(message, 'draft', options);
    }

    /**
     * Show a confirmation dialog
     */
    function confirm(message, title = 'Confirm Action', options = {}) {
        return new Promise((resolve) => {
            init();

            const config = { ...defaults, duration: 0, closable: false, ...options };
            
            // Create backdrop
            const backdrop = document.createElement('div');
            backdrop.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 10001;
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 20px;
                box-sizing: border-box;
                opacity: 0;
                transition: opacity 0.3s ease;
            `;

            const dialog = document.createElement('div');
            dialog.style.cssText = `
                background: white;
                border-radius: 12px;
                box-shadow: 0 8px 40px rgba(0, 0, 0, 0.2);
                max-width: 400px;
                width: 100%;
                transform: translateY(-20px);
                transition: transform 0.3s ease;
                overflow: hidden;
            `;

            dialog.innerHTML = `
                <div style="
                    padding: 24px;
                    border-bottom: 1px solid #e9ecef;
                ">
                    <div style="
                        display: flex;
                        align-items: center;
                        gap: 12px;
                        margin-bottom: 16px;
                    ">
                        <div style="
                            width: 32px;
                            height: 32px;
                            border-radius: 50%;
                            background: #ffc107;
                            display: flex;
                            align-items: center;
                            justify-content: center;
                            color: #212529;
                            font-size: 16px;
                        ">
                            <i class="bi bi-question-circle-fill"></i>
                        </div>
                        <h4 style="
                            margin: 0;
                            font-size: 18px;
                            font-weight: 600;
                            color: #2b2b2b;
                        ">${title}</h4>
                    </div>
                    <p style="
                        margin: 0;
                        font-size: 14px;
                        color: #5a5a5a;
                        line-height: 1.5;
                    ">${message}</p>
                </div>
                <div style="
                    padding: 16px 24px;
                    display: flex;
                    gap: 12px;
                    justify-content: flex-end;
                    background: #f8f9fa;
                ">
                    <button id="confirm-cancel" style="
                        background: #6c757d;
                        color: white;
                        border: none;
                        border-radius: 6px;
                        padding: 8px 16px;
                        font-size: 14px;
                        font-weight: 500;
                        cursor: pointer;
                        transition: background 0.2s;
                    ">Cancel</button>
                    <button id="confirm-ok" style="
                        background: #4f959b;
                        color: white;
                        border: none;
                        border-radius: 6px;
                        padding: 8px 16px;
                        font-size: 14px;
                        font-weight: 500;
                        cursor: pointer;
                        transition: background 0.2s;
                    ">Confirm</button>
                </div>
            `;

            backdrop.appendChild(dialog);
            document.body.appendChild(backdrop);

            // Animate in
            requestAnimationFrame(() => {
                backdrop.style.opacity = '1';
                dialog.style.transform = 'translateY(0)';
            });

            // Handle buttons
            function cleanup(result) {
                backdrop.style.opacity = '0';
                dialog.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    if (backdrop.parentNode) {
                        backdrop.remove();
                    }
                    resolve(result);
                }, 300);
            }

            dialog.querySelector('#confirm-ok').addEventListener('click', () => cleanup(true));
            dialog.querySelector('#confirm-cancel').addEventListener('click', () => cleanup(false));
            
            // Close on backdrop click
            backdrop.addEventListener('click', (e) => {
                if (e.target === backdrop) {
                    cleanup(false);
                }
            });

            // Close on Escape key
            const handleKeydown = (e) => {
                if (e.key === 'Escape') {
                    document.removeEventListener('keydown', handleKeydown);
                    cleanup(false);
                }
            };
            document.addEventListener('keydown', handleKeydown);
        });
    }

    // Add CSS animation for progress bar
    const style = document.createElement('style');
    style.textContent = `
        @keyframes notificationProgress {
            from { transform: scaleX(1); }
            to { transform: scaleX(0); }
        }
        
        @media (max-width: 768px) {
            #vehicle-notifications {
                top: 10px;
                right: 10px;
                left: 10px;
                max-width: none;
            }
        }
    `;
    document.head.appendChild(style);

    // Public API
    return {
        show,
        success,
        error,
        warning,
        info,
        draft,
        confirm,
        remove,
        clear
    };
})();

// Global shorthand
window.notify = VehicleNotifications;