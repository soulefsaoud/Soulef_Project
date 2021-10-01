<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210929130823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire ADD daily_menu_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commentaire ADD CONSTRAINT FK_67F068BC133638E6 FOREIGN KEY (daily_menu_id) REFERENCES daily_menu (id)');
        $this->addSql('CREATE INDEX IDX_67F068BC133638E6 ON commentaire (daily_menu_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commentaire DROP FOREIGN KEY FK_67F068BC133638E6');
        $this->addSql('DROP INDEX IDX_67F068BC133638E6 ON commentaire');
        $this->addSql('ALTER TABLE commentaire DROP daily_menu_id');
    }
}
