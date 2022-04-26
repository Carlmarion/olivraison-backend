<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220421190512 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE magasin DROP FOREIGN KEY FK_54AF5F27A76ED395');
        $this->addSql('DROP INDEX UNIQ_54AF5F276C6E55B5 ON magasin');
        $this->addSql('DROP INDEX UNIQ_54AF5F27A76ED395 ON magasin');
        $this->addSql('ALTER TABLE magasin DROP user_id');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64920096AE3');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64920096AE3 FOREIGN KEY (magasin_id) REFERENCES magasin (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE magasin ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE magasin ADD CONSTRAINT FK_54AF5F27A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_54AF5F276C6E55B5 ON magasin (nom)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_54AF5F27A76ED395 ON magasin (user_id)');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64920096AE3');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64920096AE3 FOREIGN KEY (magasin_id) REFERENCES magasin (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
