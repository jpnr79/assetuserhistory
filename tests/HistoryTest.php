<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use GlpiPlugin\Assetuserhistory\History;

class HistoryTest extends TestCase
{
    public function testGetTypeName(): void
    {
        $this->assertSame('View history', History::getTypeName(1));
    }

    public function testGetIcon(): void
    {
        $this->assertSame('ti ti-replace-user', History::getIcon());
    }

    public function testGetRights(): void
    {
        $history = new History();
        $rights = $history->getRights();
        $this->assertArrayHasKey(History::VIEW_USER_HISTORY, $rights);
        $this->assertArrayHasKey(History::VIEW_ASSET_HISTORY, $rights);
    }
}
