<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220326155217 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administrateur (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, UNIQUE INDEX UNIQ_32EB52E8FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media_contact (id INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, administrateur_id INT DEFAULT NULL, etudiant_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1D1C63B3F85E0677 (username), UNIQUE INDEX UNIQ_1D1C63B37EE5403C (administrateur_id), UNIQUE INDEX UNIQ_1D1C63B3DDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE administrateur ADD CONSTRAINT FK_32EB52E8FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B37EE5403C FOREIGN KEY (administrateur_id) REFERENCES administrateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE adresse CHANGE pays pays VARCHAR(50) NOT NULL');
        $this->addSql('ALTER TABLE entreprise CHANGE activite activite LONGTEXT DEFAULT NULL, CHANGE effectif effectif VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE etat_recherche DROP FOREIGN KEY FK_44B55DAA1E6A4A07');
        $this->addSql('ALTER TABLE etat_recherche CHANGE date date DATETIME NOT NULL');
        $this->addSql('ALTER TABLE etat_recherche ADD CONSTRAINT FK_44B55DAA1E6A4A07 FOREIGN KEY (recherche_id) REFERENCES recherche (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etudiant ADD utilisateur_id INT DEFAULT NULL, ADD numero_telephone VARCHAR(15) DEFAULT NULL');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_717E22E3FB88E14F ON etudiant (utilisateur_id)');
        $this->addSql('ALTER TABLE recherche DROP FOREIGN KEY FK_B4271B465DC4D72E');
        $this->addSql('DROP INDEX IDX_B4271B465DC4D72E ON recherche');
        $this->addSql('ALTER TABLE recherche ADD media_contact_id INT NOT NULL, DROP media_contact, CHANGE interlocuteur_id employe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE recherche ADD CONSTRAINT FK_B4271B46ED84EBDE FOREIGN KEY (media_contact_id) REFERENCES media_contact (id)');
        $this->addSql('ALTER TABLE recherche ADD CONSTRAINT FK_B4271B461B65292 FOREIGN KEY (employe_id) REFERENCES employe (id)');
        $this->addSql('CREATE INDEX IDX_B4271B46ED84EBDE ON recherche (media_contact_id)');
        $this->addSql('CREATE INDEX IDX_B4271B461B65292 ON recherche (employe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B37EE5403C');
        $this->addSql('ALTER TABLE recherche DROP FOREIGN KEY FK_B4271B46ED84EBDE');
        $this->addSql('ALTER TABLE administrateur DROP FOREIGN KEY FK_32EB52E8FB88E14F');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3FB88E14F');
        $this->addSql('DROP TABLE administrateur');
        $this->addSql('DROP TABLE media_contact');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('ALTER TABLE adresse CHANGE pays pays VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE entreprise CHANGE activite activite LONGTEXT NOT NULL, CHANGE effectif effectif INT NOT NULL');
        $this->addSql('ALTER TABLE etat_recherche DROP FOREIGN KEY FK_44B55DAA1E6A4A07');
        $this->addSql('ALTER TABLE etat_recherche CHANGE date date DATE NOT NULL');
        $this->addSql('ALTER TABLE etat_recherche ADD CONSTRAINT FK_44B55DAA1E6A4A07 FOREIGN KEY (recherche_id) REFERENCES recherche (id)');
        $this->addSql('DROP INDEX UNIQ_717E22E3FB88E14F ON etudiant');
        $this->addSql('ALTER TABLE etudiant DROP utilisateur_id, DROP numero_telephone');
        $this->addSql('ALTER TABLE recherche DROP FOREIGN KEY FK_B4271B461B65292');
        $this->addSql('DROP INDEX IDX_B4271B46ED84EBDE ON recherche');
        $this->addSql('DROP INDEX IDX_B4271B461B65292 ON recherche');
        $this->addSql('ALTER TABLE recherche ADD media_contact VARCHAR(30) NOT NULL, DROP media_contact_id, CHANGE employe_id interlocuteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE recherche ADD CONSTRAINT FK_B4271B465DC4D72E FOREIGN KEY (interlocuteur_id) REFERENCES employe (id)');
        $this->addSql('CREATE INDEX IDX_B4271B465DC4D72E ON recherche (interlocuteur_id)');
    }
}
