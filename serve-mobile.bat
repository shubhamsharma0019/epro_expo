@echo off
title EproExpo - Mobile QR Server
echo.
echo  Phone QR scan ke liye server start ho raha hai...
echo  PC aur phone dono SAME WiFi par hon.
echo  Phone par mobile data OFF rakho.
echo.
echo  URL: http://192.168.1.10:8000
echo.
php artisan serve --host=0.0.0.0 --port=8000
