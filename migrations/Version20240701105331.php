<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240701105331 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal ADD race_id INT NOT NULL, ADD habitat_id INT NOT NULL');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231F6E59D40D FOREIGN KEY (race_id) REFERENCES race (id)');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FAFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitat (id)');
        $this->addSql('CREATE INDEX IDX_6AAB231F6E59D40D ON animal (race_id)');
        $this->addSql('CREATE INDEX IDX_6AAB231FAFFE2D26 ON animal (habitat_id)');
        $this->addSql('ALTER TABLE habitat_image ADD habitat_id INT NOT NULL, ADD image_id INT NOT NULL');
        $this->addSql('ALTER TABLE habitat_image ADD CONSTRAINT FK_9AD7E031AFFE2D26 FOREIGN KEY (habitat_id) REFERENCES habitat (id)');
        $this->addSql('ALTER TABLE habitat_image ADD CONSTRAINT FK_9AD7E0313DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('CREATE INDEX IDX_9AD7E031AFFE2D26 ON habitat_image (habitat_id)');
        $this->addSql('CREATE INDEX IDX_9AD7E0313DA5256D ON habitat_image (image_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231F6E59D40D');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FAFFE2D26');
        $this->addSql('DROP INDEX IDX_6AAB231F6E59D40D ON animal');
        $this->addSql('DROP INDEX IDX_6AAB231FAFFE2D26 ON animal');
        $this->addSql('ALTER TABLE animal DROP race_id, DROP habitat_id');
        $this->addSql('ALTER TABLE habitat_image DROP FOREIGN KEY FK_9AD7E031AFFE2D26');
        $this->addSql('ALTER TABLE habitat_image DROP FOREIGN KEY FK_9AD7E0313DA5256D');
        $this->addSql('DROP INDEX IDX_9AD7E031AFFE2D26 ON habitat_image');
        $this->addSql('DROP INDEX IDX_9AD7E0313DA5256D ON habitat_image');
        $this->addSql('ALTER TABLE habitat_image DROP habitat_id, DROP image_id');
    }
}
