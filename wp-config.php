<?php
define('WP_AUTO_UPDATE_CORE', false);// Эта настройка определена WordPress Toolkit, и она запрещает автоматические обновления WordPress. Не изменяйте ее во избежание конфликтов с функцией автообновления WordPress Toolkit.
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
 //Added by WP-Cache Manager
define('DB_NAME', 'wordpress');

/** Имя пользователя MySQL */
define('DB_USER', 'wordpress');

/** Пароль к базе данных MySQL */
define('DB_PASSWORD', 'bbd19dd1e8c075bdc85abb78ecbdb3caf97d567280218c12');

/** Имя сервера MySQL */
define('DB_HOST', 'localhost');

/** Кодировка базы данных для создания таблиц. */
define('DB_CHARSET', 'utf8mb4');

/** Схема сопоставления. Не меняйте, если не уверены. */
define('DB_COLLATE', '');

define('WP_SITEURL','https://sushinook.de');

define('WP_HOME','https://sushinook.de');

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '(-}OmO{[/zZN]pHP0lkum_{-0`o7`%R{):h/}NMs7%B_l|6-q.w<O7/w=$9`-(Uy');
define('SECURE_AUTH_KEY',  'k,bzPdKd&`cXgJ/!mh|mm$g9HE2{_Za+AF@P[Wf CdDlWCt:f8LD>Cpm9`<_Dj?j');
define('LOGGED_IN_KEY',    '#ScBSMdMMq)8g2YSYF*ID&GU8TkiIFWHGqa3V=n]u@:NehE#%>_+Z<N8pd7i )AK');
define('NONCE_KEY',        ' u6IsDLXORp`lHXzfR/c~a;<=O:[+j-]&E<FdG0uuLh`haw(vZfY5!aVh/f{KhG|');
define('AUTH_SALT',        '.:D9N&Jt0(.7pwAR[zZ_I`%<J=~CtQ;Qu7aV*.rS+XUeAa^op&nneV^_q %`Eb$~');
define('SECURE_AUTH_SALT', 'SSzoD(K4nSk_xe]7h<Eme11F9mpnHIc6{nXAlySAG D>MRcP$rqjDU#2%SWT|gR$');
define('LOGGED_IN_SALT',   ';{a43`adY3Gdn]4_(zaRK9KnOm*_RH5|p^a;J(4$Aj`E)]_A]Y-WUBnu4akTw72W');
define('NONCE_SALT',       '-P*LUXiC-NOSko(p1rVF%)6zRmv_,q:5y;o3-@1 Njr6.iX&5aCWvzA,t/LgGuB_');

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix  = 'wp_';

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
 /*
ini_set('display_errors','Off');
ini_set('error_reporting', E_ALL );
define('WP_DEBUG', false);
define('WP_DEBUG_DISPLAY', false);*/

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Инициализирует переменные WordPress и подключает файлы. */
require_once(ABSPATH . 'wp-settings.php');




//Мной добавлено дополнительно для создания лога с ошибками 

// Включить рапортирование ошибок для WP
/*define('WP_DEBUG', 0);
// НЕ показывать ошибки в браузере
define('WP_DEBUG_DISPLAY', 1);
// Сказать WP чтобы тот создал файл
define('WP_DEBUG_LOG', 1);
*/

// Отключить это чтобы можно было скачивать новые плагины
//define( 'DISALLOW_FILE_EDIT', true );
//define( 'DISALLOW_FILE_MODS', true );
