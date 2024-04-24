<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240424142635 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, category VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categories_subcategories (categories_id INT NOT NULL, subcategories_id INT NOT NULL, INDEX IDX_910811F0A21214B7 (categories_id), INDEX IDX_910811F0EF1B3128 (subcategories_id), PRIMARY KEY(categories_id, subcategories_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE comments (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, item_id INT NOT NULL, comment LONGTEXT DEFAULT NULL, vote TINYINT(1) DEFAULT NULL, INDEX IDX_5F9E962AF675F31B (author_id), INDEX IDX_5F9E962A126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE conditions (id INT AUTO_INCREMENT NOT NULL, status VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE items (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, subcategory_id INT NOT NULL, status_id INT NOT NULL, seller_id INT NOT NULL, name VARCHAR(20) NOT NULL, created_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', updated_at DATE DEFAULT NULL, price DOUBLE PRECISION NOT NULL, stock INT NOT NULL, description LONGTEXT NOT NULL, image_name VARCHAR(255) DEFAULT NULL, INDEX IDX_E11EE94D12469DE2 (category_id), INDEX IDX_E11EE94D5DC6FE57 (subcategory_id), INDEX IDX_E11EE94D6BF700BD (status_id), INDEX IDX_E11EE94D8DE820D9 (seller_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE items_users (items_id INT NOT NULL, users_id INT NOT NULL, INDEX IDX_105F6F526BB0AE84 (items_id), INDEX IDX_105F6F5267B3B43D (users_id), PRIMARY KEY(items_id, users_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subcategories (id INT AUTO_INCREMENT NOT NULL, subcategory VARCHAR(20) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, username VARCHAR(15) NOT NULL, confirmed TINYINT(1) NOT NULL, created_at DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', updated_at DATE DEFAULT NULL, image_name VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE users_items (users_id INT NOT NULL, items_id INT NOT NULL, INDEX IDX_6694D0467B3B43D (users_id), INDEX IDX_6694D046BB0AE84 (items_id), PRIMARY KEY(users_id, items_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE categories_subcategories ADD CONSTRAINT FK_910811F0A21214B7 FOREIGN KEY (categories_id) REFERENCES categories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE categories_subcategories ADD CONSTRAINT FK_910811F0EF1B3128 FOREIGN KEY (subcategories_id) REFERENCES subcategories (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962AF675F31B FOREIGN KEY (author_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE comments ADD CONSTRAINT FK_5F9E962A126F525E FOREIGN KEY (item_id) REFERENCES items (id)');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94D12469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94D5DC6FE57 FOREIGN KEY (subcategory_id) REFERENCES subcategories (id)');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94D6BF700BD FOREIGN KEY (status_id) REFERENCES conditions (id)');
        $this->addSql('ALTER TABLE items ADD CONSTRAINT FK_E11EE94D8DE820D9 FOREIGN KEY (seller_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE items_users ADD CONSTRAINT FK_105F6F526BB0AE84 FOREIGN KEY (items_id) REFERENCES items (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE items_users ADD CONSTRAINT FK_105F6F5267B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_items ADD CONSTRAINT FK_6694D0467B3B43D FOREIGN KEY (users_id) REFERENCES users (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE users_items ADD CONSTRAINT FK_6694D046BB0AE84 FOREIGN KEY (items_id) REFERENCES items (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categories_subcategories DROP FOREIGN KEY FK_910811F0A21214B7');
        $this->addSql('ALTER TABLE categories_subcategories DROP FOREIGN KEY FK_910811F0EF1B3128');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962AF675F31B');
        $this->addSql('ALTER TABLE comments DROP FOREIGN KEY FK_5F9E962A126F525E');
        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94D12469DE2');
        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94D5DC6FE57');
        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94D6BF700BD');
        $this->addSql('ALTER TABLE items DROP FOREIGN KEY FK_E11EE94D8DE820D9');
        $this->addSql('ALTER TABLE items_users DROP FOREIGN KEY FK_105F6F526BB0AE84');
        $this->addSql('ALTER TABLE items_users DROP FOREIGN KEY FK_105F6F5267B3B43D');
        $this->addSql('ALTER TABLE users_items DROP FOREIGN KEY FK_6694D0467B3B43D');
        $this->addSql('ALTER TABLE users_items DROP FOREIGN KEY FK_6694D046BB0AE84');
        $this->addSql('DROP TABLE categories');
        $this->addSql('DROP TABLE categories_subcategories');
        $this->addSql('DROP TABLE comments');
        $this->addSql('DROP TABLE conditions');
        $this->addSql('DROP TABLE items');
        $this->addSql('DROP TABLE items_users');
        $this->addSql('DROP TABLE subcategories');
        $this->addSql('DROP TABLE users');
        $this->addSql('DROP TABLE users_items');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
