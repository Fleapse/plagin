<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'plagin' );

/** Имя пользователя MySQL */
define( 'DB_USER', 'root' );

/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', '' );

/** Имя сервера MySQL */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'D]g/AkF/xqK(#kqh6fjg{_+AHwOsZRtNjjh9KyD=i[%9j&cj?9FpquW9+:usq,yV' );
define( 'SECURE_AUTH_KEY',  'cEWOxX2@]M_f|e`;Jl~g,@XqkwZ):ATfnJw$_WW5Avet$%`<=*-_^:z8#2d`iOr/' );
define( 'LOGGED_IN_KEY',    '9Ttg`NAZ+;3G?qyPf(d9gIjK=%3Rag9st(~B+F+qK&Fj#ZGR5HLSx+jvf^t{j7L-' );
define( 'NONCE_KEY',        '@A1GPP=!o]U>dw:KX@1kOub<~6im1/+|KnYErT|V@*psaz/P7.awI]sDR!k8C-I:' );
define( 'AUTH_SALT',        'BVlkCshrLu&d3L#O}z(q%@{3pX&A{d]^h(A!l+71xcz,zp5nAwJMf>^4[I*r$O^3' );
define( 'SECURE_AUTH_SALT', '#Zz)Y/MJdR%}yY{DR#|b_`Z%b@6rwD~l+F4W[Q%PVs|[ncO^z[!zCY4!w3ODA.)F' );
define( 'LOGGED_IN_SALT',   ',O{jLQ5+}FzzvzSqUyo~cLGmQ^;,^Mvx%/4qUrDv=_[1T#_)-RPc+kU0{JcqTC[j' );
define( 'NONCE_SALT',       'Z?Q&.9Bv[G/y=,GCPJODP!6$Nhb 9@1J?uO%8-|X:a1%3Q&xM*d0N=#67n *Ku8%' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once( ABSPATH . 'wp-settings.php' );
