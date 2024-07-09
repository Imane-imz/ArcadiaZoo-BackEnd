<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240706093728 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rapport_veterinaire DROP FOREIGN KEY FK_CE729CDEA76ED395');
        $this->addSql('ALTER TABLE rapport_veterinaire ADD CONSTRAINT FK_CE729CDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rapport_veterinaire DROP FOREIGN KEY FK_CE729CDEA76ED395');
        $this->addSql('ALTER TABLE rapport_veterinaire ADD CONSTRAINT FK_CE729CDEA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
    }
}
