<?php
declare(strict_types=1);

namespace F1Monkey\Codeception\Extension;

use Codeception\Event\TestEvent;
use Codeception\Events;
use Codeception\Exception\ModuleRequireException;
use Codeception\Extension;
use Codeception\Module\Cli;

/**
 * Class SymfonyClearCacheExtension
 *
 * @package F1Monkey\Codeception\Extension
 */
class SymfonyClearCacheExtension extends Extension
{
    public static $events = [
        Events::TEST_BEFORE => 'beforeTest',
    ];

    /** @var array */
    protected $config = [
        'cache_pools' => [],
    ];

    /**
     * @param TestEvent $event
     *
     * @throws ModuleRequireException
     */
    public function beforeTest(TestEvent $event)
    {
        /** @var Cli $cli */
        $cli = $this->getModule('Cli');

        codecept_debug('Clearing cache pools...');

        foreach ($this->config['cache_pools'] as $pool) {
            $cli->runShellCommand(sprintf('bin/console --env=test cache:pool:clear %s', $pool));
        }
    }
}