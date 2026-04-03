<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260331134646 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql("INSERT INTO shipping_rate (max_weight_kg, price, label) VALUES (5,  5.00,  'Colis léger < 5 kg')");
        $this->addSql("INSERT INTO shipping_rate (max_weight_kg, price, label) VALUES (10, 10.00, 'Colis moyen 5-10 kg')");
        $this->addSql("INSERT INTO shipping_rate (max_weight_kg, price, label) VALUES (30, 20.00, 'Colis lourd 10-30 kg')");
        $this->addSql("INSERT INTO shipping_rate (max_weight_kg, price, label) VALUES (NULL, 50.00, 'Colis très lourd')");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
    }
}
