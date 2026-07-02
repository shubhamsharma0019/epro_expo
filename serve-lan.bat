@echo off
echo Starting Laravel for phone QR scan on all network interfaces...
echo Open on phone: http://YOUR-LAN-IP:8000/ticket-scanner/login
echo.
php artisan serve --host=0.0.0.0 --port=8000
