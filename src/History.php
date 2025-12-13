<?php
declare(strict_types=1);

namespace GlpiPlugin\Assetuserhistory;

use CommonDBTM;

class History extends CommonDBTM
{
    public static $rightname = 'plugin_assetuserhistory_history';
    public const VIEW_USER_HISTORY = 1;
    public const VIEW_ASSET_HISTORY = 2;

    public static function getTypeName($nb = 0)
    {
        return __('View history', 'assetuserhistory');
    }

    public static function getIcon()
    {
        return 'ti ti-replace-user';
    }

    public static function getTable()
    {
        return 'glpi_plugin_assetuserhistory_history';
    }

    public static function install($migration = null) { return true; }
    public static function uninstall($migration = null) { return true; }

    public function getRights($interface = 'central')
    {
        return [
            self::VIEW_USER_HISTORY => __('For asset', 'assetuserhistory'),
            self::VIEW_ASSET_HISTORY => __('For user', 'assetuserhistory'),
        ];
    }
}
