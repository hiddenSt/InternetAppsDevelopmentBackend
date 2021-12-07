<?php

namespace App\Command;

use App\Controller\Notification;
use Doctrine\ORM\EntityManagerInterface;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Ratchet\WebSocket\WsServer;


class WebSocketServerCommand extends Command
{
    protected static $defaultName = 'web-socket-server';
    protected static $defaultDescription = 'Add a short description for your command';
	private $manager;

	public function __construct(EntityManagerInterface $manager)
	{
		parent::__construct();
		$this->manager = $manager;
	}

	protected function configure(): void
    {
        $this
            ->addArgument('port', InputArgument::REQUIRED, 'Port on witch')
            // ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
		$server = IoServer::factory(new HttpServer(
			new WsServer(
				new Notification($this->manager)
			)
		), $input->getArgument('port'));

		$output->writeln("WebSocketServerIsStarted");
		$server->run();

        return Command::SUCCESS;
    }
}
