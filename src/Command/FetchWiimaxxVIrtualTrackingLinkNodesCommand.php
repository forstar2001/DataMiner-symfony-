<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;

use App\Service\WiimaxxManager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FetchWiimaxxVIrtualTrackingLinkNodesCommand extends Command
{
    protected static $defaultName = 'fetch:wiimaxx-virtual-tracking-link';

    protected $wiimaxxManager;

    public function __construct(string $name = null, WiimaxxManager $wiimaxxManager)
    {
        $this->wiimaxxManager = $wiimaxxManager;

        parent::__construct(
            $name
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->wiimaxxManager->fetchWiimaxxVirtualTrackingLinkNodes();
    }
}
