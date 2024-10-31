<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241031134623 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE category_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE comment_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE episode_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE language_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE media_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE playlist_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE playlist_media_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE playlist_subscription_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE season_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE subscription_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE subscription_history_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE watch_history_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, nom VARCHAR(255) NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE comment (id INT NOT NULL, parent_comment_id INT DEFAULT NULL, publisher_id INT NOT NULL, media_id INT DEFAULT NULL, content TEXT NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_9474526CBF2AF943 ON comment (parent_comment_id)');
        $this->addSql('CREATE INDEX IDX_9474526C40C86FCE ON comment (publisher_id)');
        $this->addSql('CREATE INDEX IDX_9474526CEA9FDD75 ON comment (media_id)');
        $this->addSql('CREATE TABLE episode (id INT NOT NULL, season_id_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, duration INT NOT NULL, released_at DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DDAA1CDA68756988 ON episode (season_id_id)');
        $this->addSql('COMMENT ON COLUMN episode.released_at IS \'(DC2Type:date_immutable)\'');
        $this->addSql('CREATE TABLE language (id INT NOT NULL, nom VARCHAR(255) NOT NULL, code VARCHAR(3) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE language_media (language_id INT NOT NULL, media_id INT NOT NULL, PRIMARY KEY(language_id, media_id))');
        $this->addSql('CREATE INDEX IDX_1574A55D82F1BAF4 ON language_media (language_id)');
        $this->addSql('CREATE INDEX IDX_1574A55DEA9FDD75 ON language_media (media_id)');
        $this->addSql('CREATE TABLE media (id INT NOT NULL, playlist_media_id INT NOT NULL, title VARCHAR(255) NOT NULL, media_type VARCHAR(255) NOT NULL, short_description TEXT NOT NULL, long_description TEXT NOT NULL, release_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, cover_image VARCHAR(255) NOT NULL, staff JSON NOT NULL, casting JSON NOT NULL, mediaType VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6A2CA10C17421B18 ON media (playlist_media_id)');
        $this->addSql('COMMENT ON COLUMN media.release_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE media_category (media_id INT NOT NULL, category_id INT NOT NULL, PRIMARY KEY(media_id, category_id))');
        $this->addSql('CREATE INDEX IDX_92D3773EA9FDD75 ON media_category (media_id)');
        $this->addSql('CREATE INDEX IDX_92D377312469DE2 ON media_category (category_id)');
        $this->addSql('CREATE TABLE movie (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE playlist (id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN playlist.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN playlist.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE playlist_media (id INT NOT NULL, playlist_id INT NOT NULL, added_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C930B84F6BBD148 ON playlist_media (playlist_id)');
        $this->addSql('COMMENT ON COLUMN playlist_media.added_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE playlist_subscription (id INT NOT NULL, playlist_id INT NOT NULL, subscribed_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_832940C6BBD148 ON playlist_subscription (playlist_id)');
        $this->addSql('COMMENT ON COLUMN playlist_subscription.subscribed_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE season (id INT NOT NULL, serie_id_id INT DEFAULT NULL, season_number INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_F0E45BA9B748AAC3 ON season (serie_id_id)');
        $this->addSql('CREATE TABLE serie (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE subscription (id INT NOT NULL, name VARCHAR(255) NOT NULL, price INT NOT NULL, duration INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE subscription_history (id INT NOT NULL, start_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, end_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN subscription_history.start_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN subscription_history.end_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, current_subscription_id INT DEFAULT NULL, author_id INT NOT NULL, subscription_history_id INT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, account_status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8D93D649DDE45DDE ON "user" (current_subscription_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649F675F31B ON "user" (author_id)');
        $this->addSql('CREATE INDEX IDX_8D93D649DCE0C437 ON "user" (subscription_history_id)');
        $this->addSql('CREATE TABLE watch_history (id INT NOT NULL, user_id_id INT NOT NULL, last_watched_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, number_of_views INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_DE44EFD89D86650F ON watch_history (user_id_id)');
        $this->addSql('COMMENT ON COLUMN watch_history.last_watched_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CBF2AF943 FOREIGN KEY (parent_comment_id) REFERENCES comment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526C40C86FCE FOREIGN KEY (publisher_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE episode ADD CONSTRAINT FK_DDAA1CDA68756988 FOREIGN KEY (season_id_id) REFERENCES season (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE language_media ADD CONSTRAINT FK_1574A55D82F1BAF4 FOREIGN KEY (language_id) REFERENCES language (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE language_media ADD CONSTRAINT FK_1574A55DEA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE media ADD CONSTRAINT FK_6A2CA10C17421B18 FOREIGN KEY (playlist_media_id) REFERENCES playlist_media (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE media_category ADD CONSTRAINT FK_92D3773EA9FDD75 FOREIGN KEY (media_id) REFERENCES media (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE media_category ADD CONSTRAINT FK_92D377312469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE movie ADD CONSTRAINT FK_1D5EF26FBF396750 FOREIGN KEY (id) REFERENCES media (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE playlist_media ADD CONSTRAINT FK_C930B84F6BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE playlist_subscription ADD CONSTRAINT FK_832940C6BBD148 FOREIGN KEY (playlist_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE season ADD CONSTRAINT FK_F0E45BA9B748AAC3 FOREIGN KEY (serie_id_id) REFERENCES serie (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE serie ADD CONSTRAINT FK_AA3A9334BF396750 FOREIGN KEY (id) REFERENCES media (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649DDE45DDE FOREIGN KEY (current_subscription_id) REFERENCES subscription (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649F675F31B FOREIGN KEY (author_id) REFERENCES comment (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D649DCE0C437 FOREIGN KEY (subscription_history_id) REFERENCES subscription_history (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE watch_history ADD CONSTRAINT FK_DE44EFD89D86650F FOREIGN KEY (user_id_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE category_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE comment_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE episode_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE language_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE media_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE playlist_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE playlist_media_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE playlist_subscription_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE season_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE subscription_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE subscription_history_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE watch_history_id_seq CASCADE');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526CBF2AF943');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526C40C86FCE');
        $this->addSql('ALTER TABLE comment DROP CONSTRAINT FK_9474526CEA9FDD75');
        $this->addSql('ALTER TABLE episode DROP CONSTRAINT FK_DDAA1CDA68756988');
        $this->addSql('ALTER TABLE language_media DROP CONSTRAINT FK_1574A55D82F1BAF4');
        $this->addSql('ALTER TABLE language_media DROP CONSTRAINT FK_1574A55DEA9FDD75');
        $this->addSql('ALTER TABLE media DROP CONSTRAINT FK_6A2CA10C17421B18');
        $this->addSql('ALTER TABLE media_category DROP CONSTRAINT FK_92D3773EA9FDD75');
        $this->addSql('ALTER TABLE media_category DROP CONSTRAINT FK_92D377312469DE2');
        $this->addSql('ALTER TABLE movie DROP CONSTRAINT FK_1D5EF26FBF396750');
        $this->addSql('ALTER TABLE playlist_media DROP CONSTRAINT FK_C930B84F6BBD148');
        $this->addSql('ALTER TABLE playlist_subscription DROP CONSTRAINT FK_832940C6BBD148');
        $this->addSql('ALTER TABLE season DROP CONSTRAINT FK_F0E45BA9B748AAC3');
        $this->addSql('ALTER TABLE serie DROP CONSTRAINT FK_AA3A9334BF396750');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649DDE45DDE');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649F675F31B');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649DCE0C437');
        $this->addSql('ALTER TABLE watch_history DROP CONSTRAINT FK_DE44EFD89D86650F');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE episode');
        $this->addSql('DROP TABLE language');
        $this->addSql('DROP TABLE language_media');
        $this->addSql('DROP TABLE media');
        $this->addSql('DROP TABLE media_category');
        $this->addSql('DROP TABLE movie');
        $this->addSql('DROP TABLE playlist');
        $this->addSql('DROP TABLE playlist_media');
        $this->addSql('DROP TABLE playlist_subscription');
        $this->addSql('DROP TABLE season');
        $this->addSql('DROP TABLE serie');
        $this->addSql('DROP TABLE subscription');
        $this->addSql('DROP TABLE subscription_history');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE watch_history');
    }
}
