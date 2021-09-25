<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['text_title'] = 'Mantenimiento de la base de datos' ;
$lang['text_heading'] = 'Mantenimiento de la base de datos' ;
$lang['text_backup_heading'] = 'Copia de seguridad de la base de datos' ;
$lang['text_browse_heading'] = 'Navegación de la base de datos: %s' ;
$lang['text_list'] = 'Lista de actualización de la base de datos' ;
$lang['text_tab_backup'] = 'Copia de seguridad' ;
$lang['text_tab_existing_backup'] = 'Copias de seguridad existentes' ;
$lang['text_tab_migrations'] = 'migraciones' ;
$lang['text_tab_create_backup'] = 'Crear una nueva copia de seguridad' ;
$lang['text_empty'] = 'No hay copias de seguridad disponibles' ;
$lang['text_no_backup'] = 'No hay copias de seguridad disponibles' ;
$lang['text_no_row'] = 'No hay filas disponibles para esta mesa.' ;
$lang['text_installed_version'] = 'Versión instalada' ;
$lang['text_latest_version'] = 'Última versión disponible' ;
$lang['text_select_version'] = 'Seleccione la versión del archivo' ;
$lang['text_zip'] = 'Código Postal' ;
$lang['text_gzip'] = 'gzip' ;
$lang['text_drop_tables'] = 'Añada la declaración DROP TABLE:' ;
$lang['text_add_inserts'] = 'Añada la instrucción INSERT para el dump de datos:' ;
$lang['button_backup'] = 'Apoyo' ;
$lang['button_migrate'] = 'Migrar' ;
$lang['button_modules'] = 'módulos' ;
$lang['column_select_tables'] = 'Seleccione las tablas a respaldar' ;
$lang['column_records'] = '# Registros' ;
$lang['column_data_size'] = 'Tamaño de los datos' ;
$lang['column_index_size'] = 'Tamaño del índice' ;
$lang['column_data_free'] = 'Sin datos' ;
$lang['column_engine'] = 'Motor' ;
$lang['column_name'] = 'Nombre' ;
$lang['column_download'] = 'Descargar' ;
$lang['column_restore'] = 'Restaurar' ;
$lang['column_delete'] = 'Eliminar' ;
$lang['label_file_name'] = 'Nombre del archivo' ;
$lang['label_drop_tables'] = 'Tablas desplegables' ;
$lang['label_add_inserts'] = 'Insertar datos' ;
$lang['label_compression'] = 'Formato de compresión' ;
$lang['label_backup_table'] = 'Tablas de respaldo' ;
$lang['label_migrate_version'] = 'Migrar a la verisón' ;
$lang['alert_info_memory_limit'] = '<p>Nota: Debido al tiempo limitado de ejecución y la memoria disponible para PHP, el respaldo de bases de datos muy grandes puede no ser posible.<p> Si su base de datos es muy grande puede necesitar respaldar directamente desde su servidor SQL a través de la línea de comandos, o hacer que el administrador de su servidor lo haga por usted si no tiene privilegios de root.</p>' ;
$lang['alert_warning_migration'] = '<b> TENGA CUIDADO!</b> No migre a menos que sepa lo que está haciendo.' ;
$lang['alert_warning_maintenance'] = 'Su sitio está en vivo no puede %s la base de datos, por favor habilite el modo de mantenimiento. Asegúrese de que <b>BACKUP</b> su base de datos.' ;
$lang['help_compression'] = 'La opción de restauración sólo es capaz de leer archivos no comprimidos. La compresión Gzip o Zip es buena si sólo desea una copia de seguridad para descargar y almacenar en su ordenador.' ;

/* End of file maintenance_lang.php */
/* Location: ./admin/language/english/maintenance_lang.php */