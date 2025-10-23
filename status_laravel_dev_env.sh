#!/bin/bash

echo "📊 Service Status:"
echo "Nginx: $(sudo systemctl is-active nginx)"
echo "PHP-FPM: $(sudo systemctl is-active php8.4-fpm)"

# The corrected lines for services that might not be installed
echo "MySQL: $(sudo systemctl status mysql &>/dev/null && sudo systemctl is-active mysql || echo 'Not installed')"
echo "Redis: $(sudo systemctl status redis-server &>/dev/null && sudo systemctl is-active redis-server || echo 'Not installed')"
echo "Memcached: $(sudo systemctl status memcached &>/dev/null && sudo systemctl is-active memcached || echo 'Not installed')"
