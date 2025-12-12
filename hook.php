
// removed stray tag
declare(strict_types=1);
/**
 * -------------------------------------------------------------------------
 * Asset-User History plugin for GLPI
 * -------------------------------------------------------------------------
// removed stray tag
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
// removed stray tag
// removed stray tag
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
/**
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 * -------------------------------------------------------------------------
 * @copyright Copyright (C) 2025 by i-Vertix/PGUM.
 * @license   MIT https://opensource.org/license/mit
 * @link      https://github.com/i-Vertix/glpi-assetuserhistory
 * -------------------------------------------------------------------------
 */

use GlpiPlugin\Assetuserhistory\History;
use GlpiPlugin\Assetuserhistory\Config as Plugin_Config;
use GlpiPlugin\Assetuserhistory\Profile as Plugin_Profile;

declare(strict_types=1);

/**
 * Plugin install process
 *
 * @return boolean
 * @noinspection PhpUnused
 */
function plugin_assetuserhistory_install(): bool
{
    global $DB;

    $migration = new Migration(PLUGIN_ASSETUSERHISTORY_VERSION);

    Plugin_Config::install();
    $injections = Plugin_Config::getInjectionItemtypes();
    History::install($migration);
    Plugin_Profile::install($migration, $injections);
    $migration->executeMigration();

    // import
    foreach ($injections as $injection) {
        $isEmpty = (int)($DB->request([
                'COUNT' => 'cnt',
                'FROM' => History::getTable(),
                'WHERE' => [
                    'itemtype' => $injection,
                ]
            ])->current()['cnt'] ?? 0) === 0;
        // import if no history for itemtype
        if ($isEmpty) {
            History::importCurrent($injection);
        }
    }

    return true;
}

/**
 * Plugin uninstall process
 *
 * @return bool
 * @noinspection PhpUnused
 */
function plugin_assetuserhistory_uninstall(): bool
{
    $migration = new Migration(PLUGIN_ASSETUSERHISTORY_VERSION);

    Plugin_Config::uninstall();
    Plugin_Profile::uninstall();
    History::uninstall($migration);

    $migration->executeMigration();

    return true;
}

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
