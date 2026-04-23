@echo off
setlocal
title Entorno Completo Juegos Laravel

echo.
echo  ==============================================================
echo     🚀 INICIANDO ENTORNO DE DESARROLLO (RABBITMQ + ANALISTA)   
echo  ==============================================================
echo.

:: 1. Levantar Docker
echo [1/4] 🔄 Levantando contenedores (Docker)...
docker-compose up -d

:: 2. Esperar a que los servicios estén listos
echo [2/4] ⏳ Esperando a que los servicios se estabilicen...
timeout /t 5 /nobreak > nul

:: 3. Lanzar procesos en segundo plano (ventanas nuevas)
echo [3/4] 👷 Iniciando Analista de RabbitMQ (Queue Worker)...
start "Worker de Laravel" cmd /c "docker-compose exec php php artisan queue:work"

echo [3/4] ⚡ Iniciando Vite (Frontend)...
start "Vite Dev Server" cmd /c "docker-compose exec php npm run dev"

:: 4. Abrir enlaces útiles
echo [4/4] 🌍 Abriendo aplicaciones en el navegador...
echo    - Aplicación: http://localhost
echo    - RabbitMQ:   http://localhost:15672 (guest/guest)
start http://localhost
start http://localhost:15672

echo.
echo  ==============================================================
echo      ✅ ¡TODO LISTO! El Analista está escuchando tus commits.   
echo  ==============================================================
echo.
pause
