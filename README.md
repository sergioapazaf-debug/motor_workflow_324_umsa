# Motor Workflow 324 UMSA

Proyecto académico de la materia **INF-324 Programación Multimedial**, orientado al aprendizaje e implementación de workflows para la digitalización de trámites universitarios.

## Descripción

El proyecto implementa un motor de workflows que permite modelar procesos mediante roles, procesos, transiciones y estados. Como ejemplo de aplicación se incluyen flujos para la gestión de trámites universitarios.

## Tecnologías utilizadas

- PHP
- MariaDB
- Apache
- HTML
- CSS
- Bootstrap
- GitHub

## Requisitos

- Apache
- PHP
- MariaDB

## Instalación

### 1. Clonar el repositorio

```bash
git clone git@github.com:sergioapazaf-debug/motor_workflow_324_umsa.git
```

### 2. Copiar el proyecto

Copiar la carpeta del proyecto al directorio de publicación de Apache.

### 3. Importar las bases de datos

Importar los siguientes archivos SQL incluidos en el proyecto:

- `workflow_324.sql`
- `usuario_db_324.sql`

El archivo `workflow_324.sql` contiene la estructura y datos iniciales de la base de datos `workflow2`.

El archivo `usuario_db_324.sql` contiene la estructura y datos iniciales de la base de datos `usuario_db`.

### 4. Configurar la conexión

Los archivos de configuración se encuentran en:

```text
config/Database.php
config/UserDatabase.php
```

Por defecto utilizan:

```text
Host: localhost
Usuario: sergio
Contraseña: 123456
```

Modificar estos valores según la configuración local de MariaDB.

### 5. Ejecutar el proyecto

Iniciar Apache y MariaDB.

Abrir el proyecto desde el navegador utilizando la ruta configurada en el servidor web.

## Usuarios de prueba

Todos los usuarios incluidos en la base de datos utilizan la contraseña:

```text
123
```

| Usuario | Rol |
|----------|----------|
| sergio | alumno |
| luis | alumno |
| ana | kardex |
| mario | kardex |
| leo | tecnico |
| juan | tecnico |
| carlos | director |
| recepcionista1 | recepcionista |
| medico1 | medico |
| farmaceutico1 | farmaceutico |
| cajero1 | cajero |

## Creación de usuarios

El sistema no incluye una interfaz para registrar usuarios desde el frontend.

Para crear nuevos usuarios se debe:

1. Insertar el usuario en la tabla `usuarios`.
2. Generar el hash de la contraseña utilizando el archivo:

```text
public/hash.php
```

3. Ejecutar el archivo y copiar el valor generado por `password_hash()`.
4. Actualizar el campo `password` del usuario con el hash obtenido.

Ejemplo:

```sql
INSERT INTO usuarios(usuario, password, rol)
VALUES ('nuevo_usuario', '', 'alumno');
```

Posteriormente actualizar la contraseña utilizando el hash generado:

```sql
UPDATE usuarios
SET password = 'HASH_GENERADO'
WHERE usuario = 'nuevo_usuario';
```

## Funcionalidades

- Gestión de workflows.
- Gestión de procesos.
- Gestión de transiciones.
- Control de acceso basado en roles.
- Seguimiento de trámites.
- Historial de ejecución.
- Gestión de estados.
- Simulación de trámites universitarios.

## Autor

Proyecto académico desarrollado para la materia INF-324 Programación Multimedial.