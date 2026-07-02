@echo off
setlocal
echo.
echo Starting Laravel for phone QR scanning on all network interfaces...
echo.
for /f "delims=" %%i in ('php -r "require 'vendor/autoload.php'; $app=require 'bootstrap/app.php'; $app->make('Illuminate\\Contracts\\Console\\Kernel')->bootstrap(); echo \\App\\Support\\EventTicketQr::detectLocalNetworkBaseUrl() ?? 'http://YOUR-LAN-IP:8000';"') do set LAN_URL=%%i
echo Phone scanner login: %LAN_URL%/ticket-scanner/login
echo Default scanner username: scanner
echo.
echo Keep this window open while scanning from your phone.
echo.
php artisan serve --host=0.0.0.0 --port=8000
