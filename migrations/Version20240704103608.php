<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240704103608 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal_image (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animal_image_animal (animal_image_id INT NOT NULL, animal_id INT NOT NULL, INDEX IDX_77ACCC2CFB2623B0 (animal_image_id), INDEX IDX_77ACCC2C8E962C16 (animal_id), PRIMARY KEY(animal_image_id, animal_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animal_image_image (animal_image_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_75C2534FFB2623B0 (animal_image_id), INDEX IDX_75C2534F3DA5256D (image_id), PRIMARY KEY(animal_image_id, image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_image (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_image_service (service_image_id INT NOT NULL, service_id INT NOT NULL, INDEX IDX_A432778CC4D37E50 (service_image_id), INDEX IDX_A432778CED5CA9E6 (service_id), PRIMARY KEY(service_image_id, service_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_image_image (service_image_id INT NOT NULL, image_id INT NOT NULL, INDEX IDX_1EE2A65AC4D37E50 (service_image_id), INDEX IDX_1EE2A65A3DA5256D (image_id), PRIMARY KEY(service_image_id, image_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal_image_animal ADD CONSTRAINT FK_77ACCC2CFB2623B0 FOREIGN KEY (animal_image_id) REFERENCES animal_image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE animal_image_animal ADD CONSTRAINT FK_77ACCC2C8E962C16 FOREIGN KEY (animal_id) REFERENCES animal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE animal_image_image ADD CONSTRAINT FK_75C2534FFB2623B0 FOREIGN KEY (animal_image_id) REFERENCES animal_image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE animal_image_image ADD CONSTRAINT FK_75C2534F3DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_image_service ADD CONSTRAINT FK_A432778CC4D37E50 FOREIGN KEY (service_image_id) REFERENCES service_image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_image_service ADD CONSTRAINT FK_A432778CED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_image_image ADD CONSTRAINT FK_1EE2A65AC4D37E50 FOREIGN KEY (service_image_id) REFERENCES service_image (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_image_image ADD CONSTRAINT FK_1EE2A65A3DA5256D FOREIGN KEY (image_id) REFERENCES image (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE animal_image_animal DROP FOREIGN KEY FK_77ACCC2CFB2623B0');
        $this->addSql('ALTER TABLE animal_image_animal DROP FOREIGN KEY FK_77ACCC2C8E962C16');
        $this->addSql('ALTER TABLE animal_image_image DROP FOREIGN KEY FK_75C2534FFB2623B0');
        $this->addSql('ALTER TABLE animal_image_image DROP FOREIGN KEY FK_75C2534F3DA5256D');
        $this->addSql('ALTER TABLE service_image_service DROP FOREIGN KEY FK_A432778CC4D37E50');
        $this->addSql('ALTER TABLE service_image_service DROP FOREIGN KEY FK_A432778CED5CA9E6');
        $this->addSql('ALTER TABLE service_image_image DROP FOREIGN KEY FK_1EE2A65AC4D37E50');
        $this->addSql('ALTER TABLE service_image_image DROP FOREIGN KEY FK_1EE2A65A3DA5256D');
        $this->addSql('DROP TABLE animal_image');
        $this->addSql('DROP TABLE animal_image_animal');
        $this->addSql('DROP TABLE animal_image_image');
        $this->addSql('DROP TABLE service_image');
        $this->addSql('DROP TABLE service_image_service');
        $this->addSql('DROP TABLE service_image_image');
    }
}
