@echo off
echo Starting MySQL80 service (requires Administrator)...
net start MySQL80
if errorlevel 1 (
    echo.
    echo Failed to start MySQL. Right-click this file and choose "Run as administrator".
    pause
    exit /b 1
)

echo MySQL started. Running Laravel setup...
cd /d "%~dp0.."
"C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe" -u root -e "CREATE DATABASE IF NOT EXISTS erpoexpo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
php artisan config:clear
php artisan migrate --force
php artisan db:sync-project-data
echo.
echo Done. Refresh http://127.0.0.1:8000
pause
