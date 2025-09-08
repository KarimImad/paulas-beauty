<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250908085312 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders RENAME INDEX idx_f5299398a40bc2d5 TO IDX_E52FFDEEA40BC2D5');
        $this->addSql('ALTER TABLE orders RENAME INDEX idx_f5299398ed5ca9e6 TO IDX_E52FFDEEED5CA9E6');
        $this->addSql('ALTER TABLE service ADD description LONGTEXT DEFAULT NULL, DROP price');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orders RENAME INDEX idx_e52ffdeea40bc2d5 TO IDX_F5299398A40BC2D5');
        $this->addSql('ALTER TABLE orders RENAME INDEX idx_e52ffdeeed5ca9e6 TO IDX_F5299398ED5CA9E6');
        $this->addSql('ALTER TABLE service ADD price DOUBLE PRECISION NOT NULL, DROP description');
    }
}
