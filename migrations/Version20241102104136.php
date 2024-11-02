<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241102104136 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media DROP CONSTRAINT fk_6a2ca10c17421b18');
        $this->addSql('DROP INDEX idx_6a2ca10c17421b18');
        $this->addSql('ALTER TABLE media DROP playlist_media_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE media ADD playlist_media_id INT NOT NULL');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT fk_6a2ca10c17421b18 FOREIGN KEY (playlist_media_id) REFERENCES playlist_media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_6a2ca10c17421b18 ON media (playlist_media_id)');
    }
}
