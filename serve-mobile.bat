@echo off
title EproExpo - Mobile QR Server
echo.
echo  Starting server for phone QR ticket scanning...
echo  Keep your PC and phone on the SAME Wi-Fi network.
echo  Turn OFF mobile data on your phone.
echo.
for /f "delims=" %%i in ('php -r "require 'vendor/autoload.php'; $app=require 'bootstrap/app.php'; $app->make('Illuminate\\Contracts\\Console\\Kernel')->bootstrap(); echo \\App\\Support\\EventTicketQr::detectLocalNetworkBaseUrl() ?? 'http://YOUR-LAN-IP:8000';"') do set LAN_URL=%%i
echo  URL: %LAN_URL%
echo  Scanner: %LAN_URL%/ticket-scanner/login
echo.
php artisan config:clear
php artisan serve --host=0.0.0.0 --port=8000
