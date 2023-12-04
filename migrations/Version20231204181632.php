<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231204181632 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE extension_package DROP CONSTRAINT fk_919849ff7b330a40');
        $this->addSql('ALTER TABLE extension_package DROP CONSTRAINT fk_919849ff4dc48c4b');
        $this->addSql('DROP INDEX idx_919849ff4dc48c4b');
        $this->addSql('DROP INDEX idx_919849ff7b330a40');
        $this->addSql('ALTER TABLE extension_package ADD exetension_id INT NOT NULL');
        $this->addSql('ALTER TABLE extension_package ADD package_id INT NOT NULL');
        $this->addSql('ALTER TABLE extension_package DROP id_ext_id');
        $this->addSql('ALTER TABLE extension_package DROP id_pkg_id');
        $this->addSql('ALTER TABLE extension_package ADD CONSTRAINT FK_919849FF98BA5995 FOREIGN KEY (exetension_id) REFERENCES extension (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE extension_package ADD CONSTRAINT FK_919849FFF44CABFF FOREIGN KEY (package_id) REFERENCES package (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_919849FF98BA5995 ON extension_package (exetension_id)');
        $this->addSql('CREATE INDEX IDX_919849FFF44CABFF ON extension_package (package_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE extension_package DROP CONSTRAINT FK_919849FF98BA5995');
        $this->addSql('ALTER TABLE extension_package DROP CONSTRAINT FK_919849FFF44CABFF');
        $this->addSql('DROP INDEX IDX_919849FF98BA5995');
        $this->addSql('DROP INDEX IDX_919849FFF44CABFF');
        $this->addSql('ALTER TABLE extension_package ADD id_ext_id INT NOT NULL');
        $this->addSql('ALTER TABLE extension_package ADD id_pkg_id INT NOT NULL');
        $this->addSql('ALTER TABLE extension_package DROP exetension_id');
        $this->addSql('ALTER TABLE extension_package DROP package_id');
        $this->addSql('ALTER TABLE extension_package ADD CONSTRAINT fk_919849ff7b330a40 FOREIGN KEY (id_ext_id) REFERENCES extension (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE extension_package ADD CONSTRAINT fk_919849ff4dc48c4b FOREIGN KEY (id_pkg_id) REFERENCES package (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_919849ff4dc48c4b ON extension_package (id_pkg_id)');
        $this->addSql('CREATE INDEX idx_919849ff7b330a40 ON extension_package (id_ext_id)');
    }
}
