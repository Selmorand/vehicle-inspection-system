@echo off
echo Starting image optimization...
echo.

REM Create backup directory
if not exist "public\images\panels\backup" mkdir "public\images\panels\backup"
if not exist "public\images\interior\backup" mkdir "public\images\interior\backup"

echo Backing up original images...
xcopy "public\images\panels\*.png" "public\images\panels\backup\" /Y
xcopy "public\images\panels\*.jpg" "public\images\panels\backup\" /Y
xcopy "public\images\interior\*.png" "public\images\interior\backup\" /Y
xcopy "public\images\interior\*.jpg" "public\images\interior\backup\" /Y

echo.
echo Images backed up successfully!
echo.
echo To optimize images, you can use:
echo 1. Online tool: https://tinypng.com (drag and drop your images)
echo 2. Install ImageMagick and run: magick mogrify -quality 85 *.jpg
echo 3. Use PHP script with Intervention Image (run: php artisan images:optimize)
echo.
pause