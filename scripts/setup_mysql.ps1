# MySQL setup for EproExpo (Windows)
# Run from project root in an elevated PowerShell terminal if MySQL service start fails.

$ErrorActionPreference = "Stop"
$ProjectRoot = Split-Path -Parent $MyInvocation.MyCommand.Path
Set-Location (Join-Path $ProjectRoot "..")

Write-Host "==> EproExpo MySQL setup" -ForegroundColor Cyan

$mysqlService = Get-Service -Name "MySQL80" -ErrorAction SilentlyContinue
if ($mysqlService -and $mysqlService.Status -ne "Running") {
    Write-Host "Starting MySQL80 service..."
    try {
        Start-Service MySQL80
        Start-Sleep -Seconds 3
    } catch {
        Write-Warning "Could not start MySQL80 automatically. Run PowerShell as Administrator and execute: net start MySQL80"
    }
}

$mysqlExe = "C:\Program Files\MySQL\MySQL Server 8.0\bin\mysql.exe"
if (-not (Test-Path $mysqlExe)) {
    throw "MySQL client not found at $mysqlExe"
}

$dbName = "erpoexpo"
Write-Host "Creating database '$dbName' if missing..."
& $mysqlExe -u root -e "CREATE DATABASE IF NOT EXISTS ``$dbName`` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

Write-Host "Running Laravel setup commands..."
php artisan config:clear
php artisan cache:clear
php artisan migrate --force
php artisan db:sync-project-data
php artisan storage:link 2>$null

Write-Host "Optional demo seed (set APP_SEED_BASE=true and APP_SEED_DEMO=true in .env first):"
Write-Host "  php artisan db:seed"

Write-Host "Done. Verify with: php scripts/mysql_counts.php" -ForegroundColor Green
