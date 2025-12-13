<?php
// Fallback stubs for static analysis only
if (!class_exists('CommonDBTM')) {
    class CommonDBTM {
        public static function getType() { return ''; }
        public function getID() { return 0; }
        public function canViewItem() { return true; }
        public static function canView() { return true; }
        public function getName() { return ''; }
        public function find($a) { return []; }
        public function getFromResultSet($a) {}
    }
}
if (!class_exists('User')) {
    class User extends CommonDBTM {
        public static function getTable() { return 'glpi_users'; }
        public static function getFormURLWithID($id) { return ''; }
    }
}
if (!class_exists('Session')) {
    class Session {
        public static function haveRight($a, $b) { return true; }
        public static function addToNavigateListItems($a, $b) {}
    }
}
if (!class_exists('Html')) {
    class Html { public static function convDateTime($a, $b = null, $c = null) { return ''; } }
}
if (!class_exists('Glpi\\Application\\View\\TemplateRenderer')) { class TemplateRenderer { public static function getInstance() { return new self(); } public function display($a, $b) {} } }
if (!function_exists('__')) { function __($a, $b = null) { return $a; } }
if (!function_exists('__s')) { function __s($a, $b = null) { return $a; } }
if (!function_exists('getItemForItemtype')) { function getItemForItemtype($a) { return 'CommonDBTM'; } }
if (!function_exists('getTableForItemType')) { function getTableForItemType($a) { return 'glpi_items'; } }
if (!class_exists('DBConnection')) { class DBConnection { public static function getDefaultCharset() { return 'utf8'; } public static function getDefaultCollation() { return 'utf8_general_ci'; } public static function getDefaultPrimaryKeySignOption() { return 'unsigned'; } } }
if (!class_exists('DBmysql')) { class DBmysql { public function tableExists($a) { return false; } public function doQuery($a) {} public function request($a) { return new ArrayIterator([]); } public function insert($a, $b) {} public function update($a, $b, $c) {} public function fetchAssoc($a) { return []; } public function query($a) { return new ArrayIterator([]); } public static function quoteName($a) { return $a; } public static function quoteValue($a) { return $a; } } }
if (!class_exists('Migration')) { class Migration { public function renameTable($a, $b) {} public function dropTable($a) {} } }
if (!class_exists('QueryExpression')) { class QueryExpression { public function __construct($a, $b = null) {} } }
if (!class_exists('QuerySubQuery')) { class QuerySubQuery { public function __construct($a) {} } }
