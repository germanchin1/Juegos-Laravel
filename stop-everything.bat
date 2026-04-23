@echo off
setlocal
title Apagar Entorno Juegos Laravel

echo.
echo  ==============================================================
echo      🛑 APAGANDO ENTORNO DE DESARROLLO...                      
echo  ==============================================================
echo.

:: 1. Detener contenedores Docker
echo [1/2] ⬇️ Deteniendo contenedores (Docker)...
docker-compose down

:: 2. Limpieza (opcional)
echo [2/2] 🧹 Limpiando procesos de red...
:: Nota: Las ventanas de Worker y Vite abiertas por el start-script se pueden cerrar manualmente,
:: o se detendrán solas al no encontrar el contenedor de Docker.

echo.
echo  ==============================================================
echo      ✅ ENTORNO APAGADO CORRECTAMENTE. ¡Hasta pronto!          
echo  ==============================================================
echo.
pause
