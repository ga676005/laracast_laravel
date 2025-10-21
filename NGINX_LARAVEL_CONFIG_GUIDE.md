# Nginx Configuration Guide for Laravel Application

## Overview
This document explains the nginx configuration file `laravel_nginx.conf` and how it serves your Laravel application. Nginx is a web server that handles HTTP requests and can also act as a reverse proxy.

## Configuration Breakdown

### 1. HTTP to HTTPS Redirect (Lines 1-5)
```nginx
server {
    listen  80;
    server_name laracastlaravel.test;
    return 301 https://laracastlaravel.test$request_uri;
}
```

**What it does:**
- Listens on port 80 (standard HTTP port)
- Catches all requests to `laracastlaravel.test`
- Redirects them to HTTPS (port 443) with a 301 permanent redirect
- `$request_uri` preserves the original URL path and query parameters

**Why:** Forces secure connections for better security.

### 2. Main HTTPS Server Block (Lines 6-71)

#### Basic Server Configuration (Lines 6-16)
```nginx
server {
    listen 443 ssl;
    http2 on;
    server_name laracastlaravel.test;
    root "/etc/nginx/code/laracast_laravel/public";
    index index.html index.htm index.php;
```

**What it does:**
- `listen 443 ssl`: Listens on port 443 with SSL encryption
- `http2 on`: Enables HTTP/2 for better performance
- `server_name`: Matches requests to this domain
- `root`: Sets the document root to Laravel's public directory
- `index`: Defines default files to serve when a directory is requested

#### SSL/TLS Configuration (Lines 15-20)
```nginx
ssl_certificate /etc/nginx/ssl/cert.pem;
ssl_certificate_key /etc/nginx/ssl/key.pem;
ssl_protocols TLSv1 TLSv1.1 TLSv1.2;
ssl_ciphers '...';  # Long list of secure ciphers
ssl_prefer_server_ciphers on;
```

**What it does:**
- Defines SSL certificate and private key locations
- Specifies supported TLS versions (note: TLSv1 and TLSv1.1 are deprecated)
- Lists secure cipher suites for encryption
- Prefers server cipher selection for better security

#### Security Headers (Lines 22-24)
```nginx
add_header X-Frame-Options "SAMEORIGIN";
add_header X-XSS-Protection "1; mode=block";
add_header X-Content-Type-Options "nosniff";
```

**What it does:**
- `X-Frame-Options`: Prevents clickjacking attacks
- `X-XSS-Protection`: Enables browser XSS filtering
- `X-Content-Type-Options`: Prevents MIME type sniffing

### 3. Request Handling

#### Main Location Block (Lines 28-30)
```nginx
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

**How it works:**
1. `$uri` - First tries to serve the exact file requested
2. `$uri/` - If file doesn't exist, tries to serve as directory (looks for index files)
3. `/index.php?$query_string` - If neither works, passes request to Laravel's index.php

**Example:**
- Request: `https://laracastlaravel.test/about`
- Nginx tries: `/public/about` (file)
- Then tries: `/public/about/` (directory with index)
- Finally: `/public/index.php?about` (Laravel handles routing)

#### Static File Handling (Lines 32-33)
```nginx
location = /favicon.ico { access_log off; log_not_found off; }
location = /robots.txt  { access_log off; log_not_found off; }
```

**What it does:**
- Serves favicon.ico and robots.txt directly
- Disables logging for these common requests to reduce log noise

### 4. PHP Processing (Lines 42-66)

This is the most complex part - it handles PHP files:

```nginx
location ~ \.php$ {
    fastcgi_split_path_info ^(.+\.php)(/.+)$;
    try_files $fastcgi_script_name =404;
    set $path_info $fastcgi_path_info;
    fastcgi_param PATH_INFO $path_info;
    fastcgi_index index.php;
    include fastcgi_params;
    fastcgi_pass 127.0.0.1:9250;
    fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    # ... timeout and buffer settings
}
```

**How it works:**
1. `~ \.php$` - Matches any request ending in .php
2. `fastcgi_split_path_info` - Separates script name from path info
3. `try_files $fastcgi_script_name =404` - Ensures PHP file exists
4. `fastcgi_pass 127.0.0.1:9250` - Forwards to PHP-FPM on port 9250
5. `SCRIPT_FILENAME` - Tells PHP-FPM which file to execute

**Example:**
- Request: `https://laracastlaravel.test/api/users/123`
- Nginx: Matches `.php$` pattern
- Splits: script=`/api/users.php`, path_info=`/123`
- Passes to PHP-FPM: Execute `/public/api/users.php` with PATH_INFO=`/123`

### 5. Logging and Performance (Lines 35-40)

```nginx
access_log /var/log/nginx/laracastlaravel.log;
error_log  /var/log/nginx/laracastlaravel-error.log error;
sendfile off;
client_max_body_size 100m;
```

**What it does:**
- Logs all requests and errors to separate files
- `sendfile off`: Disables sendfile for PHP compatibility
- `client_max_body_size`: Allows file uploads up to 100MB

### 6. Security (Lines 68-70)

```nginx
location ~ /\.ht {
    deny all;
}
```

**What it does:**
- Blocks access to `.htaccess` files (Apache configuration files)
- Prevents information disclosure

## How Files Are Served - Complete Flow

### 1. Static Files (CSS, JS, Images)
```
Request: https://laracastlaravel.test/css/app.css
↓
Nginx checks: /public/css/app.css
↓
File exists? → Serve directly
File missing? → 404 error
```

### 2. Laravel Routes
```
Request: https://laracastlaravel.test/dashboard
↓
Nginx checks: /public/dashboard (file)
↓
File exists? No
↓
Nginx checks: /public/dashboard/ (directory)
↓
Directory exists? No
↓
Nginx passes to: /public/index.php?dashboard
↓
Laravel handles routing and returns response
```

### 3. API Requests
```
Request: https://laracastlaravel.test/api/users
↓
Nginx matches: location ~ \.php$
↓
Splits path: script=/api/users.php, path_info=/
↓
Checks file exists: /public/api/users.php
↓
Passes to PHP-FPM: Execute with PATH_INFO=/
↓
Laravel processes API route
```

## Key Concepts for Beginners

### 1. **Server Blocks**
- Each `server {}` block defines how to handle requests for a specific domain
- You can have multiple server blocks for different domains

### 2. **Location Blocks**
- `location /` - Matches all requests
- `location ~ \.php$` - Matches requests ending in .php (regex)
- `location = /favicon.ico` - Exact match for specific file

### 3. **try_files Directive**
- Tries multiple options in order
- Last option is a fallback (usually Laravel's index.php)

### 4. **FastCGI**
- Protocol for communicating with PHP-FPM
- Nginx doesn't execute PHP directly - it passes requests to PHP-FPM
- **Key insight**: `fastcgi_param` directives create `$_SERVER` variables in PHP

### 5. **Document Root**
- `/public` is Laravel's web root
- Contains `index.php` and static assets
- Laravel's application code is outside this directory for security

## Common Issues and Solutions

### 1. **404 Errors for Laravel Routes**
- Check that `try_files` includes the Laravel fallback
- Ensure `index.php` exists in the document root

### 2. **PHP Files Not Executing**
- Verify `fastcgi_pass` points to correct PHP-FPM socket/port
- Check that PHP-FPM is running

### 3. **Static Files Not Loading**
- Verify document root path is correct
- Check file permissions

### 4. **SSL Certificate Issues**
- Ensure certificate files exist and are readable
- Check certificate validity and domain matching

## Testing Your Configuration

1. **Test nginx config:**
   ```bash
   sudo nginx -t
   ```

2. **Reload nginx:**
   ```bash
   sudo systemctl reload nginx
   ```

3. **Check logs:**
   ```bash
   tail -f /var/log/nginx/laracastlaravel-error.log
   ```

## Comparison with Official Laravel Nginx Config

Here's a comparison between your current configuration and the official Laravel nginx example:

### Key Differences

| Feature | Your Config | Official Config | Impact |
|---------|-------------|-----------------|---------|
| **HTTPS/SSL** | ✅ Full HTTPS setup with SSL certificates | ❌ HTTP only | Your config is more secure |
| **IPv6 Support** | ❌ IPv4 only | ✅ Both IPv4 and IPv6 | Official config is more modern |
| **PHP Processing** | All `.php` files | Only `/index.php` routes | Your config processes all PHP files |
| **FastCGI Connection** | TCP socket (127.0.0.1:9250) | Unix socket | Unix sockets are slightly faster |
| **Security Headers** | More comprehensive | Basic | Your config has better security |
| **Error Handling** | Standard nginx | Custom 404 → index.php | Official config handles 404s better |
| **File Access Control** | Blocks `.ht*` files | Blocks hidden files except `.well-known` | Official config is more restrictive |

### Detailed Analysis

#### 1. **HTTPS vs HTTP**
```nginx
# Your config (HTTPS)
server {
    listen 443 ssl;
    # ... SSL configuration
}

# Official config (HTTP only)
server {
    listen 80;
    listen [::]:80;
}
```
**Impact:** Your config is production-ready with SSL, while the official example is development-focused.

#### 2. **PHP Processing Strategy**
```nginx
# Your config - processes ALL .php files
location ~ \.php$ {
    fastcgi_pass 127.0.0.1:9250;
    # ... complex path handling
}

# Official config - only processes /index.php
location ~ ^/index\.php(/|$) {
    fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
    # ... simpler handling
}
```
**Impact:** 
- Your config: Can serve PHP files directly (like `api.php`, `admin.php`)
- Official config: Forces everything through Laravel's router (more secure)

#### 3. **Error Handling**
```nginx
# Your config - standard nginx 404s
# (no custom error handling)

# Official config - Laravel handles 404s
error_page 404 /index.php;
```
**Impact:** Official config ensures Laravel's custom 404 pages are shown.

#### 4. **Security Differences**
```nginx
# Your config
add_header X-Frame-Options "SAMEORIGIN";
add_header X-XSS-Protection "1; mode=block";
add_header X-Content-Type-Options "nosniff";

# Official config
add_header X-Frame-Options "SAMEORIGIN";
add_header X-Content-Type-Options "nosniff";
# Missing X-XSS-Protection
```

#### 5. **File Access Control**
```nginx
# Your config - blocks .htaccess files
location ~ /\.ht {
    deny all;
}

# Official config - blocks all hidden files except .well-known
location ~ /\.(?!well-known).* {
    deny all;
}
```

### Recommendations

#### For Production (Your Current Config is Better):
- ✅ Keep HTTPS/SSL configuration
- ✅ Keep comprehensive security headers
- ✅ Consider adding IPv6 support:
  ```nginx
  listen 80;
  listen [::]:80;
  listen 443 ssl;
  listen [::]:443 ssl;
  ```

#### For Better Laravel Integration:
- Consider switching to the official PHP processing approach:
  ```nginx
  location ~ ^/index\.php(/|$) {
      fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
      fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
      include fastcgi_params;
      fastcgi_hide_header X-Powered-By;
  }
  ```
- Add the 404 error handling:
  ```nginx
  error_page 404 /index.php;
  ```

#### Hybrid Approach (Best of Both):
```nginx
server {
    listen 80;
    listen [::]:80;
    server_name laracastlaravel.test;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl;
    listen [::]:443 ssl;
    http2 on;
    
    server_name laracastlaravel.test;
    root "/etc/nginx/code/laracast_laravel/public";
    
    # SSL configuration (keep your current SSL setup)
    ssl_certificate /etc/nginx/ssl/cert.pem;
    ssl_certificate_key /etc/nginx/ssl/key.pem;
    
    # Security headers (keep your comprehensive headers)
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";
    
    index index.php;
    charset utf-8;
    
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }
    
    error_page 404 /index.php;
    
    # Official Laravel PHP processing
    location ~ ^/index\.php(/|$) {
        fastcgi_pass 127.0.0.1:9250;  # Keep your current FastCGI setup
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
        fastcgi_hide_header X-Powered-By;
    }
    
    # Block hidden files (more restrictive than your current config)
    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## Understanding FastCGI and nginx Variables

### What is FastCGI?

**FastCGI** (Fast Common Gateway Interface) is a protocol that allows nginx to efficiently communicate with PHP-FPM. It solves the performance problem of traditional CGI by keeping PHP processes running and reusing them for multiple requests.

#### The FastCGI Flow:
```
Browser Request → nginx → FastCGI Protocol → PHP-FPM → PHP Process → Laravel → Response
```

#### Why FastCGI is Better:
- **Traditional CGI**: Start PHP process → Execute → Kill process (slow)
- **FastCGI**: Keep PHP processes running → Reuse for multiple requests (fast)

### How nginx Passes Data to PHP

#### The Key: `fastcgi_param` Directives

Each `fastcgi_param` directive creates a `$_SERVER` variable in PHP:

```nginx
fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
fastcgi_param REQUEST_URI $request_uri;
fastcgi_param REQUEST_METHOD $request_method;
```

**Becomes in PHP:**
```php
$_SERVER['SCRIPT_FILENAME'] = "/path/to/index.php";
$_SERVER['REQUEST_URI'] = "/api/users";
$_SERVER['REQUEST_METHOD'] = "GET";
```

#### The Magic of `include fastcgi_params;`

This directive includes a file with standard FastCGI parameters:
```nginx
fastcgi_param QUERY_STRING $query_string;
fastcgi_param REQUEST_METHOD $request_method;
fastcgi_param CONTENT_TYPE $content_type;
fastcgi_param REQUEST_URI $request_uri;
fastcgi_param DOCUMENT_ROOT $document_root;
# ... and many more
```

### nginx Variable Mystery Solved

#### The `$fastcgi_script_name` Variable

**Question**: How does `$fastcgi_script_name` get set without explicit definition?

**Answer**: nginx automatically sets this variable when using regex location matching!

```nginx
location ~ ^/index\.php(/|$) {
    # nginx automatically sets $fastcgi_script_name = "/index.php"
    fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
}
```

#### Two Ways to Set `$fastcgi_script_name`:

1. **Explicit (old way)**:
   ```nginx
   fastcgi_split_path_info ^(.+\.php)(/.+)$;
   # This sets $fastcgi_script_name
   ```

2. **Automatic (modern way)**:
   ```nginx
   location ~ ^/index\.php(/|$) {
       # nginx automatically sets $fastcgi_script_name
   }
   ```

### How Laravel Gets the Original Request

#### The Complete Request Flow:

**Step 1: Browser Request**
```
GET https://laracastlaravel.test/api/users?page=1
```

**Step 2: nginx Processing**
```nginx
$uri = "/api/users"
$request_uri = "/api/users?page=1"
$query_string = "page=1"
```

**Step 3: try_files Fallback**
```nginx
try_files $uri $uri/ /index.php?$query_string;
# Results in: /index.php?page=1
```

**Step 4: nginx → PHP-FPM via FastCGI**
```nginx
fastcgi_param SCRIPT_FILENAME "/etc/nginx/code/laracast_laravel/public/index.php";
fastcgi_param REQUEST_URI "/api/users?page=1";  # Original request preserved!
fastcgi_param REQUEST_METHOD "GET";
fastcgi_param QUERY_STRING "page=1";
```

**Step 5: Laravel Receives**
```php
$_SERVER['REQUEST_URI'] = "/api/users?page=1";  # Laravel uses this for routing
$_SERVER['SCRIPT_FILENAME'] = "/path/to/index.php";
$_SERVER['REQUEST_METHOD'] = "GET";
```

**Step 6: Laravel Routes**
```php
Route::get('/api/users', function() { ... }); // This matches!
```

### Key Insights

1. **`fastcgi_param` is the Bridge**: It transforms nginx variables into PHP `$_SERVER` variables
2. **`$fastcgi_script_name` is Auto-Set**: nginx sets it automatically with regex location matching
3. **Original Request Preserved**: Laravel gets the original request URI, not the internal nginx processing
4. **FastCGI Enables Performance**: Keeps PHP processes running for multiple requests

### Why This Architecture Works

- **nginx**: Handles static files, SSL, load balancing
- **FastCGI**: Efficient communication protocol
- **PHP-FPM**: Manages PHP processes
- **Laravel**: Handles application logic and routing

This creates a fast, secure, and scalable setup for serving Laravel applications!

This configuration provides a secure, performant setup for serving your Laravel application with nginx!
