<?php
declare(strict_types=1);

namespace Codilar\CustomCron\Cron;

use Psr\Log\LoggerInterface;

class Example
{
    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function execute()
    {
        $this->logger->info('starting cron job successfully!!');
        sleep(2);
        $this->logger->info('Cron job stopped successfully!!');
    }
}
