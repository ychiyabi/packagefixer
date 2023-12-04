<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231204181526 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE composer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE package_composer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE composer (id INT NOT NULL, content JSON NOT NULL, date_submit TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, state BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE package_composer (id INT NOT NULL, composer_id INT DEFAULT NULL, package_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_7CF292B67A8D2620 ON package_composer (composer_id)');
        $this->addSql('CREATE INDEX IDX_7CF292B6F44CABFF ON package_composer (package_id)');
        $this->addSql('ALTER TABLE package_composer ADD CONSTRAINT FK_7CF292B67A8D2620 FOREIGN KEY (composer_id) REFERENCES composer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE package_composer ADD CONSTRAINT FK_7CF292B6F44CABFF FOREIGN KEY (package_id) REFERENCES package (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE composer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE package_composer_id_seq CASCADE');
        $this->addSql('ALTER TABLE package_composer DROP CONSTRAINT FK_7CF292B67A8D2620');
        $this->addSql('ALTER TABLE package_composer DROP CONSTRAINT FK_7CF292B6F44CABFF');
        $this->addSql('DROP TABLE composer');
        $this->addSql('DROP TABLE package_composer');
    }
}
