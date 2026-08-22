# Proyecto Ediciones Fares

Proyecto completo basado en el ejemplo del libro de Diseño Web.

## Archivos principales

- `frmcliente.php`: formulario de cliente con Bootstrap 4.
- `guardarcli.php`: recibe datos del formulario y guarda.
- `fclases.php`: clase `datospersona`, constructor, getters y setters.
- `conexionf2.php`: clase de conexión PDO.
- `manipularcli.php`: clase `modificarcliente` que hereda de `datospersona`.
- `prueba.php`: ejemplo del método `minombre()`.
- `css/style.css`: estilos separados.
- `sql/database.sql`: base de datos y tabla.

## Instalación en XAMPP

1. Copiar la carpeta en:

   `C:\xampp\htdocs\Ediciones_Fares_Completo_Libro`

2. Abrir phpMyAdmin.

3. Importar el archivo:

   `sql/database.sql`

4. Abrir en el navegador:

   `http://localhost/Ediciones_Fares_Completo_Libro/frmcliente.php`

## Base de datos

Nombre:

`sistema_fares`

Tabla:

`clientes`
