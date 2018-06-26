<?php

namespace App\Command;

use RenfeBot\Application\Service\Schedule\SearchScheduleRequest;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use RenfeBot\Application\Service\Schedule\SearchSchedule as SearchScheduleService;

final class SearchSchedule extends Command
{
    private $searchSchedule;

    public function __construct(SearchScheduleService $aSearchSchedule)
    {
        $this->searchSchedule = $aSearchSchedule;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Search a schedule');
        $this->addArgument('origin', InputArgument::REQUIRED, 'The origin station');
        $this->addArgument('destination', InputArgument::REQUIRED, 'The destination station');
        $this->addArgument('date', InputArgument::OPTIONAL, 'The date to go from');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $request = new SearchScheduleRequest(
            $input->getArgument('origin'), $input->getArgument('destination'), \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $input->getArgument('date'))
        );

        try
        {
            $this->searchSchedule->__invoke($request);
        }
        catch (\Exception $e)
        {
        }
    }
}
