<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220327151556 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employe CHANGE numero_telephone numero_telephone VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE entreprise CHANGE numero_telephone numero_telephone VARCHAR(20) NOT NULL, CHANGE numero_fax numero_fax VARCHAR(20) DEFAULT NULL');
        $this->addSql('ALTER TABLE etablissement_enseignement CHANGE numero_telephone numero_telephone VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE etudiant CHANGE numero_telephone numero_telephone VARCHAR(20) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE employe CHANGE numero_telephone numero_telephone VARCHAR(15) DEFAULT NULL');
        $this->addSql('ALTER TABLE entreprise CHANGE numero_telephone numero_telephone VARCHAR(15) NOT NULL, CHANGE numero_fax numero_fax VARCHAR(15) DEFAULT NULL');
        $this->addSql('ALTER TABLE etablissement_enseignement CHANGE numero_telephone numero_telephone VARCHAR(15) NOT NULL');
        $this->addSql('ALTER TABLE etudiant CHANGE numero_telephone numero_telephone VARCHAR(15) DEFAULT NULL');
    }
}
