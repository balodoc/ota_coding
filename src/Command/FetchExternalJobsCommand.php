<?php

namespace App\Command;

use App\Service\ExternalJobsFetcher;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

#[AsCommand(
    name: 'app:fetch-external-jobs',
    description: 'Fetch and cache external jobs from Personio XML'
)]
class FetchExternalJobsCommand extends Command
{
    public function __construct(private readonly ExternalJobsFetcher $fetcher)
    {
        parent::__construct();
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $url = 'https://mrge-group-gmbh.jobs.personio.de/xml';
        $count = $this->fetcher->fetchAndUpsert($url);
        $output->writeln(sprintf('Upserted %d external jobs.', $count));

        return Command::SUCCESS;
    }
}
