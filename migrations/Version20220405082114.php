<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220405082114 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administrateur (id INT AUTO_INCREMENT NOT NULL, utilisateur_id INT NOT NULL, UNIQUE INDEX UNIQ_32EB52E8FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE adresse (id INT AUTO_INCREMENT NOT NULL, voie VARCHAR(50) NOT NULL, batiment_residence_zi VARCHAR(50) DEFAULT NULL, commune VARCHAR(50) NOT NULL, code_postal VARCHAR(10) NOT NULL, pays VARCHAR(50) NOT NULL, cedex VARCHAR(10) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cursus (id INT AUTO_INCREMENT NOT NULL, nom_long LONGTEXT NOT NULL, nom_court VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employe (id INT AUTO_INCREMENT NOT NULL, entreprise_id INT NOT NULL, nom VARCHAR(30) NOT NULL, prenom VARCHAR(30) NOT NULL, fonction VARCHAR(50) DEFAULT NULL, numero_telephone VARCHAR(20) DEFAULT NULL, adresse_mail VARCHAR(100) DEFAULT NULL, est_representant_legal TINYINT(1) DEFAULT NULL, INDEX IDX_F804D3B9A4AEAFEA (entreprise_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE enseignant_referent (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(30) NOT NULL, prenom VARCHAR(30) NOT NULL, adresse_mail VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entreprise (id INT AUTO_INCREMENT NOT NULL, adresse_id INT NOT NULL, nom VARCHAR(50) NOT NULL, numero_telephone VARCHAR(20) NOT NULL, type_etablissement VARCHAR(30) NOT NULL, activite LONGTEXT DEFAULT NULL, numero_siret VARCHAR(14) NOT NULL, code_apeou_naf VARCHAR(10) DEFAULT NULL, statut_juridique VARCHAR(30) DEFAULT NULL, effectif VARCHAR(10) NOT NULL, numero_fax VARCHAR(20) DEFAULT NULL, adresse_mail VARCHAR(100) DEFAULT NULL, site_web VARCHAR(100) DEFAULT NULL, INDEX IDX_D19FA604DE7DC5C (adresse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etablissement_enseignement (id INT AUTO_INCREMENT NOT NULL, adresse_id INT NOT NULL, composante_ufr VARCHAR(50) NOT NULL, discipline_et_diplome VARCHAR(30) NOT NULL, etape_etude VARCHAR(30) NOT NULL, numero_telephone VARCHAR(20) NOT NULL, INDEX IDX_D494C94D4DE7DC5C (adresse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etat_recherche (id INT AUTO_INCREMENT NOT NULL, recherche_id INT NOT NULL, etat VARCHAR(30) NOT NULL, date DATETIME NOT NULL, INDEX IDX_44B55DAA1E6A4A07 (recherche_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etudiant (id INT AUTO_INCREMENT NOT NULL, cursus_id INT NOT NULL, adresse_id INT NOT NULL, utilisateur_id INT DEFAULT NULL, nom VARCHAR(30) NOT NULL, prenom VARCHAR(30) NOT NULL, numero_etudiant VARCHAR(10) NOT NULL, numero_telephone VARCHAR(20) DEFAULT NULL, adresse_mail VARCHAR(100) NOT NULL, premiere_connexion TINYINT(1) NOT NULL, INDEX IDX_717E22E340AEF4B9 (cursus_id), INDEX IDX_717E22E34DE7DC5C (adresse_id), UNIQUE INDEX UNIQ_717E22E3FB88E14F (utilisateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media_contact (id INT AUTO_INCREMENT NOT NULL, intitule VARCHAR(30) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recherche (id INT AUTO_INCREMENT NOT NULL, media_contact_id INT NOT NULL, dernier_etat_id INT DEFAULT NULL, employe_id INT DEFAULT NULL, entreprise_id INT NOT NULL, etudiant_id INT NOT NULL, stage_id INT DEFAULT NULL, observations LONGTEXT DEFAULT NULL, INDEX IDX_B4271B46ED84EBDE (media_contact_id), UNIQUE INDEX UNIQ_B4271B46D21280CB (dernier_etat_id), INDEX IDX_B4271B461B65292 (employe_id), INDEX IDX_B4271B46A4AEAFEA (entreprise_id), INDEX IDX_B4271B46DDEAB1A3 (etudiant_id), UNIQUE INDEX UNIQ_B4271B462298D193 (stage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, entreprise_id INT NOT NULL, adresse_id INT NOT NULL, nom VARCHAR(50) NOT NULL, INDEX IDX_E19D9AD2A4AEAFEA (entreprise_id), INDEX IDX_E19D9AD24DE7DC5C (adresse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stage (id INT AUTO_INCREMENT NOT NULL, etablissement_enseignement_id INT NOT NULL, enseignant_referent_id INT NOT NULL, adresse_id INT DEFAULT NULL, affiliation_securite_sociale VARCHAR(50) NOT NULL, caisse_assurance_maladie VARCHAR(30) NOT NULL, nombre_personnes_aidant INT NOT NULL, moyens_outils_disponibles LONGTEXT NOT NULL, autre_materiel LONGTEXT DEFAULT NULL, type_taches LONGTEXT NOT NULL, autres_taches LONGTEXT DEFAULT NULL, competences LONGTEXT NOT NULL, confidentiel TINYINT(1) NOT NULL, sujet LONGTEXT NOT NULL, interrompu TINYINT(1) NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, duree_en_heures INT NOT NULL, nombre_jours_travail_hebdomadaires INT NOT NULL, nombre_jours_conges INT NOT NULL, gratifie TINYINT(1) NOT NULL, taux_horaire_net_par_heure DOUBLE PRECISION DEFAULT NULL, montant_gratification INT NOT NULL, devise_locale VARCHAR(20) NOT NULL, modalites_versement VARCHAR(20) NOT NULL, modalite_suivi_stagiaire VARCHAR(100) NOT NULL, liste_avantages_en_nature LONGTEXT DEFAULT NULL, nature_travail_fourni_suite_au_stage VARCHAR(50) NOT NULL, presences_exceptionnelles LONGTEXT DEFAULT NULL, type_stage VARCHAR(30) NOT NULL, thematique_stage VARCHAR(50) NOT NULL, informations_complementaires LONGTEXT DEFAULT NULL, modalite_validation_stage VARCHAR(30) NOT NULL, nombre_heures_enseignement INT NOT NULL, INDEX IDX_C27C9369F359E02D (etablissement_enseignement_id), INDEX IDX_C27C9369A7C44A09 (enseignant_referent_id), INDEX IDX_C27C93694DE7DC5C (adresse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE utilisateur (id INT AUTO_INCREMENT NOT NULL, administrateur_id INT DEFAULT NULL, etudiant_id INT DEFAULT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1D1C63B3F85E0677 (username), UNIQUE INDEX UNIQ_1D1C63B37EE5403C (administrateur_id), UNIQUE INDEX UNIQ_1D1C63B3DDEAB1A3 (etudiant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE administrateur ADD CONSTRAINT FK_32EB52E8FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE employe ADD CONSTRAINT FK_F804D3B9A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE entreprise ADD CONSTRAINT FK_D19FA604DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE etablissement_enseignement ADD CONSTRAINT FK_D494C94D4DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE etat_recherche ADD CONSTRAINT FK_44B55DAA1E6A4A07 FOREIGN KEY (recherche_id) REFERENCES recherche (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E340AEF4B9 FOREIGN KEY (cursus_id) REFERENCES cursus (id)');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E34DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE etudiant ADD CONSTRAINT FK_717E22E3FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recherche ADD CONSTRAINT FK_B4271B46ED84EBDE FOREIGN KEY (media_contact_id) REFERENCES media_contact (id)');
        $this->addSql('ALTER TABLE recherche ADD CONSTRAINT FK_B4271B46D21280CB FOREIGN KEY (dernier_etat_id) REFERENCES etat_recherche (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE recherche ADD CONSTRAINT FK_B4271B461B65292 FOREIGN KEY (employe_id) REFERENCES employe (id)');
        $this->addSql('ALTER TABLE recherche ADD CONSTRAINT FK_B4271B46A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE recherche ADD CONSTRAINT FK_B4271B46DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id)');
        $this->addSql('ALTER TABLE recherche ADD CONSTRAINT FK_B4271B462298D193 FOREIGN KEY (stage_id) REFERENCES stage (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2A4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD24DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369F359E02D FOREIGN KEY (etablissement_enseignement_id) REFERENCES etablissement_enseignement (id)');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C9369A7C44A09 FOREIGN KEY (enseignant_referent_id) REFERENCES enseignant_referent (id)');
        $this->addSql('ALTER TABLE stage ADD CONSTRAINT FK_C27C93694DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B37EE5403C FOREIGN KEY (administrateur_id) REFERENCES administrateur (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3DDEAB1A3 FOREIGN KEY (etudiant_id) REFERENCES etudiant (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B37EE5403C');
        $this->addSql('ALTER TABLE entreprise DROP FOREIGN KEY FK_D19FA604DE7DC5C');
        $this->addSql('ALTER TABLE etablissement_enseignement DROP FOREIGN KEY FK_D494C94D4DE7DC5C');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E34DE7DC5C');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD24DE7DC5C');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C93694DE7DC5C');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E340AEF4B9');
        $this->addSql('ALTER TABLE recherche DROP FOREIGN KEY FK_B4271B461B65292');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369A7C44A09');
        $this->addSql('ALTER TABLE employe DROP FOREIGN KEY FK_F804D3B9A4AEAFEA');
        $this->addSql('ALTER TABLE recherche DROP FOREIGN KEY FK_B4271B46A4AEAFEA');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2A4AEAFEA');
        $this->addSql('ALTER TABLE stage DROP FOREIGN KEY FK_C27C9369F359E02D');
        $this->addSql('ALTER TABLE recherche DROP FOREIGN KEY FK_B4271B46D21280CB');
        $this->addSql('ALTER TABLE recherche DROP FOREIGN KEY FK_B4271B46DDEAB1A3');
        $this->addSql('ALTER TABLE utilisateur DROP FOREIGN KEY FK_1D1C63B3DDEAB1A3');
        $this->addSql('ALTER TABLE recherche DROP FOREIGN KEY FK_B4271B46ED84EBDE');
        $this->addSql('ALTER TABLE etat_recherche DROP FOREIGN KEY FK_44B55DAA1E6A4A07');
        $this->addSql('ALTER TABLE recherche DROP FOREIGN KEY FK_B4271B462298D193');
        $this->addSql('ALTER TABLE administrateur DROP FOREIGN KEY FK_32EB52E8FB88E14F');
        $this->addSql('ALTER TABLE etudiant DROP FOREIGN KEY FK_717E22E3FB88E14F');
        $this->addSql('DROP TABLE administrateur');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP TABLE cursus');
        $this->addSql('DROP TABLE employe');
        $this->addSql('DROP TABLE enseignant_referent');
        $this->addSql('DROP TABLE entreprise');
        $this->addSql('DROP TABLE etablissement_enseignement');
        $this->addSql('DROP TABLE etat_recherche');
        $this->addSql('DROP TABLE etudiant');
        $this->addSql('DROP TABLE media_contact');
        $this->addSql('DROP TABLE recherche');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE stage');
        $this->addSql('DROP TABLE utilisateur');
    }
}
