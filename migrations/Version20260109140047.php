<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260109140047 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE pokedex (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, pokemon_id INT NOT NULL, INDEX IDX_6336F6A7A76ED395 (user_id), INDEX IDX_6336F6A72FE71C3E (pokemon_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE pokemon (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, pseudo VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE pokedex ADD CONSTRAINT FK_6336F6A7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE pokedex ADD CONSTRAINT FK_6336F6A72FE71C3E FOREIGN KEY (pokemon_id) REFERENCES pokemon (id)');
    }

    public function down(Schema $schema): void
    {

        $this->addSql('ALTER TABLE pokedex DROP FOREIGN KEY FK_6336F6A7A76ED395');
        $this->addSql('ALTER TABLE pokedex DROP FOREIGN KEY FK_6336F6A72FE71C3E');
        $this->addSql('DROP TABLE pokedex');
        $this->addSql('DROP TABLE pokemon');
        $this->addSql('DROP TABLE user');
    }
}
