composer run setup  
composer install  
pnpm install && pnpm run build  
composer run dev  

nano ~/.bash_aliases
電腦重開後，wsl2裡要跑這兩個 function 重啟服務  
restart_laravel_dev_env  
status_laravel_dev_env  

# php-fpm
user 不改了，改資料夾權限

## Make www-data the owner of Laravel directories
sudo chown -R www-data:www-data /home/gohomewho/code/laracast_laravel/storage/ 
sudo chown -R www-data:www-data /home/gohomewho/code/laracast_laravel/bootstrap/cache/ 

## Set proper permissions
sudo chmod -R 775 /home/gohomewho/code/laracast_laravel/storage/ 
sudo chmod -R 775 /home/gohomewho/code/laracast_laravel/bootstrap/cache/ 

sudo systemctl restart php8.4-fpm 
ls -la /run/php/php8.4-fpm.sock 
sudo nginx -t 
sudo systemctl reload nginx 
sudo systemctl restart nginx 

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