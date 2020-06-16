<?php
declare(strict_types=1);

namespace F1Monkey\Codeception\Extension;

use Codeception\Event\TestEvent;
use Codeception\Events;
use Codeception\Exception\ModuleRequireException;
use Codeception\Extension;
use Codeception\Module\Cli;
use Codeception\Module\Symfony;

/**
 * Class DoctrineDatabaseInitializeExtension
 *
 * @package F1Monkey\Codeception\Extension
 */
class DoctrineDatabaseInitializeExtension extends Extension
{
    public static $events = [
        Events::TEST_BEFORE => 'beforeTest',
    ];

    /** @var array */
    protected $config = [
        'pg_uuid_extension' => false,
    ];

    /**
     * @param TestEvent $event
     *
     * @throws ModuleRequireException
     */
    public function beforeTest(TestEvent $event)
    {
        /** @var Symfony $symfony */
        $symfony = $this->getModule('Symfony');
        /** @var Cli $cli */
        $cli = $this->getModule('Cli');

        $env = $symfony->_getContainer()->getParameter('kernel.environment');

        codecept_debug('Clearing database...');
        $cli->runShellCommand(
            sprintf(
                'bin/console doctrine:schema:drop --env=%s --full-database --force',
                $env
            )
        );
        $cli->seeResultCodeIs(0);

        codecept_debug('Creating database schema...');
        $cli->runShellCommand(
            sprintf(
                'bin/console doctrine:schema:update --env=%s --force',
                $env
            )
        );
        $cli->seeResultCodeIs(0);

        $this->loadPgUuidExtension($cli, $env);
    }

    /**
     * @param Cli    $cli
     * @param string $env
     */
    protected function loadPgUuidExtension(Cli $cli, string $env)
    {
        if ($this->config['pg_uuid_extension']) {
            $cli->runShellCommand(
                sprintf(
                    'bin/console doctrine:query:sql --env=%s "CREATE EXTENSION IF NOT EXISTS \"uuid-ossp\""',
                    $env
                )
            );
            $cli->seeResultCodeIs(0);
        }
    }
}