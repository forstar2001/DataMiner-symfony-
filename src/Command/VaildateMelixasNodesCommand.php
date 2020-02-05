<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;

use App\Service\WiimaxxManager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class VaildateMelixasNodesCommand extends Command
{
    protected static $defaultName = 'validate:melixas';

    protected $wiimaxxManager;

    public function __construct(string $name = null, WiimaxxManager $wiimaxxManager)
    {
        $this->wiimaxxManager = $wiimaxxManager;

        parent::__construct(
            $name
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->wiimaxxManager->validateMelixasNodes();
    }
}
