<?php
    function add_base_htaccess($rules) {
        $new_rules = <<<rules

<IfModule mod_headers.c>
    Header set X-UA-Compatible "IE=edge"

    <FilesMatch "\.(appcache|atom|bbaw|bmp|crx|css|cur|eot|f4[abpv]|flv|geojson|gif|htc|ico|jpe?g|js|json(ld)?|m4[av]|manifest|map|mp4|oex|og[agv]|opus|otf|pdf|png|rdf|rss|safariextz|svgz?|swf|topojson|tt[cf]|txt|vcard|vcf|vtt|webapp|web[mp]|webmanifest|woff2?|xloc|xml|xpi)$">
        Header unset X-UA-Compatible
    </FilesMatch>
</IfModule>

AddDefaultCharset utf-8

# Stop click jacking
<IfModule mod_headers.c>
    Header set X-Frame-Options "DENY"

    <FilesMatch "\.(appcache|atom|bbaw|bmp|crx|css|cur|eot|f4[abpv]|flv|geojson|gif|htc|ico|jpe?g|js|json(ld)?|m4[av]|manifest|map|mp4|oex|og[agv]|opus|otf|pdf|png|rdf|rss|safariextz|svgz?|swf|topojson|tt[cf]|txt|vcard|vcf|vtt|webapp|web[mp]|webmanifest|woff2?|xloc|xml|xpi)$">
        Header unset X-Frame-Options
    </FilesMatch>
</IfModule>

# Hide folder directories
<IfModule mod_autoindex.c>
    Options -Indexes
</IfModule>

# Hide files starting with .
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_URI} "!(^|/)\.well-known/([^./]+./?)+$" [NC]
    RewriteCond %{SCRIPT_FILENAME} -d [OR]
    RewriteCond %{SCRIPT_FILENAME} -f
    RewriteRule "(^|/)\." - [F]
</IfModule>

# Hide backup files
<FilesMatch "(^#.*#|\.(bak|conf|dist|fla|in[ci]|log|psd|sh|sql|sw[op])|~)$">
    # Apache < 2.3
    <IfModule !mod_authz_core.c>
        Order allow,deny
        Deny from all
        Satisfy All
    </IfModule>

    # Apache ≥ 2.3
    <IfModule mod_authz_core.c>
        Require all denied
    </IfModule>
</FilesMatch>

# Hide server info
<IfModule mod_headers.c>
    Header set X-Content-Type-Options "nosniff"
    Header unset X-Powered-By
</IfModule>
ServerSignature Off

# GZip
<IfModule mod_deflate.c>
    <IfModule mod_setenvif.c>
        <IfModule mod_headers.c>
            SetEnvIfNoCase ^(Accept-EncodXng|X-cept-Encoding|X{15}|~{15}|-{15})$ ^((gzip|deflate)\s*,?\s*)+|[X~-]{4,13}$ HAVE_Accept-Encoding
            RequestHeader append Accept-Encoding "gzip,deflate" env=HAVE_Accept-Encoding
        </IfModule>
    </IfModule>

    <IfModule mod_filter.c>
        AddOutputFilterByType DEFLATE "application/atom+xml" \
                                      "application/javascript" \
                                      "application/json" \
                                      "application/ld+json" \
                                      "application/manifest+json" \
                                      "application/rdf+xml" \
                                      "application/rss+xml" \
                                      "application/schema+json" \
                                      "application/vnd.geo+json" \
                                      "application/vnd.ms-fontobject" \
                                      "application/x-font-ttf" \
                                      "application/x-javascript" \
                                      "application/x-web-app-manifest+json" \
                                      "application/xhtml+xml" \
                                      "application/xml" \
                                      "font/eot" \
                                      "font/opentype" \
                                      "image/bmp" \
                                      "image/svg+xml" \
                                      "image/vnd.microsoft.icon" \
                                      "image/x-icon" \
                                      "text/cache-manifest" \
                                      "text/css" \
                                      "text/html" \
                                      "text/javascript" \
                                      "text/plain" \
                                      "text/vcard" \
                                      "text/vnd.rim.location.xloc" \
                                      "text/vtt" \
                                      "text/x-component" \
                                      "text/x-cross-domain-policy" \
                                      "text/xml"
    </IfModule>

    <IfModule mod_mime.c>
        AddEncoding gzip              svgz
    </IfModule>
</IfModule>

# Caching
<IfModule mod_expires.c>

    ExpiresActive on
    ExpiresDefault                                      "access plus 1 month"

    # CSS
    ExpiresByType text/css                              "access plus 1 year"

    ExpiresByType application/json                      "access plus 0 seconds"
    ExpiresByType application/ld+json                   "access plus 0 seconds"
    ExpiresByType application/schema+json               "access plus 0 seconds"
    ExpiresByType application/vnd.geo+json              "access plus 0 seconds"
    ExpiresByType application/xml                       "access plus 0 seconds"
    ExpiresByType text/xml                              "access plus 0 seconds"

    # HTML
    ExpiresByType text/html                             "access plus 0 seconds"

    # JavaScript
    ExpiresByType application/javascript                "access plus 1 year"
    ExpiresByType application/x-javascript              "access plus 1 year"
    ExpiresByType text/javascript                       "access plus 1 year"

    # Manifest files
    ExpiresByType application/manifest+json             "access plus 1 week"
    ExpiresByType application/x-web-app-manifest+json   "access plus 0 seconds"
    ExpiresByType text/cache-manifest                   "access plus 0 seconds"

    # Media files
    ExpiresByType audio/ogg                             "access plus 1 month"
    ExpiresByType image/bmp                             "access plus 1 month"
    ExpiresByType image/gif                             "access plus 1 month"
    ExpiresByType image/jpeg                            "access plus 1 month"
    ExpiresByType image/png                             "access plus 1 month"
    ExpiresByType image/svg+xml                         "access plus 1 month"
    ExpiresByType image/webp                            "access plus 1 month"
    ExpiresByType video/mp4                             "access plus 1 month"
    ExpiresByType video/ogg                             "access plus 1 month"
    ExpiresByType video/webm                            "access plus 1 month"

    # Web fonts
    ExpiresByType application/vnd.ms-fontobject         "access plus 1 month"
    ExpiresByType font/eot                              "access plus 1 month"
    ExpiresByType font/opentype                         "access plus 1 month"
    ExpiresByType application/x-font-ttf                "access plus 1 month"
    ExpiresByType application/font-woff                 "access plus 1 month"
    ExpiresByType application/x-font-woff               "access plus 1 month"
    ExpiresByType font/woff                             "access plus 1 month"
    ExpiresByType application/font-woff2                "access plus 1 month"

</IfModule>

rules;
        return $rules . $new_rules;
    }
    add_filter('mod_rewrite_rules', 'add_base_htaccess');



    // IP block .htacces
    function add_ip_rules_htaccess($rules) {
        if (!function_exists('get_field')) {
          return;
        }

        $new_rules = '';

        // Are there any IPs
        $ips = get_field('ip', 'site');

        if ($ips && count($ips)) {
            $new_rules = "order deny,allow\n";

            foreach($ips AS $ip) {
                $new_rules .= "allow from {$ip['ip']}  # {$ip['comment']}\n";
            }

            $new_rules .= "deny from all\n";
        }

        return $rules . $new_rules;
    }
    add_filter('mod_rewrite_rules', 'add_ip_rules_htaccess');

    function activate_boilerplate() {
        include __DIR__ . '/roles.php';

        flush_the_htaccess_file();
    }

    function flush_the_htaccess_file() {
        global $wp_rewrite;
        $wp_rewrite->flush_rules();
    }

    // Flush rules on theme install
    add_action('switch_theme', 'activate_boilerplate');

    // Flush rules on options page update
    function acf_save_options() {
        $screen = get_current_screen();
        if (strpos($screen->id, "acf-options-site-settings") == true) {
            global $wp_rewrite;
            flush_the_htaccess_file();
        }
    }
    add_action('acf/save_post', 'acf_save_options', 20);

