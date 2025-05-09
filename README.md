# 🛠️ Guía Paso a Paso – Instalación de WordPress

## 🔶 1. Ingresar a WordPress.org y descargar WordPress
Entrar al sitio [https://wordpress.org](https://wordpress.org).

Descargar la última versión de WordPress desde allí.

## 🔶 2. Copiar y extraer WordPress en `htdocs`
Una vez descargado el archivo `.zip`, descomprimirlo.

Dentro aparecerá una carpeta llamada por ejemplo `wordpress-6.2` (puede variar según versión).

Entrar en esa carpeta: vas a encontrar otra carpeta llamada `wordpress`.

Copiar esa carpeta `wordpress` y pegarla dentro de `C:\xampp\htdocs`.

Luego podés borrar la carpeta `wordpress-6.2`.

## 🔶 3. Iniciar XAMPP y acceder a phpMyAdmin
Abrir XAMPP.

Iniciar los módulos:
- ✅ Apache
- ✅ MySQL

Hacer clic en **“Admin”** de MySQL para abrir **phpMyAdmin**.

## 🔶 4. Crear la base de datos
En phpMyAdmin, hacer clic en la pestaña **“Bases de datos”**.

Crear una base de datos nueva con el nombre: `wordpress`.

## 🔶 5. Ir a `localhost/wordpress` en el navegador
En el navegador, ir a: [http://localhost/wordpress](http://localhost/wordpress)

Seleccionar el idioma (por ejemplo: Español de Argentina).

## 🔧 6. Configurar conexión a la base de datos
Aparecerá un formulario como este:

![image](https://github.com/user-attachments/assets/9200edb3-9be4-447b-b0e1-57a87f7d352c)

Debés completarlo así:

- **Nombre de la base de datos:** `wordpress`
- **Nombre de usuario:** `root`
- **Contraseña:** *(dejar en blanco)*
- **Servidor de la base de datos:** `localhost`
- **Prefijo de tabla:** `wp_` *(podés dejarlo por defecto)*

En algunos casos puede dar error, así que hay que hacer lo siguiente:

## 🔧 7. Editar `wp-config-sample.php`
Ir a la carpeta `C:\xampp\htdocs\wordpress`.

Abrir el archivo `wp-config-sample.php` en Visual Studio Code.

Buscá las líneas donde se define la conexión a la base de datos y modificá así:

```php
define( 'DB_NAME', 'wordpress' );
define( 'DB_USER', 'root' );
define( 'DB_PASSWORD', '' );
```

Guardar el archivo y renombrarlo como wp-config.php.

🔶 8. Finalizar la instalación desde el navegador  
Volver a: http://localhost/wordpress y veras que se habra arreglado el error, por lo que te aparecera un formulario.
 
Completar el formulario con:

- **Título del sitio:** WordPress de prueba  
- **Nombre de usuario:** wordpress_admin  
- **Contraseña:** ya viene generada, hay que copiarla para iniciar sesión después  
- **Tu correo electrónico:** (ingresar un correo válido)  

Luego, hacer clic en **Instalar WordPress**.

Una vez instalada, iniciar sesión en el registro que te aparece usando el nombre de usuario y la contraseña copiada.

¡Listo! WordPress ya está instalado y funcionando
