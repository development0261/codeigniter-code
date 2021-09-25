<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['text_title']          =  'صيانة قاعدة البيانات' ;
$lang['text_heading']          =  'صيانة قاعدة البيانات' ;
$lang['text_backup_heading']          =  'قاعدة بيانات النسخ الاحتياطي' ;
$lang['text_browse_heading']          =  'تصفح قاعدة البيانات:٪ s' ;
$lang['text_list']          =  'قائمة صيانة قاعدة البيانات' ;
$lang['text_tab_backup']          =  'دعم' ;
$lang['text_tab_existing_backup']          =  'النسخ الاحتياطية الموجودة' ;
$lang['text_tab_migrations']          =  'الهجرات' ;
$lang['text_tab_create_backup']          =  'إنشاء نسخة احتياطية جديدة' ;
$lang['text_empty']          =  'لا يوجد نسخة احتياطية متاحة.' ;
$lang['text_no_backup']          =  'لا يوجد نسخة احتياطية متاحة.' ;
$lang['text_no_row']          =  'لا توجد صفوف متاحة لهذا الجدول.' ;
$lang['text_installed_version']          =  'النسخة المثبتة' ;
$lang['text_latest_version']          =  'أحدث إصدار متاح' ;
$lang['text_select_version']          =  'حدد ملف الإصدار' ;
$lang['text_zip']          =  'بريدي' ;
$lang['text_gzip']          =  'gzip' ;
$lang['text_drop_tables']          =  'Add DROP TABLE statement:' ;
$lang['text_add_inserts']          =  'Add INSERT statement for data dump:' ;
$lang['button_backup']          =  'دعم' ;
$lang['button_migrate']          =  'يهاجر' ;
$lang['button_modules']          =  'وحدات' ;
$lang['column_select_tables']          =  'حدد الجداول للنسخ الاحتياطي' ;
$lang['column_records']          =  '# السجلات' ;
$lang['column_data_size']          =  'حجم البيانات' ;
$lang['column_index_size']          =  'حجم الفهرس' ;
$lang['column_data_free']          =  'البيانات الحره' ;
$lang['column_engine']          =  'محرك' ;
$lang['column_name']          =  'اسم' ;
$lang['column_download']          =  'تحميل' ;
$lang['column_restore']          =  'استعادة' ;
$lang['column_delete']          =  'حذف' ;
$lang['label_file_name']          =  'اسم الملف' ;
$lang['label_drop_tables']          =  'إسقاط الجداول' ;
$lang['label_add_inserts']          =  'ادخال البيانات' ;
$lang['label_compression']          =  'تنسيق الضغط' ;
$lang['label_backup_table']          =  'جداول النسخ الاحتياطيه' ;
$lang['label_migrate_version']          =  'ترحيل إلى الإصدار' ;
$lang['alert_info_memory_limit']          =  '<p>Note: Due to the limited execution time and memory available to PHP, backing up very large databases may not be possible.If your database is very large you might need to backup directly from your SQL server via the command line,or have your server admin do it for you if you do not have root privileges.</p>' ;
$lang['alert_warning_migration']          =  "<b>BE CAREFUL!</b> Do not migrate unless you know what you're doing." ;
$lang['alert_warning_maintenance']          =  "Your site is live you can't %s the database, please enable maintenance mode. Make sure you <b>BACKUP</b> your database." ;
$lang['help_compression']          =  'The Restore option is only capable of reading un-compressed files. Gzip or Zip compression is good if you just want a backup to download and store on your computer.' ;

/* End of file maintenance_lang.php */
/* Location: ./admin/language/english/maintenance_lang.php */