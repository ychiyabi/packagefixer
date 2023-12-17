<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231217165612 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE solution_element_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE solution_element (id INT NOT NULL, solution_id INT DEFAULT NULL, id_element INT NOT NULL, type_element VARCHAR(255) NOT NULL, version_element VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E5E26C831C0BE183 ON solution_element (solution_id)');
        $this->addSql('ALTER TABLE solution_element ADD CONSTRAINT FK_E5E26C831C0BE183 FOREIGN KEY (solution_id) REFERENCES solution (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE solution_element_id_seq CASCADE');
        $this->addSql('ALTER TABLE solution_element DROP CONSTRAINT FK_E5E26C831C0BE183');
        $this->addSql('DROP TABLE solution_element');
    }
}
