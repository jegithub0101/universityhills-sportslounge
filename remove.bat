@echo off
setlocal enabledelayedexpansion

REM Loop through each file in the current directory
for %%f in (*^(1^).*) do (
    REM Get the file name without the (1) part
    set "newname=%%~nf"
    set "newname=!newname:~0,-3!%%~xf"

    REM Remove excess spaces from the file name
    set "newname=!newname: =!"

    REM Rename the file if it doesn't already exist
    if not exist "!newname!" ren "%%f" "!newname!"
)

echo Renaming complete!
pause
