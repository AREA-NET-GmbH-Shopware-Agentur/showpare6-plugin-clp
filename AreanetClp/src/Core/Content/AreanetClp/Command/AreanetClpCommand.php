<?php declare(strict_types=1);

namespace AreanetClp\Core\Content\AreanetClp\Command;

use AreanetClp\Core\Content\AreanetClp\Service\AreanetClpImportService;
use Symfony\Component\Console\{Input\InputInterface, Output\OutputInterface};
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'areanet:clp:install')]
class AreanetClpCommand extends Command {

    private $areanetClpImportService;


    public function __construct(AreanetClpImportService $areanetClpImportService)
    {
        $this->areanetClpImportService = $areanetClpImportService;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Install CLP-Plugin data.');
        $this->setHelp('This command helps manipulating the database with CLP data.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->areanetClpImportService->import();

        return 0;
    }
}
