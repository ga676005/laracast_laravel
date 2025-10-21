# WSL2 Laravel Development: Nginx + PHP-FPM + HTTPS Setup Guide

This guide walks through setting up a production-like development environment for Laravel in WSL2 using Nginx, PHP-FPM, and HTTPS with trusted SSL certificates.

## Prerequisites

- WSL2 with Ubuntu
- PHP 8.4+ installed
- Laravel project ready
- mkcert installed

## 1. Install Required Packages

```bash
# Update system
sudo apt update

# Install nginx and php-fpm
sudo apt install -y nginx php8.4-fpm
```

## 2. Configure PHP-FPM

### 2.1 Edit PHP-FPM Pool Configuration
```bash
sudo nano /etc/php/8.4/fpm/pool.d/www.conf
```

**IMPORTANT**: Change these lines:
```ini
user = gohomewho
group = gohomewho
listen = 127.0.0.1:9250
listen.owner = gohomewho
listen.group = gohomewho
```

### 2.2 Start and Enable PHP-FPM
```bash
sudo systemctl start php8.4-fpm
sudo systemctl enable php8.4-fpm
```

## 3. Set Up File Permissions

### 3.1 Add www-data to Your User Group
```bash
sudo usermod -a -G gohomewho www-data
```

### 3.2 Set Proper Ownership and Permissions

**CRITICAL**: Ensure www-data can traverse the directory path to your files:

```bash
# Make sure www-data can access the path to your files
sudo chmod 755 /home/gohomewho/
sudo chmod 755 /home/gohomewho/code/
```

**Option A: Group Ownership (Recommended for Production)**
```bash
# Set ownership to your user with www-data group
sudo chown -R gohomewho:www-data /home/gohomewho/laracast_laravel

# Make directories readable by group
sudo chmod -R 755 /home/gohomewho/laracast_laravel

# Make storage and cache writable by group (Laravel needs this)
sudo chmod -R 775 /home/gohomewho/laracast_laravel/storage
sudo chmod -R 775 /home/gohomewho/laracast_laravel/bootstrap/cache

# Set group sticky bit so new files inherit the group
sudo chmod g+s /home/gohomewho/laracast_laravel
```

**Option B: Add www-data to Your Group**
```bash
# Set ownership to your user
sudo chown -R gohomewho:gohomewho /home/gohomewho/laracast_laravel

# Make directories readable by group
sudo chmod -R 755 /home/gohomewho/laracast_laravel

# Make storage and cache writable by group (Laravel needs this)
sudo chmod -R 775 /home/gohomewho/laracast_laravel/storage
sudo chmod -R 775 /home/gohomewho/laracast_laravel/bootstrap/cache

# Ensure public directory is accessible
sudo chmod 755 /home/gohomewho/laracast_laravel/public
```

## 4. Configure Nginx

### 4.1 Create Virtual Host Configuration
```bash
sudo nano /etc/nginx/sites-available/laravel
```

### 4.2 Add Nginx Configuration
```nginx
server {
    listen 80;
    server_name laracast_laravel.test;
    return 301 https://$server_name$request_uri;
}

server {
    listen 443 ssl;
    http2 on;
    server_name laracast_laravel.test;
    root /home/gohomewho/laracast_laravel/public;
    index index.php index.html;

    # SSL Configuration
    ssl_certificate /etc/nginx/ssl/cert.pem;
    ssl_certificate_key /etc/nginx/ssl/key.pem;
    
    # SSL Security Settings
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers ECDHE-RSA-AES256-GCM-SHA512:DHE-RSA-AES256-GCM-SHA512:ECDHE-RSA-AES256-GCM-SHA384:DHE-RSA-AES256-GCM-SHA384;
    ssl_prefer_server_ciphers off;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.4-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

### 4.3 Enable the Site
```bash
# Enable your site
sudo ln -s /etc/nginx/sites-available/laravel /etc/nginx/sites-enabled/

# Remove default site
sudo rm /etc/nginx/sites-enabled/default

# Test nginx configuration
sudo nginx -t

# Restart nginx
sudo systemctl restart nginx
```

## 5. Set Up Custom Domain (WSL2)

### 5.1 Add Domain to Windows Hosts File
**On Windows (PowerShell as Administrator):**
```powershell
notepad C:\Windows\System32\drivers\etc\hosts
```

Add this line:
```
127.0.0.1 laracast_laravel.test
```

## 6. Generate Trusted SSL Certificates

### 6.1 Install mkcert Root CA in WSL2
```bash
mkcert -install
```

### 6.2 Generate ECDSA Certificate
```bash
# Navigate to your project directory
cd /home/gohomewho/laracast_laravel

# Generate certificate for your domain
mkcert -ecdsa 'laracast_laravel.test' '*.laracast_laravel.test' localhost 127.0.0.1 ::1
```

### 6.3 Set Up SSL Directory Structure
```bash
# Create SSL directory
sudo mkdir -p /etc/dev-ssl

# Move certificates to dev-ssl directory
sudo mv laracast_laravel.test+3.pem /etc/dev-ssl/cert.pem
sudo mv laracast_laravel.test+3-key.pem /etc/dev-ssl/key.pem

# Set proper permissions
sudo chmod 644 /etc/dev-ssl/cert.pem
sudo chmod 600 /etc/dev-ssl/key.pem

# Copy certificates to nginx ssl directory (nginx expects them here)
sudo cp /etc/dev-ssl/cert.pem /etc/nginx/ssl/
sudo cp /etc/dev-ssl/key.pem /etc/nginx/ssl/

# Set proper permissions for nginx ssl directory
sudo chmod 644 /etc/nginx/ssl/cert.pem
sudo chmod 600 /etc/nginx/ssl/key.pem
```

## 7. Install Root CA on Windows

### 7.1 Copy Root CA to Windows
```bash
# Copy root CA to Windows Desktop
cp /home/gohomewho/.local/share/mkcert/rootCA.pem /mnt/c/Users/$USER/Desktop/rootCA.crt
```

### 7.2 Install Certificate on Windows
1. **Navigate to your Desktop in Windows File Explorer**
2. **Double-click `rootCA.crt`** (Windows will open Certificate Manager automatically)
3. **Click "Install Certificate"**
4. **Choose "Local Machine"**
5. **Choose "Place all certificates in the following store"**
6. **Click "Browse" and select "Trusted Root Certification Authorities"**
7. **Click "Next" → "Finish"**

### 7.3 Restart Browser
**IMPORTANT**: Close and reopen your browser completely after installing the certificate.

## 8. Test Your Setup

### 8.1 Test HTTP (should redirect to HTTPS)
```bash
curl -I http://laracast_laravel.test
```

### 8.2 Test HTTPS
Visit `https://laracast_laravel.test` in your browser.

You should see:
- ✅ No "Not Secure" warning
- ✅ Green lock icon
- ✅ Your Laravel application running

## 9. Troubleshooting

### 9.1 Common Issues

**502 Bad Gateway Error:**
- Check if PHP-FPM is running: `sudo systemctl status php8.4-fpm`
- Check socket permissions: `ls -la /run/php/php8.4-fpm.sock`
- Check nginx error logs: `sudo tail -f /var/log/nginx/error.log`

**Permission Denied Errors:**
- Ensure www-data is in your user group: `groups www-data`
- Check file ownership: `ls -la /home/gohomewho/laracast_laravel/public`
- **CRITICAL**: Ensure www-data can traverse the directory path:
  ```bash
  # Test if www-data can access each level of the path
  sudo -u www-data ls /home/gohomewho/
  sudo -u www-data ls /home/gohomewho/code/
  sudo -u www-data ls /home/gohomewho/code/laracast_laravel/
  sudo -u www-data ls /home/gohomewho/code/laracast_laravel/public/
  ```
- Fix directory traversal permissions:
  ```bash
  sudo chmod 755 /home/gohomewho/
  sudo chmod 755 /home/gohomewho/code/
  ```

**SSL Certificate Not Trusted:**
- Ensure root CA is installed on Windows (not just WSL2)
- Restart browser after installing certificate
- Check certificate is ECDSA type: `openssl x509 -in /etc/dev-ssl/cert.pem -text -noout`

### 9.2 Useful Commands

```bash
# Check nginx status
sudo systemctl status nginx

# Check PHP-FPM status
sudo systemctl status php8.4-fpm

# Test nginx configuration
sudo nginx -t

# Restart services
sudo systemctl restart nginx
sudo systemctl restart php8.4-fpm

# Check certificate details
openssl x509 -in /etc/dev-ssl/cert.pem -text -noout

# Test SSL connection
openssl s_client -connect laracast_laravel.test:443
```

## 10. Key Points to Remember

### 🔑 **Critical Success Factors:**

1. **File Permissions**: www-data must be able to read your files
2. **Directory Traversal**: www-data must be able to traverse the path to your files
3. **Certificate Type**: Use ECDSA certificates (`mkcert -ecdsa`)
4. **File Extension**: Rename `.pem` to `.crt` for Windows recognition
5. **Root CA Installation**: Must be installed on Windows, not just WSL2
6. **Browser Restart**: Always restart browser after certificate installation

### 📋 **Permission Strategy Comparison:**

**Option A (Group Ownership) - Recommended for Production:**
- Files owned by: `youruser:www-data`
- Benefits: New files automatically inherit correct group
- Use: Production environments, team development
- Command: `sudo chown -R youruser:www-data /path/to/project`

**Option B (User Group) - Simpler for Solo Development:**
- Files owned by: `youruser:youruser`
- www-data added to your group
- Benefits: Simpler setup, works with existing file ownership
- Use: Solo development, quick setup
- Command: `sudo usermod -a -G youruser www-data`

### 📁 **Directory Structure:**
```
/etc/nginx/ssl/          # SSL certificates (copied from /etc/dev-ssl)
/etc/dev-ssl/            # SSL certificate storage location
/home/gohomewho/laracast_laravel/public/  # Laravel public directory
```

### 🔒 **Security Notes:**
- This setup is for **development only**
- Never use these certificates in production
- The root CA gives full certificate authority - keep it secure

## 11. Development Workflow

### 11.1 Create Restart Functions
Add these functions to your `~/.bash_aliases` file for easy service management:

```bash
# Edit your bash aliases
nano ~/.bash_aliases
```

Add these functions:
```bash
# Laravel development services restart function
restart_laravel_dev_env() {
    echo "🚀 Starting Laravel development services..."
    
    # Create necessary directories
    sudo mkdir -p /var/run/php
    sudo mkdir -p /var/run/mysqld
    
    # Set proper ownership
    sudo chown mysql:mysql /var/run/mysqld 2>/dev/null || true
    
    # Stop any conflicting services first
    echo "🛑 Stopping conflicting services..."
    sudo systemctl stop apache2 2>/dev/null || true
    sudo pkill -f nginx 2>/dev/null || true
    
    # Test nginx configuration first
    echo "🔍 Testing nginx configuration..."
    if ! sudo nginx -t; then
        echo "❌ Nginx configuration test failed!"
        echo "Run 'sudo nginx -t' to see the error details"
        return 1
    fi
    
    # Start services with error checking
    echo "🔄 Starting nginx..."
    if sudo systemctl start nginx; then
        echo "✅ Nginx started successfully"
    else
        echo "❌ Nginx failed to start!"
        echo "Run 'sudo systemctl status nginx' for details"
        return 1
    fi
    
    echo "🔄 Starting PHP-FPM..."
    if sudo systemctl start php8.4-fpm; then
        echo "✅ PHP-FPM started successfully"
    else
        echo "❌ PHP-FPM failed to start!"
        return 1
    fi
    
    # Optional services
    sudo service mysql start 2>/dev/null || echo "ℹ️  MySQL not installed or already running"
    sudo service redis-server start 2>/dev/null || echo "ℹ️  Redis not installed or already running"
    sudo service memcached start 2>/dev/null || echo "ℹ️  Memcached not installed or already running"
    
    echo "✅ All services started! Your Laravel app is available at:"
    echo "   🌐 https://laracast_laravel.test"
    echo "   🔧 http://laracast_laravel.test (redirects to HTTPS)"
}

# Quick service status check
status_laravel_dev_env() {
    echo "📊 Service Status:"
    echo "Nginx: $(sudo systemctl is-active nginx)"
    echo "PHP-FPM: $(sudo systemctl is-active php8.4-fpm)"
    echo "MySQL: $(sudo systemctl is-active mysql 2>/dev/null || echo 'Not installed')"
    echo "Redis: $(sudo systemctl is-active redis-server 2>/dev/null || echo 'Not installed')"
    echo "Memcached: $(sudo systemctl is-active memcached 2>/dev/null || echo 'Not installed')"
}
```

### 11.2 Reload Bash Aliases
```bash
# Reload your bash aliases
source ~/.bash_aliases
```

### 11.3 Start Development:
```bash
# Use the restart function (recommended)
restart_laravel_dev_env

# Or start services manually
sudo systemctl start nginx
sudo systemctl start php8.4-fpm

# Your Laravel app is now available at:
# https://laracast_laravel.test
```

### 11.4 Check Service Status:
```bash
# Check all services status
status_laravel_dev_env

# Or check individual services
sudo systemctl status nginx
sudo systemctl status php8.4-fpm
```

### 11.5 Stop Development:
```bash
# Stop services
sudo systemctl stop nginx
sudo systemctl stop php8.4-fpm
```

### 11.6 After PC Restart:
**IMPORTANT**: After restarting your PC, you need to manually start the services again:

```bash
# Quick restart with error checking
restart_laravel_dev_env

# Check if everything is running
status_laravel_dev_env
```

---

**Congratulations!** You now have a production-like development environment with trusted HTTPS certificates. This setup closely mirrors how your application would run in production while maintaining the convenience of local development.
