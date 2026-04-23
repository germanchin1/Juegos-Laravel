<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# 📊 juegos-laravel: Ecosistema Local de Eventos

Este proyecto es una plataforma de juegos basada en **Laravel 12**, potenciada con un sistema de arquitectura desacoplada mediante **RabbitMQ** y **MCP**.

---

## 🏗️ Arquitectura del Sistema
El flujo de datos sigue este camino automatizado totalmente en local:

`Desarrollador (Commit)` ➔ `Git Hook (Post-commit)` ➔ `RabbitMQ (Queue)` ➔ `Laravel Worker (Analyst Job)` ➔ `COMMIT_HISTORY.md`

---

## 📸 Registro Automático (Analista Interno)
Cada vez que se realiza un commit, el **Analista Automático** procesa el evento y genera una entrada en el historial de actividad.

```markdown
# 💾 Historial de Actividad (RabbitMQ)

### 🚀 Commit Detectado: Test commit from AI
- **Autor:** Germanchin
- **Estado:** ✅ Procesado por el Analista Automático
```

---

## 🚀 Cómo empezar en un clic
He creado scripts maestros para que no tengas que configurar nada manualmente:

1.  **[full-start.bat](file:///e:/Juegos%20Laravel/full-start.bat)**: Enciende Docker, el Analyst Worker, Vite y abre el navegador.
2.  **[stop-everything.bat](file:///e:/Juegos%20Laravel/stop-everything.bat)**: Apaga todo el entorno de forma segura.

---

## 🛠️ Panel de Control
| Servicio | URL | Acceso |
| :--- | :--- | :--- |
| **Laravel App** | http://localhost | - |
| **RabbitMQ** | http://localhost:15672 | `guest` / `guest` |
| **API Webhooks** | http://localhost/api/github-webhook | POST |

---

## 🤖 Guía para Inteligencia Artificial
Si vas a usar este proyecto con **Claude** u otra IA, pásale el archivo especializado:
👉 **[InstruccionesParaClaude.md](file:///e:/Juegos%20Laravel/InstruccionesParaClaude.md)**

---
*Desarrollado con ❤️ para aprendizaje de arquitecturas basadas en eventos.*