composer run setup  
composer install  
pnpm install && npm run build  
composer run dev  

nano ~/.bash_aliases
電腦重開後，wsl2裡要跑這兩個 function 重啟服務
restart_laravel_dev_env
status_laravel_dev_env