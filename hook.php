// Fallback stubs for static analysis (do not include in production)
if (!class_exists('CommonDBTM')) { class CommonDBTM { public static function getType() { return ''; } public function getID() { return 0; } } }
if (!class_exists('User')) { class User { public function getID() { return 0; } } }
namespace GlpiPlugin\Assetuserhistory;
if (!class_exists('History')) { class History { public static function getTable() { return ''; } public function deleteByCriteria($a, $b) {} } }
namespace {
<?php
/**
 * -------------------------------------------------------------------------
 * Asset-User History plugin for GLPI
 * -------------------------------------------------------------------------
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * -------------------------------------------------------------------------
 * @copyright Copyright (C) 2025 by i-Vertix/PGUM.
 * @license   MIT https://opensource.org/license/mit
 * @link      https://github.com/i-Vertix/glpi-assetuserhistory
 * -------------------------------------------------------------------------
 */



use GlpiPlugin\Assetuserhistory\History;
use GlpiPlugin\Assetuserhistory\Config as Plugin_Config;
use GlpiPlugin\Assetuserhistory\Profile as Plugin_Profile;

/**
 * Delete history when an asset gets deleted
 *
 * @param CommonDBTM $item
 * @return void
 * @noinspection PhpUnused
 */
function plugin_assetuserhistory_item_purge_asset(CommonDBTM $item): void
{
    $history = new History();
    $history->deleteByCriteria([
        'itemtype' => $item::getType(),
        'items_id' => $item->getID(),
    ], true);
}

/**
 * Keep users with id 0 instead of deleting them
 *
 * @param User $item
 * @return void
 * @noinspection PhpUnused
 */
function plugin_assetuserhistory_item_purge_user(User $item): void
{
    global $DB;

    $DB->update(
        History::getTable(),
        [
            'users_id' => 0,
        ],
        [
            'WHERE' => [
                'users_id' => $item->getID(),
            ]
        ]
    );
}
