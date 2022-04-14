<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220414160240 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresse DROP FOREIGN KEY FK_C35F081682EA2E54');
        $this->addSql('ALTER TABLE adresse DROP FOREIGN KEY FK_C35F08168E54FB25');
        $this->addSql('DROP INDEX UNIQ_C35F081682EA2E54 ON adresse');
        $this->addSql('DROP INDEX UNIQ_C35F08168E54FB25 ON adresse');
        $this->addSql('ALTER TABLE adresse DROP commande_id, DROP livraison_id');
        $this->addSql('ALTER TABLE commande ADD adresse_destination_id INT NOT NULL, CHANGE magasin_id magasin_id INT NOT NULL');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D11481E0 FOREIGN KEY (adresse_destination_id) REFERENCES adresse (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6EEAA67D11481E0 ON commande (adresse_destination_id)');
        $this->addSql('ALTER TABLE magasin ADD adresse_id INT NOT NULL');
        $this->addSql('ALTER TABLE magasin ADD CONSTRAINT FK_54AF5F274DE7DC5C FOREIGN KEY (adresse_id) REFERENCES adresse (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_54AF5F274DE7DC5C ON magasin (adresse_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE adresse ADD commande_id INT NOT NULL, ADD livraison_id INT NOT NULL');
        $this->addSql('ALTER TABLE adresse ADD CONSTRAINT FK_C35F081682EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE adresse ADD CONSTRAINT FK_C35F08168E54FB25 FOREIGN KEY (livraison_id) REFERENCES livraison (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C35F081682EA2E54 ON adresse (commande_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C35F08168E54FB25 ON adresse (livraison_id)');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D11481E0');
        $this->addSql('DROP INDEX UNIQ_6EEAA67D11481E0 ON commande');
        $this->addSql('ALTER TABLE commande DROP adresse_destination_id, CHANGE magasin_id magasin_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE magasin DROP FOREIGN KEY FK_54AF5F274DE7DC5C');
        $this->addSql('DROP INDEX UNIQ_54AF5F274DE7DC5C ON magasin');
        $this->addSql('ALTER TABLE magasin DROP adresse_id');
    }
}
