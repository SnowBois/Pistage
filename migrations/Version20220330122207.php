<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220330122207 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recherche DROP FOREIGN KEY FK_B4271B46D21280CB');
        $this->addSql('ALTER TABLE recherche CHANGE dernier_etat_id dernier_etat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE recherche ADD CONSTRAINT FK_B4271B46D21280CB FOREIGN KEY (dernier_etat_id) REFERENCES etat_recherche (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recherche DROP FOREIGN KEY FK_B4271B46D21280CB');
        $this->addSql('ALTER TABLE recherche CHANGE dernier_etat_id dernier_etat_id INT NOT NULL');
        $this->addSql('ALTER TABLE recherche ADD CONSTRAINT FK_B4271B46D21280CB FOREIGN KEY (dernier_etat_id) REFERENCES etat_recherche (id) ON DELETE CASCADE');
    }
}
