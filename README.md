composer run setup  
composer install  
pnpm install && pnpm run build  
composer run dev  

nano ~/.bash_aliases
電腦重開後，wsl2裡要跑這兩個 function 重啟服務  
restart_laravel_dev_env  
status_laravel_dev_env  

# nginx 
```bash 
sudo nano /etc/nginx/nginx.conf
# user www-data;
```

# php-fpm
sudo nano /etc/php/8.4/fpm/pool.d/www.conf
```ini
; Unix user/group of processes
user = gohomewho
group = gohomewho

; The address on which to accept FastCGI requests.
listen = /run/php/php8.4-fpm.sock

; Use ACL to grant access to multiple users
listen.acl_users = gohomewho,www-data
```

```bash
php-fpm8.4 -t

# Chown entire project
sudo chown -R gohomewho:gohomewho /home/gohomewho/code/laracast_laravel

# Set writable permissions for Laravel directories
sudo chmod -R 775 /home/gohomewho/code/laracast_laravel/storage
sudo chmod -R 775 /home/gohomewho/code/laracast_laravel/bootstrap/cache

# Ensure www-data can traverse to files
sudo chmod 755 /home/gohomewho/
sudo chmod 755 /home/gohomewho/code/

sudo systemctl restart php8.4-fpm 
ls -la /run/php/php8.4-fpm.sock 
sudo nginx -t 
sudo systemctl reload nginx 
sudo systemctl restart nginx 
```

**Why this works:**
- PHP-FPM runs as `gohomewho` → can access your files
- Socket owned by `gohomewho` → stays with PHP-FPM user
- ACL grants `www-data` access → Nginx can connect
- Files owned by `gohomewho` → PHP-FPM can read/write
- Clean and flexible → easy to add more users if needed


# local ssl
```bash
# 在 wsl2 裡
mkcert -install
# 複製到 windows 安裝
cp ~/.local/share/mkcert/rootCA.pem /mnt/c/Users/gohomewho/Downloads/rootCA.pem

# 用 wildcard 還是會有瀏覽器警告，所以直接寫完整 domain
mkcert laracastlaravel.test
sudo mv laracastlaravel.test.pem /etc/nginx/ssl/
sudo mv laracastlaravel.test-key.pem /etc/nginx/ssl/

# admin powershell 寫入 127.0.0.1 laracastlaravel.test
notepad C:\Windows\System32\drivers\etc\hosts
```

把這裡的 nginx.conf 複製到 nginx 資料夾裡
```bash
sudo cp ~/code/laracast_laravel/laravel_nginx.conf /etc/nginx/sites-enabled/laravel_nginx.conf
```

不確定幹嘛用的 ide-helper 
https://github.com/barryvdh/laravel-ide-helper 
```bash 
php artisan ide-helper:generate
php artisan ide-helper:models -RW
```


