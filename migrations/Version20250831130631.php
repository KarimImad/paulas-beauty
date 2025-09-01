<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250831130631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_service ADD customer_order_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE order_service ADD CONSTRAINT FK_17E73399A15A2E17 FOREIGN KEY (customer_order_id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE order_service ADD CONSTRAINT FK_17E73399ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('CREATE INDEX IDX_17E73399A15A2E17 ON order_service (customer_order_id)');
        $this->addSql('CREATE INDEX IDX_17E73399ED5CA9E6 ON order_service (service_id)');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('CREATE INDEX IDX_794381C6ED5CA9E6 ON review (service_id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD212469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_E19D9AD212469DE2 ON service (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD212469DE2');
        $this->addSql('DROP INDEX IDX_E19D9AD212469DE2 ON service');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6ED5CA9E6');
        $this->addSql('DROP INDEX IDX_794381C6ED5CA9E6 ON review');
        $this->addSql('ALTER TABLE order_service DROP FOREIGN KEY FK_17E73399A15A2E17');
        $this->addSql('ALTER TABLE order_service DROP FOREIGN KEY FK_17E73399ED5CA9E6');
        $this->addSql('DROP INDEX IDX_17E73399A15A2E17 ON order_service');
        $this->addSql('DROP INDEX IDX_17E73399ED5CA9E6 ON order_service');
        $this->addSql('ALTER TABLE order_service DROP customer_order_id');
    }
}
