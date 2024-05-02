<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240502131359 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE items_users (items_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_105F6F526BB0AE84 (items_id), INDEX IDX_105F6F5267B3B43D (users_id), PRIMARY KEY(items_id, users_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_items (users_id INT NOT NULL, items_id INT NOT NULL, INDEX IDX_6694D0467B3B43D (users_id), INDEX IDX_6694D046BB0AE84 (items_id), PRIMARY KEY(users_id, items_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE items_users ADD CONSTRAINT FK_105F6F526BB0AE84 FOREIGN KEY (items_id) REFERENCES items (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE items_users ADD CONSTRAINT FK_105F6F5267B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_items ADD CONSTRAINT FK_6694D0467B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_items ADD CONSTRAINT FK_6694D046BB0AE84 FOREIGN KEY (items_id) REFERENCES items (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE items_orders DROP FOREIGN KEY FK_105F6F5267B3B43D');
        $this->addSql('ALTER TABLE items_orders DROP FOREIGN KEY FK_105F6F526BB0AE84');
        $this->addSql('ALTER TABLE users_favorites DROP FOREIGN KEY FK_6694D0467B3B43D');
        $this->addSql('ALTER TABLE users_favorites DROP FOREIGN KEY FK_6694D046BB0AE84');
        $this->addSql('DROP TABLE items_orders');
        $this->addSql('DROP TABLE users_favorites');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE items_orders (items_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_105F6F526BB0AE84 (items_id), INDEX IDX_105F6F5267B3B43D (users_id), PRIMARY KEY(items_id, users_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE users_favorites (users_id INT NOT NULL, items_id INT NOT NULL, INDEX IDX_6694D0467B3B43D (users_id), INDEX IDX_6694D046BB0AE84 (items_id), PRIMARY KEY(users_id, items_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE items_orders ADD CONSTRAINT FK_105F6F5267B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE items_orders ADD CONSTRAINT FK_105F6F526BB0AE84 FOREIGN KEY (items_id) REFERENCES items (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_favorites ADD CONSTRAINT FK_6694D0467B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_favorites ADD CONSTRAINT FK_6694D046BB0AE84 FOREIGN KEY (items_id) REFERENCES items (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE items_users DROP FOREIGN KEY FK_105F6F526BB0AE84');
        $this->addSql('ALTER TABLE items_users DROP FOREIGN KEY FK_105F6F5267B3B43D');
        $this->addSql('ALTER TABLE users_items DROP FOREIGN KEY FK_6694D0467B3B43D');
        $this->addSql('ALTER TABLE users_items DROP FOREIGN KEY FK_6694D046BB0AE84');
        $this->addSql('DROP TABLE items_users');
        $this->addSql('DROP TABLE users_items');
    }
}
