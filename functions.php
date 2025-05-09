<?php
/**
 * Twenty Twenty-Five functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

// Adds theme support for post formats.
if ( ! function_exists( 'twentytwentyfive_post_format_setup' ) ) :
	/**
	 * Adds theme support for post formats.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_post_format_setup() {
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );
	}
endif;
add_action( 'after_setup_theme', 'twentytwentyfive_post_format_setup' );

// Enqueues editor-style.css in the editors.
if ( ! function_exists( 'twentytwentyfive_editor_style' ) ) :
	/**
	 * Enqueues editor-style.css in the editors.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_editor_style() {
		add_editor_style( get_parent_theme_file_uri( 'assets/css/editor-style.css' ) );
	}
endif;
add_action( 'after_setup_theme', 'twentytwentyfive_editor_style' );

// Enqueues style.css on the front.
if ( ! function_exists( 'twentytwentyfive_enqueue_styles' ) ) :
	/**
	 * Enqueues style.css on the front.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_enqueue_styles() {
		wp_enqueue_style(
			'twentytwentyfive-style',
			get_parent_theme_file_uri( 'style.css' ),
			array(),
			wp_get_theme()->get( 'Version' )
		);
	}
endif;
add_action( 'wp_enqueue_scripts', 'twentytwentyfive_enqueue_styles' );

// Registers custom block styles.
if ( ! function_exists( 'twentytwentyfive_block_styles' ) ) :
	/**
	 * Registers custom block styles.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_block_styles() {
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __( 'Checkmark', 'twentytwentyfive' ),
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_block_styles' );

// Registers pattern categories.
if ( ! function_exists( 'twentytwentyfive_pattern_categories' ) ) :
	/**
	 * Registers pattern categories.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_pattern_categories() {

		register_block_pattern_category(
			'twentytwentyfive_page',
			array(
				'label'       => __( 'Pages', 'twentytwentyfive' ),
				'description' => __( 'A collection of full page layouts.', 'twentytwentyfive' ),
			)
		);

		register_block_pattern_category(
			'twentytwentyfive_post-format',
			array(
				'label'       => __( 'Post formats', 'twentytwentyfive' ),
				'description' => __( 'A collection of post format patterns.', 'twentytwentyfive' ),
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_pattern_categories' );

// Registers block binding sources.
if ( ! function_exists( 'twentytwentyfive_register_block_bindings' ) ) :
	/**
	 * Registers the post format block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_register_block_bindings() {
		register_block_bindings_source(
			'twentytwentyfive/format',
			array(
				'label'              => _x( 'Post format name', 'Label for the block binding placeholder in the editor', 'twentytwentyfive' ),
				'get_value_callback' => 'twentytwentyfive_format_binding',
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_register_block_bindings' );

// Registers block binding callback function for the post format name.
if ( ! function_exists( 'twentytwentyfive_format_binding' ) ) :
	/**
	 * Callback function for the post format name block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return string|void Post format name, or nothing if the format is 'standard'.
	 */
	function twentytwentyfive_format_binding() {
		$post_format_slug = get_post_format();

		if ( $post_format_slug && 'standard' !== $post_format_slug ) {
			return get_post_format_string( $post_format_slug );
		}
	}
endif;
// Crear tabla en base de datos
function crear_tabla_usuarios() {
    global $wpdb;
    $wpdb->query("USE usuarios");

    $tabla = 'usuarios'; // Sin prefijo
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $tabla (
        id INT NOT NULL AUTO_INCREMENT,
        nombre VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        edad INT NOT NULL,
        institucion VARCHAR(100) NOT NULL,
        proyecto VARCHAR(100) NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
add_action('after_setup_theme', 'crear_tabla_usuarios');

// Shortcode del formulario
function formulario_registro_usuario() {
    ob_start();

    $mensaje = '';
    $tipo_mensaje = '';
    $nombre = $email = $edad = $institucion = $proyecto = '';

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['registrar_usuario'])) {
        $nombre = sanitize_text_field($_POST['nombre']);
        $email = sanitize_email($_POST['email']);
        $edad = intval($_POST['edad']);
        $institucion = sanitize_text_field($_POST['institucion']);
        $proyecto = sanitize_text_field($_POST['proyecto']);

        if (!preg_match("/^[a-zA-Z\s]+$/", $nombre)) {
            $mensaje = "El nombre no puede contener números ni caracteres especiales.";
            $tipo_mensaje = "error";
        } elseif ($edad > 99 || $edad < 1) {
            $mensaje = "La edad debe ser entre 1 y 99.";
            $tipo_mensaje = "error";
        } else {
            global $wpdb;
            $wpdb->query("USE usuarios");
            $tabla = 'usuarios';
            $wpdb->insert($tabla, compact('nombre', 'email', 'edad', 'institucion', 'proyecto'));

            $mensaje = "Usuario registrado correctamente.";
            $tipo_mensaje = "exito";

            // Limpiar campos si el registro fue exitoso
            $nombre = $email = $edad = $institucion = $proyecto = '';
        }
    }

    // Estilos
    ?>
    <style>
    .form-container {
        max-width: 500px;
        margin: 40px auto;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 0 15px rgba(0,0,0,0.15);
        font-family: 'Segoe UI', sans-serif;
        background: #fff;
    }

    .form-container h2 {
        text-align: center;
        margin-bottom: 25px;
    }

    .form-container input[type="text"],
    .form-container input[type="email"],
    .form-container input[type="number"] {
        width: 95%;
        padding: 10px 12px;
        margin: 8px 0;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 15px;
    }

    .form-container input[type="submit"] {
        background-color: #0073aa;
        color: white;
        border: none;
        padding: 12px;
        width: 100%;
        border-radius: 6px;
        font-size: 16px;
        cursor: pointer;
    }

    .form-container input[type="submit"]:hover {
        background-color: #005a8c;
    }

    .alert {
        max-width: 500px;
        margin: 20px auto;
        padding: 15px 20px;
        border-radius: 6px;
        font-size: 15px;
        position: relative;
        animation: fadein 0.4s ease-in-out;
    }

    .alert.exito {
        background-color: #d1f5d3;
        border: 1px solid #38b000;
        color: #206c00;
    }

    .alert.error {
        background-color: #fddede;
        border: 1px solid #d00000;
        color: #8b0000;
    }

    .alert .close {
        position: absolute;
        right: 12px;
        top: 10px;
        font-size: 18px;
        cursor: pointer;
    }

    @keyframes fadein {
        from {opacity: 0;}
        to {opacity: 1;}
    }
    </style>

    <?php if (!empty($mensaje)) : ?>
        <div class="alert <?php echo esc_attr($tipo_mensaje); ?>" id="mensaje-alerta">
            <span class="close" onclick="this.parentElement.style.display='none';">✖</span>
            <?php echo esc_html($mensaje); ?>
        </div>
        <script>
        setTimeout(function() {
            var alerta = document.getElementById("mensaje-alerta");
            if (alerta) alerta.style.display = 'none';
        }, 5000);
        </script>
    <?php endif; ?>

    <form class="form-container" method="post">
        <h2>Registro de Usuario</h2>
        <input type="text" name="nombre" placeholder="Nombre completo" value="<?php echo esc_attr($nombre); ?>" required>
        <input type="email" name="email" placeholder="Correo electrónico" value="<?php echo esc_attr($email); ?>" required>
        <input type="number" name="edad" placeholder="Edad" max="99" value="<?php echo esc_attr($edad); ?>" required>
        <input type="text" name="institucion" placeholder="Institución" value="<?php echo esc_attr($institucion); ?>" required>
        <input type="text" name="proyecto" placeholder="Proyecto" value="<?php echo esc_attr($proyecto); ?>" required>
        <input type="submit" name="registrar_usuario" value="Registrar">
    </form>
    <?php

    return ob_get_clean();
}
add_shortcode('formulario_registro', 'formulario_registro_usuario');

// Shortcode para mostrar los usuarios registrados
function mostrar_usuarios_shortcode() {
    global $wpdb;

    // Usar la base de datos "usuarios"
    $wpdb->query("USE usuarios");

    // Eliminar usuario si se envió el formulario
    if (isset($_POST['eliminar_usuario_id'])) {
        $id = intval($_POST['eliminar_usuario_id']);
        $wpdb->delete('usuarios', ['id' => $id]);
        echo '<div class="alerta-exito">Usuario eliminado correctamente. <span class="cerrar" onclick="this.parentElement.style.display=\'none\'">&times;</span></div>';
    }

    $usuarios = $wpdb->get_results("SELECT * FROM usuarios");

    ob_start();
    ?>

    <style>
        .tabla-usuarios {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .tabla-usuarios th,
        .tabla-usuarios td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        .tabla-usuarios th {
            background-color:rgb(64, 158, 62);
            
        }

        .btn-eliminar {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-eliminar:hover {
            background-color: #c0392b;
        }

        .alerta-exito {
            margin-top: 20px;
            background-color: #d4edda;
            color: #155724;
            padding: 15px 20px;
            border-left: 6px solid #28a745;
            position: relative;
            border-radius: 4px;
            animation: fadeOut 10s forwards;
        }

        .cerrar {
            position: absolute;
            right: 15px;
            top: 10px;
            font-size: 20px;
            cursor: pointer;
        }

        @keyframes fadeOut {
            0% {opacity: 1;}
            90% {opacity: 1;}
            100% {opacity: 0; display: none;}
        }
    </style>

    <h2>Usuarios Registrados</h2>

    <table class="tabla-usuarios">
        <tr>
            <th>Nombre</th>
            <th>Email</th>
            <th>Edad</th>
            <th>Institución</th>
            <th>Proyecto</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?php echo esc_html($usuario->nombre); ?></td>
                <td><?php echo esc_html($usuario->email); ?></td>
                <td><?php echo esc_html($usuario->edad); ?></td>
                <td><?php echo esc_html($usuario->institucion); ?></td>
                <td><?php echo esc_html($usuario->proyecto); ?></td>
                <td>
                    <form method="post" onsubmit="return confirm('¿Estás seguro de que querés eliminar este usuario?');">
                        <input type="hidden" name="eliminar_usuario_id" value="<?php echo $usuario->id; ?>">
                        <button type="submit" class="btn-eliminar">Eliminar</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <?php
    return ob_get_clean();
}
add_shortcode('mostrar_usuarios', 'mostrar_usuarios_shortcode');

