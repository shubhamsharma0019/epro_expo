@echo off
cd /d "%~dp0"

"C:\Users\HELLO!\AppData\Local\Microsoft\WinGet\Packages\PHP.PHP.8.2_Microsoft.Winget.Source_8wekyb3d8bbwe\php.exe" -c "%~dp0php-local.ini" -S 127.0.0.1:9090 -t "%~dp0public" "%~dp0server-local.php"

pause
