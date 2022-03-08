<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220308174022 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE archive CHANGE idarchive idarchive VARCHAR(255) NOT NULL, CHANGE image image VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE evenement DROP images, CHANGE prix prix VARCHAR(255) NOT NULL, CHANGE datefin datefin VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD user_id INT DEFAULT NULL, CHANGE email email VARCHAR(200) NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_42C84955A76ED395 ON reservation (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE archive CHANGE idarchive idarchive VARCHAR(255) DEFAULT NULL, CHANGE image image TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE evenement ADD images VARCHAR(255) DEFAULT NULL, CHANGE prix prix TEXT NOT NULL, CHANGE datefin datefin TEXT NOT NULL');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('DROP INDEX IDX_42C84955A76ED395 ON reservation');
        $this->addSql('ALTER TABLE reservation DROP user_id, CHANGE email email VARCHAR(200) DEFAULT NULL');
    }
}
