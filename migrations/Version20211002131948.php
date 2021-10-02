<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211002131948 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE lab_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE person_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE lab (id INT NOT NULL, student_id INT NOT NULL, teacher_id INT NOT NULL, name VARCHAR(255) NOT NULL, mark INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_61D6B1C4CB944F1A ON lab (student_id)');
        $this->addSql('CREATE INDEX IDX_61D6B1C441807E1D ON lab (teacher_id)');
        $this->addSql('CREATE TABLE person (id INT NOT NULL, first_name VARCHAR(255) NOT NULL, second_name VARCHAR(255) NOT NULL, gender VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE lab ADD CONSTRAINT FK_61D6B1C4CB944F1A FOREIGN KEY (student_id) REFERENCES person (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE lab ADD CONSTRAINT FK_61D6B1C441807E1D FOREIGN KEY (teacher_id) REFERENCES person (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE lab DROP CONSTRAINT FK_61D6B1C4CB944F1A');
        $this->addSql('ALTER TABLE lab DROP CONSTRAINT FK_61D6B1C441807E1D');
        $this->addSql('DROP SEQUENCE lab_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE person_id_seq CASCADE');
        $this->addSql('DROP TABLE lab');
        $this->addSql('DROP TABLE person');
    }
}
