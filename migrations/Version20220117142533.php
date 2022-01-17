<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220117142533 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP INDEX UNIQ_23A0E6612469DE2, ADD INDEX IDX_23A0E6612469DE2 (category_id)');
        $this->addSql('ALTER TABLE article DROP INDEX UNIQ_23A0E661BC7E6B6, ADD INDEX IDX_23A0E661BC7E6B6 (writer_id)');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66C5686C7A');
        $this->addSql('ALTER TABLE article DROP FOREIGN KEY FK_23A0E66A21214B7');
        $this->addSql('DROP INDEX IDX_23A0E66C5686C7A ON article');
        $this->addSql('DROP INDEX IDX_23A0E66A21214B7 ON article');
        $this->addSql('ALTER TABLE article DROP categories_id, DROP writers_id, CHANGE writer_id writer_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE article DROP INDEX IDX_23A0E6612469DE2, ADD UNIQUE INDEX UNIQ_23A0E6612469DE2 (category_id)');
        $this->addSql('ALTER TABLE article DROP INDEX IDX_23A0E661BC7E6B6, ADD UNIQUE INDEX UNIQ_23A0E661BC7E6B6 (writer_id)');
        $this->addSql('ALTER TABLE article ADD categories_id INT NOT NULL, ADD writers_id INT NOT NULL, CHANGE writer_id writer_id INT NOT NULL');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66C5686C7A FOREIGN KEY (writers_id) REFERENCES writer (id)');
        $this->addSql('ALTER TABLE article ADD CONSTRAINT FK_23A0E66A21214B7 FOREIGN KEY (categories_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_23A0E66C5686C7A ON article (writers_id)');
        $this->addSql('CREATE INDEX IDX_23A0E66A21214B7 ON article (categories_id)');
    }
}
