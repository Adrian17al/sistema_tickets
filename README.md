# Sistema de Gestión de Tickets de Soporte

Este es un sistema de tickets ligero, rápido y escalable desarrollado en PHP nativo siguiendo la arquitectura MVC (Modelo - Vista - Controlador). Está pensado para gestionar incidencias de soporte técnico con prevención de colisiones (bloqueo de tickets) en entornos con varios agentes trabajando simultáneamente.

---

## Guía de Instalación (Producción)

Sigue estos pasos para desplegar el sistema en un hosting compartido (cPanel, Plesk) o un VPS.

### 1. Requisitos del servidor

- **PHP:** 7.4+ (recomendado 8.0+)
- **Base de datos:** MySQL 5.7+ o MariaDB 10+
- **Servidor web:** Apache (con `mod_rewrite`) o Nginx
- **Extensiones PHP:** `pdo`, `pdo_mysql`

### 2. Subida de archivos

1. Comprime la carpeta del proyecto (`sistema_tickets`) en un `.zip`.
2. Usa el Administrador de Archivos del hosting o un cliente FTP (ej. FileZilla) para subir el `.zip` a la carpeta pública (`public_html` o `www`).
3. Descomprime los archivos. Asegúrate de que `index.php` quede en la raíz o en la subcarpeta deseada.

### 3. Configuración de la base de datos

1. Crea una base de datos en el panel de tu hosting (ej. `miempresa_soporte`).
2. Crea un usuario de base de datos y asigna TODOS los privilegios a la base creada.
3. Abre `phpMyAdmin` y, dentro de la base, importa `database.sql` incluido en este proyecto.

> Nota: El archivo `database.sql` se encuentra en la raíz del repositorio y contiene la estructura y datos iniciales (seeders) — usuarios por defecto y tipos de tickets. Si tu esquema actual no incluye la columna `is_suspended` para controlar suspensiones de cuenta, agrégala con:

```sql
ALTER TABLE users ADD COLUMN is_suspended TINYINT(1) DEFAULT 0;
```

### 4. Conexión del sistema

En el servidor, edita `config/database.php` y actualiza las variables con las credenciales reales:

```php
private $host = "localhost"; // o IP del servidor de BD
private $db_name = "nombre_de_tu_base_de_datos";
private $username = "usuario_de_bd";
private $password = "contraseña_segura";
```

> Nota: en algunos hostings el nombre de la base y el usuario incluyen un prefijo.

### 5. Verificación

Visita `https://www.tudominio.com` (o `https://www.tudominio.com/sistema_tickets` según la ruta). Deberías ver la pantalla de inicio de sesión.

---

## Manual de Uso

### 1. Roles de usuario

- **Administrador (`admin`)**: controla todo el sistema — gestión de usuarios, tipos de tickets y métricas.
- **Usuario / Agente (`user`)**: puede crear tickets, ver pendientes, tomar tickets y finalizar incidencias.

### 2. Flujo de trabajo (ciclo de vida de un ticket)

- **Sin empezar (Rojo):** estado inicial al crear un ticket. Cualquier agente lo ve en la lista.
	- Botón disponible: **Tomar Ticket**.
- **En proceso (Amarillo) — Bloqueo activo:** cuando un agente toma el ticket se le asigna exclusivamente. Si otro intenta tomarlo simultáneamente, el sistema mostrará un error de conflicto.
	- Solo el agente asignado ve el botón **Terminar**.
- **Completado (Verde):** la incidencia está resuelta y queda en el historial.

### 3. Funcionalidades clave

- **Dashboard administrativo:** métricas en tiempo real (total histórico de tickets, pendientes, resueltos y accesos rápidos).
- **Gestión de usuarios (solo admin):** crear/editar/eliminar usuarios, suspender/reactivar y asignar roles.

	- **Suspender / Reactivar usuario**: en la lista de usuarios verás los botones **Suspender**/**Reactivar**. Llaman a la ruta `index.php?action=suspend_user&id={ID}`. La acción está implementada en `UserController::toggleSuspend()` y alterna el campo `is_suspended` en la BD; un administrador no puede suspenderse a sí mismo. Un usuario suspendido no podrá iniciar sesión y verá el mensaje "Tu cuenta ha sido suspendida. Contacta al administrador.".

	- **Eliminar usuario**: en la lista de usuarios verás el botón **Eliminar** que apunta a `index.php?action=delete_user&id={ID}`. El modelo contiene `User::delete($id)` que elimina el registro de la base. La eliminación es irreversible y requiere confirmación y permisos administrativos. Si la ruta `delete_user` no está habilitada en `index.php` o falta un método en `UserController`, debes añadir `UserController::delete()` y un `case 'delete_user'` en `index.php` para activar la funcionalidad desde la UI.
- **Configuración de tipos (solo admin):** definir categorías (ej.: Redes, Hardware, Software) que alimentan el formulario de creación de tickets.

> Seguridad: las contraseñas se almacenan con `password_hash()` (bcrypt). No es posible recuperar contraseñas, solo resetearlas.

---

## Credenciales iniciales (por defecto)

⚠️ Cambia estas contraseñas o crea usuarios nuevos inmediatamente después de la instalación si el sistema estará accesible en Internet.

| Rol   | Usuario  | Contraseña |
|-------|----------|------------|
| Admin | `admin`  | `admin123` |
| User  | `usuario1` | `admin123` |

---

## Solución de problemas comunes

- **Error: "Error de conexión"**
	- Verifica `config/database.php` y confirma host, nombre de BD, usuario y contraseña.
	- Muchos hostings usan prefijos en los nombres de BD/usuario.

- **Página en blanco / Error 500**
	- Confirma la versión de PHP (7.4+).
	- Revisa los logs de errores del servidor (`error_log`).

- **No cargan los estilos (CSS)**
	- El proyecto usa Tailwind vía CDN. Asegura conexión a Internet desde el navegador y que el hosting no bloquee el acceso a la CDN.

---

## Notas técnicas

- Arquitectura basada en **MVC** para facilitar mantenimiento y escalabilidad.
- Prevención de colisiones: el sistema implementa bloqueo/asignación de tickets para evitar trabajo duplicado entre agentes.

---

## Siguientes pasos opcionales

- Añadir un script para crear los usuarios por defecto en la base de datos.
- Añadir instrucciones para desarrollo local (XAMPP) o un archivo `env.example` para gestionar credenciales. 