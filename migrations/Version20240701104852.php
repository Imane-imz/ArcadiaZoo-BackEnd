<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240701104852 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rapport_veterinaire ADD user_id INT NOT NULL, ADD animal_id INT NOT NULL');
        $this->addSql('ALTER TABLE rapport_veterinaire ADD CONSTRAINT FK_CE729CDEA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE rapport_veterinaire ADD CONSTRAINT FK_CE729CDE8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id)');
        $this->addSql('CREATE INDEX IDX_CE729CDEA76ED395 ON rapport_veterinaire (user_id)');
        $this->addSql('CREATE INDEX IDX_CE729CDE8E962C16 ON rapport_veterinaire (animal_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rapport_veterinaire DROP FOREIGN KEY FK_CE729CDEA76ED395');
        $this->addSql('ALTER TABLE rapport_veterinaire DROP FOREIGN KEY FK_CE729CDE8E962C16');
        $this->addSql('DROP INDEX IDX_CE729CDEA76ED395 ON rapport_veterinaire');
        $this->addSql('DROP INDEX IDX_CE729CDE8E962C16 ON rapport_veterinaire');
        $this->addSql('ALTER TABLE rapport_veterinaire DROP user_id, DROP animal_id');
    }
}
