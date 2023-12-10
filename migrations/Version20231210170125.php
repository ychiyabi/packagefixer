<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231210170125 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE extension_composer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE extension_composer (id INT NOT NULL, extension_id INT DEFAULT NULL, composer_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_355B7EB0812D5EB ON extension_composer (extension_id)');
        $this->addSql('CREATE INDEX IDX_355B7EB07A8D2620 ON extension_composer (composer_id)');
        $this->addSql('ALTER TABLE extension_composer ADD CONSTRAINT FK_355B7EB0812D5EB FOREIGN KEY (extension_id) REFERENCES extension (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE extension_composer ADD CONSTRAINT FK_355B7EB07A8D2620 FOREIGN KEY (composer_id) REFERENCES composer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE extension_composer_id_seq CASCADE');
        $this->addSql('ALTER TABLE extension_composer DROP CONSTRAINT FK_355B7EB0812D5EB');
        $this->addSql('ALTER TABLE extension_composer DROP CONSTRAINT FK_355B7EB07A8D2620');
        $this->addSql('DROP TABLE extension_composer');
    }
}
