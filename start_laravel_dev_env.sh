#!/bin/bash

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
    exit 1
fi

# Start services with error checking
echo "🔄 Starting nginx..."
if sudo systemctl start nginx; then
    echo "✅ Nginx started successfully"
else
    echo "❌ Nginx failed to start!"
    echo "Run 'sudo systemctl status nginx' for details"
    exit 1
fi

echo "🔄 Starting PHP-FPM..."
if sudo systemctl start php8.4-fpm; then
    echo "✅ PHP-FPM started successfully"
else
    echo "❌ PHP-FPM failed to start!"
    exit 1
fi

# Optional services
sudo service mysql start 2>/dev/null || echo "ℹ️  MySQL not installed or already running"
sudo service redis-server start 2>/dev/null || echo "ℹ️  Redis not installed or already running"
sudo service memcached start 2>/dev/null || echo "ℹ️  Memcached not installed or already running"

echo "✅ All services started! Your Laravel app is available at:"
echo "   🌐 https://laracastlaravel.test"
echo "   🔧 http://laracastlaravel.test (redirects to HTTPS)"
