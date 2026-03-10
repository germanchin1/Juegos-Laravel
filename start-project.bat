@echo off
echo Iniciando el entorno de desarrollo con Docker...
docker-compose up -d
echo.
echo Entorno de Laravel iniciado correctamente.
echo Accediendo a: http://localhost:80
echo.
start http://localhost:80
pause
