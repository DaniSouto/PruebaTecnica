<?php

namespace App\Command;

use App\Entity\Book;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use App\Repository\EditorialRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateDummyDataCommand extends Command
{
    protected static $defaultName = 'app:create-dummy-data';
    private AuthorRepository $authorRepository;
    private EditorialRepository $editorialRepository;
    private CategoryRepository $categoryRepository;

    public function __construct( AuthorRepository $authorRepository, EditorialRepository $editorialRepository, CategoryRepository $categoryRepository)
    {
        parent::__construct();
        $this->authorRepository     = $authorRepository;
        $this->editorialRepository  = $editorialRepository;
        $this->categoryRepository   = $categoryRepository;
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Feed database with dummy data.')
            ->setHelp('This command feed database with dummy data.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $this->editorialRepository  ->createDummyData();
        $this->authorRepository     ->createDummyData();
        $this->categoryRepository   ->createDummyData();

        $output->writeln('Dummy data created!');

        return Command::SUCCESS;
    }

}