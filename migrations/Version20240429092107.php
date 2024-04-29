<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240429092107 extends AbstractMigration
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
        $this->addSql('DROP TABLE users_favorites');
        $this->addSql('DROP TABLE items_orders');
        $this->addSql('ALTER TABLE categories_subcategories ADD CONSTRAINT FK_910811F0A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categories_subcategories ADD CONSTRAINT FK_910811F0EF1B3128 FOREIGN KEY (subcategories_id) REFERENCES subcategories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AF675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A126F525E FOREIGN KEY (item_id) REFERENCES items (id)');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94D12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94D5DC6FE57 FOREIGN KEY (subcategory_id) REFERENCES subcategories (id)');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94D6BF700BD FOREIGN KEY (status_id) REFERENCES conditions (id)');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94D8DE820D9 FOREIGN KEY (seller_id) REFERENCES users (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users_favorites (users_id INT NOT NULL, items_id INT NOT NULL, INDEX IDX_6694D0467B3B43D (users_id), INDEX IDX_6694D046BB0AE84 (items_id), PRIMARY KEY(users_id, items_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE items_orders (items_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_105F6F5267B3B43D (users_id), INDEX IDX_105F6F526BB0AE84 (items_id), PRIMARY KEY(items_id, users_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE items_users DROP FOREIGN KEY FK_105F6F526BB0AE84');
        $this->addSql('ALTER TABLE items_users DROP FOREIGN KEY FK_105F6F5267B3B43D');
        $this->addSql('ALTER TABLE users_items DROP FOREIGN KEY FK_6694D0467B3B43D');
        $this->addSql('ALTER TABLE users_items DROP FOREIGN KEY FK_6694D046BB0AE84');
        $this->addSql('DROP TABLE items_users');
        $this->addSql('DROP TABLE users_items');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AF675F31B');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A126F525E');
        $this->addSql('ALTER TABLE categories_subcategories DROP FOREIGN KEY FK_910811F0A21214B7');
        $this->addSql('ALTER TABLE categories_subcategories DROP FOREIGN KEY FK_910811F0EF1B3128');
        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94D12469DE2');
        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94D5DC6FE57');
        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94D6BF700BD');
        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94D8DE820D9');
    }
}
