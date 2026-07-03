# Connect Laravel to MySQL (phpMyAdmin) and sync all project data.
# If MySQL is stopped, start it first: right-click scripts\start_mysql_admin.bat -> Run as administrator

$ErrorActionPreference = "Stop"
$ProjectRoot = Resolve-Path (Join-Path $PSScriptRoot "..")
Set-Location $ProjectRoot

$mysqlExe = "C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe"
$dbName = "erpoexpo"

function Test-MySqlPort {
    $socket = New-Object System.Net.Sockets.TcpClient
    try {
        $socket.Connect("127.0.0.1", 3306)
        $socket.Close()
        return $true
    } catch {
        return $false
    }
}

$service = Get-Service -Name "MySQL80" -ErrorAction SilentlyContinue
if ($service -and $service.Status -ne "Running") {
    Write-Host "MySQL80 is stopped. Start it as Administrator:" -ForegroundColor Yellow
    Write-Host "  net start MySQL80" -ForegroundColor Cyan
    Write-Host "  OR right-click scripts\start_mysql_admin.bat -> Run as administrator" -ForegroundColor Cyan
    Write-Host ""
    Write-Host "Waiting up to 3 minutes for MySQL on port 3306..." -ForegroundColor Yellow

    $deadline = (Get-Date).AddMinutes(3)
    while ((Get-Date) -lt $deadline) {
        if (Test-MySqlPort) { break }
        Start-Sleep -Seconds 3
    }
}

if (-not (Test-MySqlPort)) {
    Write-Host "MySQL is still not reachable on 127.0.0.1:3306. Start MySQL80 and rerun this script." -ForegroundColor Red
    exit 1
}

Write-Host "MySQL port open. Creating database if needed..." -ForegroundColor Green
if (Test-Path $mysqlExe) {
    & $mysqlExe -u root -e "CREATE DATABASE IF NOT EXISTS ``$dbName`` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
} else {
    Write-Warning "mysql.exe not found; assuming database '$dbName' already exists in phpMyAdmin."
}

Write-Host "Running migrations and full project data sync..." -ForegroundColor Green
php artisan config:clear
php artisan cache:clear
php artisan migrate --force
php artisan db:sync-project-data
php artisan storage:link 2>$null

Write-Host ""
Write-Host "Done. Verify row counts:" -ForegroundColor Green
php scripts/mysql_counts.php
