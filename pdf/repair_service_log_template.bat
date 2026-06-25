@echo off
setlocal
cd /d "%~dp0"
if not exist "service_log.pdf" (
  echo Missing service_log.pdf in this folder.
  exit /b 1
)
set "GS="
for /d %%D in ("C:\Program Files\gs\*") do (
  if exist "%%D\bin\gswin64c.exe" set "GS=%%D\bin\gswin64c.exe"
)
if not defined GS (
  echo Ghostscript was not found under C:\Program Files\gs\
  echo Install from https://www.ghostscript.com/download/gsdnld.html then run this script again.
  exit /b 1
)
echo Using: %GS%
"%GS%" -dNOPAUSE -dBATCH -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dPDFSETTINGS=/default -sOutputFile=service_log_compat.pdf -f "service_log.pdf"
if errorlevel 1 (
  echo Ghostscript failed.
  exit /b 1
)
echo.
echo Created service_log_compat.pdf
echo process_service_log.php will use it automatically if service_log.pdf cannot be parsed.
endlocal
