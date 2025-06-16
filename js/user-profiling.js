/**
 * AIQEngage User Profiling Script
 * Handles tracking user behavior and preferences for personalization
 */

(function($) {
    'use strict';
    
    // User profile manager
    const ProfileManager = {
        // Default profile structure
        defaultProfile: {
            id: null,
            firstVisit: null,
            lastActive: null,
            visitCount: 1,
            pageViews: [],
            interactions: {
                promptCopies: 0,
                toolClicks: 0,
                blueprintViews: 0,
                contentReadTime: 0
            },
            preferences: {
                contentLength: 'medium',
                categories: {}
            },
            interests: {},
            skillLevel: 5,
            utmSource: null,
            utmMedium: null,
            utmCampaign: null
        },
        
        // Initialize the profile manager
        init: function() {
            this.loadProfile();
            this.trackUtmParameters();
            this.setupEventTracking();
            this.syncWithServer();
            
            // Update last active timestamp
            this.updateProfile({ lastActive: new Date().toISOString() });
            
            // Increment visit count if this is a new session
            const lastVisit = new Date(this.profile.lastActive || 0);
            const now = new Date();
            if ((now - lastVisit) > (30 * 60 * 1000)) { // 30 minutes session timeout
                this.profile.visitCount++;
                this.saveProfile();
            }
            
            // Set returning visitor cookie
            if (this.profile.visitCount > 1) {
                this.setCookie('aiqengage_returning_visitor', '1', 365);
            }
        },
        
        // Load user profile from localStorage
        loadProfile: function() {
            let storedProfile = localStorage.getItem('aiqengage_user_profile');
            
            if (storedProfile) {
                try {
                    this.profile = JSON.parse(storedProfile);
                } catch (e) {
                    console.error('Error parsing user profile:', e);
                    this.profile = this.createNewProfile();
                }
            } else {
                this.profile = this.createNewProfile();
            }
            
            // Ensure all required fields are present
            this.profile = {...this.defaultProfile, ...this.profile};
        },
        
        // Create a new user profile
        createNewProfile: function() {
            const newProfile = {...this.defaultProfile};
            newProfile.id = this.generateUniqueId();
            newProfile.firstVisit = new Date().toISOString();
            newProfile.lastActive = new Date().toISOString();
            
            return newProfile;
        },
        
        // Generate a unique ID for the user
        generateUniqueId: function() {
            return 'uid_' + Math.random().toString(36).substring(2, 15) + 
                   Math.random().toString(36).substring(2, 15);
        },
        
        // Save profile to localStorage
        saveProfile: function() {
            localStorage.setItem('aiqengage_user_profile', JSON.stringify(this.profile));
        },
        
        // Update profile with new data
        updateProfile: function(data) {
            this.profile = {...this.profile, ...data};
            
            // If updating nested objects, handle them specially
            if (data.interactions) {
                this.profile.interactions = {...this.profile.interactions, ...data.interactions};
            }
            
            if (data.preferences) {
                this.profile.preferences = {...this.profile.preferences, ...data.preferences};
            }
            
            if (data.interests) {
                this.profile.interests = {...this.profile.interests, ...data.interests};
            }
            
            this.saveProfile();
        },
        
        // Track UTM parameters from URL
        trackUtmParameters: function() {
            const urlParams = new URLSearchParams(window.location.search);
            
            if (urlParams.has('utm_source')) {
                this.profile.utmSource = urlParams.get('utm_source');
            }
            
            if (urlParams.has('utm_medium')) {
                this.profile.utmMedium = urlParams.get('utm_medium');
            }
            
            if (urlParams.has('utm_campaign')) {
                this.profile.utmCampaign = urlParams.get('utm_campaign');
            }
            
            this.saveProfile();
        },
        
        // Setup event tracking
        setupEventTracking: function() {
            // Track prompt copy events
            $(document).on('click', '.prompt-card .copy-button', () => {
                this.trackInteraction('promptCopies');
            });
            
            // Track tool clicks
            $(document).on('click', '.tool-link, [data-track="tool"]', () => {
                this.trackInteraction('toolClicks');
            });
            
            // Track blueprint views
            $(document).on('click', '.blueprint-details, [data-track="blueprint"]', () => {
                this.trackInteraction('blueprintViews');
            });
            
            // Track read time for content
            if ($('article.post').length) {
                this.trackReadTime();
            }
            
            // Track category interests
            this.trackCategoryInterest();
        },
        
        // Track specific interaction
        trackInteraction: function(interactionType, amount = 1) {
            if (this.profile.interactions[interactionType] !== undefined) {
                this.profile.interactions[interactionType] += amount;
                
                // Update skill level based on interactions
                this.updateSkillLevel();
                
                this.saveProfile();
            }
        },
        
        // Track content read time
        trackReadTime: function() {
            let readTimeTracker = {
                startTime: new Date(),
                isTracking: true,
                totalSeconds: 0
            };
            
            // Check if user is actively reading every 5 seconds
            const readInterval = setInterval(() => {
                if (!readTimeTracker.isTracking) {
                    return;
                }
                
                readTimeTracker.totalSeconds += 5;
                
                // After 30 seconds of reading, update profile
                if (readTimeTracker.totalSeconds % 30 === 0) {
                    this.trackInteraction('contentReadTime', 30);
                    
                    // Update content length preference based on read time
                    if (readTimeTracker.totalSeconds > 300) { // 5+ minutes
                        this.updateProfile({
                            preferences: {
                                contentLength: 'detailed'
                            }
                        });
                    } else if (readTimeTracker.totalSeconds > 60) { // 1-5 minutes
                        this.updateProfile({
                            preferences: {
                                contentLength: 'medium'
                            }
                        });
                    } else { // < 1 minute
                        this.updateProfile({
                            preferences: {
                                contentLength: 'short'
                            }
                        });
                    }
                }
            }, 5000);
            
            // Stop tracking when user leaves the page
            $(window).on('beforeunload', () => {
                readTimeTracker.isTracking = false;
                clearInterval(readInterval);
            });
        },
        
        // Track category interest based on current page
        trackCategoryInterest: function() {
            // Get current category from body classes or URL
            let currentCategory = '';
            
            // Check URL path first
            const pathParts = window.location.pathname.split('/').filter(Boolean);
            if (pathParts.length > 0 && aiqengageProfile.categories.includes(pathParts[0])) {
                currentCategory = pathParts[0];
            }
            
            // If no category found in URL, check body classes
            if (!currentCategory) {
                $('body').attr('class').split(' ').forEach(className => {
                    if (className.startsWith('category-')) {
                        currentCategory = className.replace('category-', '');
                    }
                });
            }
            
            if (currentCategory) {
                const interests = this.profile.interests;
                
                if (!interests[currentCategory]) {
                    interests[currentCategory] = 1;
                } else {
                    interests[currentCategory]++;
                }
                
                this.updateProfile({ interests });
            }
        },
        
        // Update skill level based on interactions
        updateSkillLevel: function() {
            const interactions = this.profile.interactions;
            
            // Calculate skill level based on weighted interactions
            // Formula: Base level (1) + weighted sum of interactions (max 9)
            const skillLevel = 1 + Math.min(9, Math.floor(
                (interactions.promptCopies * 0.5) +
                (interactions.toolClicks * 0.3) +
                (interactions.blueprintViews * 0.7) +
                (interactions.contentReadTime / 120) // Every 2 minutes of reading adds 0.1
            ));
            
            this.updateProfile({ skillLevel });
        },
        
        // Sync profile with server for logged-in users
        syncWithServer: function() {
            if (!aiqengageProfile.isLoggedIn) {
                return;
            }
            
            $.ajax({
                url: aiqengageProfile.ajaxurl,
                type: 'POST',
                data: {
                    action: 'aiqengage_update_profile',
                    security: aiqengageProfile.nonce,
                    profile_data: JSON.stringify(this.profile)
                },
                success: function(response) {
                    if (response.success) {
                        console.log('Profile synced with server');
                    }
                }
            });
        },
        
        // Helper function to set a cookie
        setCookie: function(name, value, days) {
            let expires = '';
            
            if (days) {
                const date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = '; expires=' + date.toUTCString();
            }
            
            document.cookie = name + '=' + value + expires + '; path=/';
        }
    };
    
    // Initialize profile manager when document is ready
    $(document).ready(function() {
        ProfileManager.init();
        
        // Apply personalization based on profile
        applyPersonalization();
    });
    
    // Apply personalization to the page based on user profile
    function applyPersonalization() {
        // Add skill level as body class
        const skillLevel = ProfileManager.profile.skillLevel;
        $('body').addClass('skill-level-' + skillLevel);
        
        // Add data attributes for skill level targeting
        $('body').attr('data-skill-level', skillLevel);
        
        // Apply content preferences
        const contentLength = ProfileManager.profile.preferences.contentLength;
        $('body').addClass('prefers-' + contentLength);
        
        // Check if returning visitor
        if (ProfileManager.profile.visitCount > 1) {
            $('body').addClass('returning-visitor');
            
            // Hide first-time visitor elements
            $('.first-time-only').hide();
        } else {
            $('body').addClass('first-time-visitor');
            
            // Hide returning visitor elements
            $('.returning-only').hide();
        }
        
        // Personalize content based on interests
        const interests = ProfileManager.profile.interests;
        const topInterests = Object.entries(interests)
            .sort((a, b) => b[1] - a[1])
            .slice(0, 3)
            .map(entry => entry[0]);
        
        // Add interest-based classes
        topInterests.forEach(interest => {
            $('body').addClass('interest-' + interest);
        });
        
        // Hide or show elements based on skill level
        if (skillLevel < 4) { // Beginner
            $('.advanced-only').hide();
            $('.beginner-friendly').show();
        } else if (skillLevel > 7) { // Advanced
            $('.beginner-only').hide();
            $('.advanced-content').show();
        }
    }
    
})(jQuery);
