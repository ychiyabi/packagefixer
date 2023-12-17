<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231217160620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE composer DROP CONSTRAINT fk_987306d81c0be183');
        $this->addSql('DROP INDEX uniq_987306d81c0be183');
        $this->addSql('ALTER TABLE composer DROP solution_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE composer ADD solution_id INT NOT NULL');
        $this->addSql('ALTER TABLE composer ADD CONSTRAINT fk_987306d81c0be183 FOREIGN KEY (solution_id) REFERENCES solution (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_987306d81c0be183 ON composer (solution_id)');
    }
}
