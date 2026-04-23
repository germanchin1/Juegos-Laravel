# Contexto del Proyecto: Integración de MCP y RabbitMQ

Hola Claude, este repositorio es un proyecto de Laravel 12 configurado para trabajar con **Model Context Protocol (MCP)** y **RabbitMQ**. Se ha implementado esta arquitectura para permitir una asistencia inteligente desacoplada y basada en eventos.

## Lo que se ha implementado:

1.  **Infraestructura Docker**:
    *   **RabbitMQ**: Servidor de mensajería (puertos 5672, 15672).
    *   **MCP GitHub Server**: Servidor MCP para interactuar con este repositorio, gestionar issues y PRs.
    *   **MCP RabbitMQ Server**: Servidor MCP para gestionar colas y monitorizar eventos de RabbitMQ.

2.  **Integración con Laravel**:
    *   **Driver**: Se ha instalado `vladimir-yuldashev/laravel-queue-rabbitmq`.
    *   **Configuración**: El sistema de colas está configurado para usar el driver `rabbitmq`.
    *   **Provider**: Registrado manualmente en `bootstrap/providers.php`.

3.  **Comando de Verificación**:
    *   Comando `php artisan app:test-rabbitmq` que publica un evento de prueba en la cola `events_queue`.

## Cómo puedes ayudar (Tu Misión):

Como asistente con capacidades MCP, puedes usar los servidores configurados en este proyecto para:

1.  **Analizar el Código**: Lee los archivos a través del MCP de GitHub para sugerir mejoras o detectar errores.
2.  **Manejar Eventos**: Utiliza el MCP de RabbitMQ para verificar si las colas están recibiendo mensajes y proponer trabajadores (workers) que reaccionen a estos eventos.
3.  **Gestión de Repositorio**: Ayuda a crear issues o documentar pull requests basándote en la actividad del proyecto.

## Credenciales y Acceso:

*   **RabbitMQ Management**: http://localhost:15672 (guest/guest).
*   **Configuración MCP**: Tienes un archivo de ejemplo en `./mcp-config.example.json` para configurar tus herramientas.
*   **Token de GitHub**: Asegúrate de tener el TOKEN configurado en tu entorno local para que el servidor MCP de GitHub pueda autenticarse.

---
**Tarea actual**: Por favor, revisa la estructura actual y propón un sistema de "Workers" en Laravel que escuche el evento `pull_request.opened` enviado por el comando de prueba para realizar una acción automática (por ejemplo, registrarlo en la base de datos o enviar una notificación log).
