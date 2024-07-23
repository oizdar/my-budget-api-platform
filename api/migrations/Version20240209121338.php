<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240209121338 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE IF EXISTS greeting_id_seq CASCADE');
        $this->addSql('CREATE TABLE budget (id INT NOT NULL, date_from DATE NOT NULL, date_to DATE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN budget.date_from IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN budget.date_to IS \'(DC2Type:date_immutable)\'');
        $this->addSql('CREATE TABLE budgetTransactions (budget_id INT NOT NULL, transaction_id INT NOT NULL, PRIMARY KEY(budget_id, transaction_id))');
        $this->addSql('CREATE INDEX IDX_DA2E351536ABA6B8 ON budgetTransactions (budget_id)');
        $this->addSql('CREATE INDEX IDX_DA2E35152FC0CB0F ON budgetTransactions (transaction_id)');
        $this->addSql('CREATE TABLE category (id INT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE plan_configuration (id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE transaction (id INT NOT NULL, category_id INT DEFAULT NULL, comment VARCHAR(255) NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, amount_amount INT NOT NULL, amount_currency_code VARCHAR(3) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_723705D112469DE2 ON transaction (category_id)');
        $this->addSql('ALTER TABLE budgetTransactions ADD CONSTRAINT FK_DA2E351536ABA6B8 FOREIGN KEY (budget_id) REFERENCES budget (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE budgetTransactions ADD CONSTRAINT FK_DA2E35152FC0CB0F FOREIGN KEY (transaction_id) REFERENCES transaction (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D112469DE2 FOREIGN KEY (category_id) REFERENCES category (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE SEQUENCE greeting_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('ALTER TABLE budgetTransactions DROP CONSTRAINT FK_DA2E351536ABA6B8');
        $this->addSql('ALTER TABLE budgetTransactions DROP CONSTRAINT FK_DA2E35152FC0CB0F');
        $this->addSql('ALTER TABLE transaction DROP CONSTRAINT FK_723705D112469DE2');
        $this->addSql('DROP TABLE budget');
        $this->addSql('DROP TABLE budgetTransactions');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE plan_configuration');
        $this->addSql('DROP TABLE transaction');
    }
}
