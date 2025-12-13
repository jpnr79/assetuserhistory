<?php
// Asset-User History plugin hooks (cleaned for static analysis/runtime)

if (!defined('GLPI_ROOT')) {
    die("Sorry. You can't access directly to this file");
}

use GlpiPlugin\Assetuserhistory\History;

/**
 * Delete history when an asset gets deleted
 * @param CommonDBTM $item
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
 * @param User $item
 */
function plugin_assetuserhistory_item_purge_user(User $item): void
{
    global $DB;

    $DB->update(
        History::getTable(),
        [ 'users_id' => 0 ],
        [ 'WHERE' => [ 'users_id' => $item->getID() ] ]
    );
}
