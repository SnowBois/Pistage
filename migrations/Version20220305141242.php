<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220305141242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recherche DROP FOREIGN KEY FK_B4271B465DC4D72E');
        $this->addSql('DROP INDEX IDX_B4271B465DC4D72E ON recherche');
        $this->addSql('ALTER TABLE recherche CHANGE interlocuteur_id employe_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE recherche ADD CONSTRAINT FK_B4271B461B65292 FOREIGN KEY (employe_id) REFERENCES employe (id)');
        $this->addSql('CREATE INDEX IDX_B4271B461B65292 ON recherche (employe_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recherche DROP FOREIGN KEY FK_B4271B461B65292');
        $this->addSql('DROP INDEX IDX_B4271B461B65292 ON recherche');
        $this->addSql('ALTER TABLE recherche CHANGE employe_id interlocuteur_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE recherche ADD CONSTRAINT FK_B4271B465DC4D72E FOREIGN KEY (interlocuteur_id) REFERENCES employe (id)');
        $this->addSql('CREATE INDEX IDX_B4271B465DC4D72E ON recherche (interlocuteur_id)');
    }
}
