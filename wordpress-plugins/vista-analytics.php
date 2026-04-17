<?php
/**
 * Plugin Name: Vista Del Mar Analytics
 * Description: GA4 tracking and conversion monitoring for Vista Del Mar website
 * Version: 1.0
 * Author: Mara
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class Vista_Del_Mar_Analytics {
    
    private $ga4_measurement_id = 'G-NTYP4DYYDJ'; // Vista Del Mar GA4 Property
    
    public function __construct() {
        add_action('wp_head', array($this, 'add_ga4_tracking'));
        add_action('wp_footer', array($this, 'add_conversion_tracking'));
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'register_settings'));
    }
    
    /**
     * Add GA4 tracking code to head
     */
    public function add_ga4_tracking() {
        $measurement_id = get_option('vdm_ga4_id', $this->ga4_measurement_id);
        if ($measurement_id === 'G-PLACEHOLDER' || empty($measurement_id)) {
            return;
        }
        ?>
<!-- Google Analytics 4 - Vista Del Mar -->
<script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr($measurement_id); ?>"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag(){dataLayer.push(arguments);}
    gtag('js', new Date());
    gtag('config', '<?php echo esc_js($measurement_id); ?>', {
        'page_title': document.title,
        'page_location': window.location.href,
        'custom_map': {
            'dimension1': 'page_type',
            'dimension2': 'user_type'
        }
    });
    
    // Vista Del Mar custom tracking
    window.vdmTrack = function(event, params) {
        gtag('event', event, params);
    };
</script>
        <?php
    }
    
    /**
     * Add conversion tracking to footer
     */
    public function add_conversion_tracking() {
        ?>
<script>
// Track booking button clicks
document.addEventListener('DOMContentLoaded', function() {
    
    // Track Book Now buttons
    var bookButtons = document.querySelectorAll('a[href*="book"], a[href*="vrbo"], .book-now, [class*="book"]');
    bookButtons.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var href = this.getAttribute('href') || '';
            var label = 'book_now';
            if (href.includes('vrbo')) label = 'vrbo_redirect';
            if (href.includes('oursearanchhome')) label = 'direct_booking';
            
            vdmTrack('conversion', {
                event_category: 'booking',
                event_label: label,
                value: 1
            });
        });
    });
    
    // Track phone clicks (mobile)
    var phoneLinks = document.querySelectorAll('a[href^="tel:"]');
    phoneLinks.forEach(function(link) {
        link.addEventListener('click', function() {
            vdmTrack('contact', {
                event_category: 'conversion',
                event_label: 'phone_call',
                value: 1
            });
        });
    });
    
    // Track email clicks
    var emailLinks = document.querySelectorAll('a[href^="mailto:"]');
    emailLinks.forEach(function(link) {
        link.addEventListener('click', function() {
            vdmTrack('contact', {
                event_category: 'conversion',
                event_label: 'email_click',
                value: 1
            });
        });
    });
    
    // Track bot widget opens (if present)
    var botWidget = document.getElementById('ask-the-owners-widget');
    if (botWidget) {
        botWidget.addEventListener('click', function() {
            vdmTrack('bot_interaction', {
                event_category: 'chatbot',
                event_label: 'widget_opened'
            });
        });
    }
    
    // Track scroll depth (25%, 50%, 75%, 90%)
    var scrollMarks = {};
    window.addEventListener('scroll', function() {
        var scrollPercent = (window.scrollY / (document.body.scrollHeight - window.innerHeight)) * 100;
        
        [25, 50, 75, 90].forEach(function(mark) {
            if (scrollPercent > mark && !scrollMarks[mark]) {
                scrollMarks[mark] = true;
                vdmTrack('scroll', {
                    event_category: 'engagement',
                    event_label: 'scroll_' + mark + '_percent'
                });
            }
        });
    });
    
    // Track time on page (30s, 60s, 120s, 300s)
    var timeMarks = {};
    [30, 60, 120, 300].forEach(function(seconds) {
        setTimeout(function() {
            if (!timeMarks[seconds]) {
                timeMarks[seconds] = true;
                vdmTrack('time_on_page', {
                    event_category: 'engagement',
                    event_label: seconds + '_seconds'
                });
            }
        }, seconds * 1000);
    });
    
});
</script>
        <?php
    }
    
    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_options_page(
            'Vista Del Mar Analytics',
            'VDM Analytics',
            'manage_options',
            'vdm-analytics',
            array($this, 'admin_page')
        );
    }
    
    /**
     * Register settings
     */
    public function register_settings() {
        register_setting('vdm_analytics', 'vdm_ga4_id');
    }
    
    /**
     * Admin page
     */
    public function admin_page() {
        ?>
        <div class="wrap">
            <h1>Vista Del Mar Analytics</h1>
            
            <form method="post" action="options.php">
                <?php settings_fields('vdm_analytics'); ?>
                
                <table class="form-table">
                    <tr>
                        <th scope="row">GA4 Measurement ID</th>
                        <td>
                            <input type="text" name="vdm_ga4_id" 
                                   value="<?php echo esc_attr(get_option('vdm_ga4_id')); ?>" 
                                   class="regular-text" 
                                   placeholder="G-XXXXXXXXXX">
                            <p class="description">
                                Get this from <a href="https://analytics.google.com" target="_blank">Google Analytics</a> 
                                → Admin → Data Streams → Web Stream
                            </p>
                        </td>
                    </tr>
                </table>
                
                <?php submit_button('Save Settings'); ?>
            </form>
            
            <hr>
            
            <h2>Quick Links</h2>
            <ul>
                <li><a href="https://analytics.google.com" target="_blank">Google Analytics Dashboard</a></li>
                <li><a href="https://search.google.com/search-console" target="_blank">Google Search Console</a></li>
                <li><a href="https://lookerstudio.google.com" target="_blank">Looker Studio (Dashboard)</a></li>
            </ul>
            
            <h2>Tracked Events</h2>
            <table class="widefat">
                <thead>
                    <tr>
                        <th>Event</th>
                        <th>Description</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><code>conversion</code></td>
                        <td>Book Now button, VRBO redirect, direct booking clicks</td>
                    </tr>
                    <tr>
                        <td><code>contact</code></td>
                        <td>Phone calls, email clicks</td>
                    </tr>
                    <tr>
                        <td><code>bot_interaction</code></td>
                        <td>Chatbot widget opened</td>
                    </tr>
                    <tr>
                        <td><code>scroll</code></td>
                        <td>25%, 50%, 75%, 90% scroll depth</td>
                    </tr>
                    <tr>
                        <td><code>time_on_page</code></td>
                        <td>30s, 60s, 120s, 300s engagement</td>
                    </tr>
                </tbody>
            </table>
            
            <h2>Setup Checklist</h2>
            <ol>
                <li>☐ Create GA4 property at <a href="https://analytics.google.com">analytics.google.com</a></li>
                <li>☐ Copy Measurement ID (G-XXXXXXXXXX)</li>
                <li>☐ Paste ID above and Save</li>
                <li>☐ Verify Search Console at <a href="https://search.google.com/search-console">search.google.com</a></li>
                <li>☐ Build Looker Studio dashboard</li>
                <li>☐ Test events in GA4 Real-Time report</li>
            </ol>
        </div>
        <?php
    }
}

// Initialize
new Vista_Del_Mar_Analytics();

/**
 * Helper function for template tracking
 */
function vdm_track_event($event, $params = array()) {
    ?>
    <script>
    if (typeof vdmTrack === 'function') {
        vdmTrack('<?php echo esc_js($event); ?>', <?php echo json_encode($params); ?>);
    }
    </script>
    <?php
}
