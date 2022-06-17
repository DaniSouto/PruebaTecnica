<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220310111731 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, priority INT DEFAULT 0 NOT NULL, deletedAt DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, author_id INT DEFAULT NULL, editorial_id INT DEFAULT NULL, category_id INT DEFAULT NULL, title VARCHAR(100) NOT NULL, description LONGTEXT DEFAULT NULL, priority INT DEFAULT 0 NOT NULL, stock INT NOT NULL, deletedAt DATETIME DEFAULT NULL, INDEX IDX_CBE5A331F675F31B (author_id), INDEX IDX_CBE5A331BAF1A24D (editorial_id), INDEX IDX_CBE5A33112469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, priority INT DEFAULT 0 NOT NULL, deletedAt DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE editorial (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, priority INT DEFAULT 0 NOT NULL, deletedAt DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331F675F31B FOREIGN KEY (author_id) REFERENCES author (id)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331BAF1A24D FOREIGN KEY (editorial_id) REFERENCES editorial (id)');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A33112469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');

        $this->addSql('INSERT INTO author (id, name, priority) VALUES (1, \'Patrick Rothfuss\', 72), (2, \'Brandon Sanderson\', 64), (3, \'Isaac Asimov\', 83)');
        $this->addSql('INSERT INTO editorial (id, name, priority) VALUES (1, \'Mintorauro\', 93), (2, \'Gigamesh\', 54), (3, \'Babylon\', 72), (4, \'Nova\', 62)');
        $this->addSql('INSERT INTO category (id, name, priority) VALUES (1, \'Fantasía\', 72), (2, \'Ciencia ficción\', 71), (3, \'Aventura\', 64), (4, \'Histórica\', 53)');
        $this->addSql('INSERT INTO book (author_id, editorial_id, category_id, title, description, priority, stock) VALUES 
            (1, 1, 1, \'El nombre del viento\', \'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nec volutpat orci. Nam a tincidunt elit. Vivamus interdum justo ut placerat pulvinar. Vivamus venenatis diam eget congue interdum. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.\', 92, 50),
            (1, 1, 1, \'El temor de un hombre sabio\', \'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nec volutpat orci. Nam a tincidunt elit. Vivamus interdum justo ut placerat pulvinar. Vivamus venenatis diam eget congue interdum. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.\', 75, 47),
            (3, 2, 2, \'La Fundación\', \'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nec volutpat orci. Nam a tincidunt elit. Vivamus interdum justo ut placerat pulvinar. Vivamus venenatis diam eget congue interdum. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.\', 81, 78),
            (3, 2, 2, \'Fundación e Imperio\', \'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nec volutpat orci. Nam a tincidunt elit. Vivamus interdum justo ut placerat pulvinar. Vivamus venenatis diam eget congue interdum. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.\', 63, 42),
            (3, 2, 2, \'Segunda Fundación\', \'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nec volutpat orci. Nam a tincidunt elit. Vivamus interdum justo ut placerat pulvinar. Vivamus venenatis diam eget congue interdum. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.\', 74, 42),
            (2, 3, 1, \'El Imperio final\', \'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed nec volutpat orci. Nam a tincidunt elit. Vivamus interdum justo ut placerat pulvinar. Vivamus venenatis diam eget congue interdum. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.\', 51, 35)
        ');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331F675F31B');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A33112469DE2');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331BAF1A24D');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE editorial');
    }
}
