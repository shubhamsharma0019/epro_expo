# Run from project folder in TWO terminals:
#
# Terminal 1:
#   php artisan serve --host=0.0.0.0 --port=8000
#
# Terminal 2:
#   npx localtunnel --port 8000
#
# Copy the https://....loca.lt URL and set APP_URL in .env, then:
#   php artisan config:clear

Write-Host "Starting Laravel on http://0.0.0.0:8000 ..."
Start-Process powershell -ArgumentList "-NoExit", "-Command", "cd '$PSScriptRoot\..'; php artisan serve --host=0.0.0.0 --port=8000"

Start-Sleep -Seconds 3

Write-Host "Starting public tunnel (localtunnel)..."
Set-Location (Split-Path $PSScriptRoot -Parent)
npx --yes localtunnel --port 8000
