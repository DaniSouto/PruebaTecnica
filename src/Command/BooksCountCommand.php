<?php

namespace App\Command;

use App\Entity\Book;
use App\Repository\BookRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BooksCountCommand extends Command
{
    protected static $defaultName = 'app:books-count';
    private BookRepository $bookRepository;

    public function __construct( BookRepository $bookRepository)
    {
        parent::__construct();
        $this->bookRepository = $bookRepository;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Count the books.')
            ->setHelp('This command returns the number of books.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $count = $this->bookRepository->countBooks();

        $output->writeln(
            'There are '.$count.' books.'
        );

        return Command::SUCCESS;
    }

}