<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210619120721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users_data ADD author_id INT UNSIGNED DEFAULT NULL');
        $this->addSql('ALTER TABLE users_data ADD CONSTRAINT FK_627ABD6DF675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_627ABD6DF675F31B ON users_data (author_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE users_data DROP FOREIGN KEY FK_627ABD6DF675F31B');
        $this->addSql('DROP INDEX IDX_627ABD6DF675F31B ON users_data');
        $this->addSql('ALTER TABLE users_data DROP author_id');
    }
}
