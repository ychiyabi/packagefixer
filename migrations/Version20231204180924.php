<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231204180924 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE extension_package_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE extension_package (id INT NOT NULL, id_ext_id INT NOT NULL, id_pkg_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_919849FF7B330A40 ON extension_package (id_ext_id)');
        $this->addSql('CREATE INDEX IDX_919849FF4DC48C4B ON extension_package (id_pkg_id)');
        $this->addSql('ALTER TABLE extension_package ADD CONSTRAINT FK_919849FF7B330A40 FOREIGN KEY (id_ext_id) REFERENCES extension (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE extension_package ADD CONSTRAINT FK_919849FF4DC48C4B FOREIGN KEY (id_pkg_id) REFERENCES package (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE extension_package_id_seq CASCADE');
        $this->addSql('ALTER TABLE extension_package DROP CONSTRAINT FK_919849FF7B330A40');
        $this->addSql('ALTER TABLE extension_package DROP CONSTRAINT FK_919849FF4DC48C4B');
        $this->addSql('DROP TABLE extension_package');
    }
}
