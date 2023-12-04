<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231204182720 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE required_package_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE solution_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE required_package (id INT NOT NULL, require_id INT DEFAULT NULL, dependencer_id INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FF894055E0796194 ON required_package (require_id)');
        $this->addSql('CREATE INDEX IDX_FF894055587827C6 ON required_package (dependencer_id)');
        $this->addSql('CREATE TABLE solution (id INT NOT NULL, composer_id INT NOT NULL, bash VARCHAR(3000) NOT NULL, date_delivery TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_9F3329DB7A8D2620 ON solution (composer_id)');
        $this->addSql('ALTER TABLE required_package ADD CONSTRAINT FK_FF894055E0796194 FOREIGN KEY (require_id) REFERENCES package (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE required_package ADD CONSTRAINT FK_FF894055587827C6 FOREIGN KEY (dependencer_id) REFERENCES package (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE solution ADD CONSTRAINT FK_9F3329DB7A8D2620 FOREIGN KEY (composer_id) REFERENCES composer (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE extension_package DROP CONSTRAINT fk_919849ff98ba5995');
        $this->addSql('DROP INDEX idx_919849ff98ba5995');
        $this->addSql('ALTER TABLE extension_package RENAME COLUMN exetension_id TO extension_id');
        $this->addSql('ALTER TABLE extension_package ADD CONSTRAINT FK_919849FF812D5EB FOREIGN KEY (extension_id) REFERENCES extension (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_919849FF812D5EB ON extension_package (extension_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE required_package_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE solution_id_seq CASCADE');
        $this->addSql('ALTER TABLE required_package DROP CONSTRAINT FK_FF894055E0796194');
        $this->addSql('ALTER TABLE required_package DROP CONSTRAINT FK_FF894055587827C6');
        $this->addSql('ALTER TABLE solution DROP CONSTRAINT FK_9F3329DB7A8D2620');
        $this->addSql('DROP TABLE required_package');
        $this->addSql('DROP TABLE solution');
        $this->addSql('ALTER TABLE extension_package DROP CONSTRAINT FK_919849FF812D5EB');
        $this->addSql('DROP INDEX IDX_919849FF812D5EB');
        $this->addSql('ALTER TABLE extension_package RENAME COLUMN extension_id TO exetension_id');
        $this->addSql('ALTER TABLE extension_package ADD CONSTRAINT fk_919849ff98ba5995 FOREIGN KEY (exetension_id) REFERENCES extension (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_919849ff98ba5995 ON extension_package (exetension_id)');
    }
}
