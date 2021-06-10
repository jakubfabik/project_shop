<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210418094114 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_F36BA2DE1FF72955');
        $this->addSql('CREATE TEMPORARY TABLE __temp__objednavka AS SELECT id, pouzivatel_id, cas_vytvorenia, cas_odoslania, stav_objednavky FROM objednavka');
        $this->addSql('DROP TABLE objednavka');
        $this->addSql('CREATE TABLE objednavka (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user INTEGER DEFAULT NULL, cas_vytvorenia DATETIME NOT NULL, cas_odoslania DATETIME NOT NULL, stav_objednavky VARCHAR(10) NOT NULL COLLATE BINARY, CONSTRAINT FK_F36BA2DE1FF72955 FOREIGN KEY (user) REFERENCES pouzivatel (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO objednavka (id, user, cas_vytvorenia, cas_odoslania, stav_objednavky) SELECT id, user, cas_vytvorenia, cas_odoslania, stav_objednavky FROM __temp__objednavka');
        $this->addSql('DROP TABLE __temp__objednavka');
        $this->addSql('CREATE INDEX IDX_F36BA2DE1FF72955 ON objednavka (pouzivatel_id)');
        $this->addSql('DROP INDEX IDX_D49DE0A93262CEDC');
        $this->addSql('DROP INDEX IDX_D49DE0A9359B0684');
        $this->addSql('CREATE TEMPORARY TABLE __temp__polozka_kategoria AS SELECT polozka_id, kategoria_id FROM polozka_kategoria');
        $this->addSql('DROP TABLE polozka_kategoria');
        $this->addSql('CREATE TABLE polozka_kategoria (polozka_id INTEGER NOT NULL, kategoria_id INTEGER NOT NULL, PRIMARY KEY(polozka_id, kategoria_id))');
        $this->addSql('INSERT INTO polozka_kategoria (polozka_id, kategoria_id) SELECT polozka_id, kategoria_id FROM __temp__polozka_kategoria');
        $this->addSql('DROP TABLE __temp__polozka_kategoria');
        $this->addSql('CREATE INDEX IDX_D49DE0A93262CEDC ON polozka_kategoria (polozka_id)');
        $this->addSql('CREATE INDEX IDX_D49DE0A9359B0684 ON polozka_kategoria (kategoria_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_F36BA2DE1FF72955');
        $this->addSql('CREATE TEMPORARY TABLE __temp__objednavka AS SELECT id, pouzivatel_id, cas_vytvorenia, cas_odoslania, stav_objednavky FROM objednavka');
        $this->addSql('DROP TABLE objednavka');
        $this->addSql('CREATE TABLE objednavka (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user INTEGER DEFAULT NULL, cas_vytvorenia DATETIME NOT NULL, zoznam_poloziek  VARCHAR(50) NOT NULL, cas_odoslania DATETIME NOT NULL, stav_objednavky VARCHAR(10) NOT NULL COLLATE BINARY, CONSTRAINT FK_F36BA2DE1FF72955 FOREIGN KEY (user) REFERENCES pouzivatel (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO objednavka (id, user, cas_vytvorenia, cas_odoslania, stav_objednavky, zoznam_poloziek) SELECT id, user, cas_vytvorenia, cas_odoslania, stav_objednavky, zoznam_poloziek FROM __temp__objednavka');
        $this->addSql('DROP TABLE __temp__objednavka');
        $this->addSql('CREATE INDEX IDX_F36BA2DE1FF72955 ON objednavka (pouzivatel_id)');
        $this->addSql('DROP INDEX IDX_D49DE0A93262CEDC');
        $this->addSql('DROP INDEX IDX_D49DE0A9359B0684');
        $this->addSql('CREATE TEMPORARY TABLE __temp__polozka_kategoria AS SELECT polozka_id, kategoria_id FROM polozka_kategoria');
        $this->addSql('DROP TABLE polozka_kategoria');
        $this->addSql('CREATE TABLE polozka_kategoria (polozka_id INTEGER NOT NULL, kategoria_id INTEGER NOT NULL, PRIMARY KEY(polozka_id, kategoria_id))');
        $this->addSql('INSERT INTO polozka_kategoria (polozka_id, kategoria_id) SELECT polozka_id, kategoria_id FROM __temp__polozka_kategoria');
        $this->addSql('DROP TABLE __temp__polozka_kategoria');
        $this->addSql('CREATE INDEX IDX_D49DE0A93262CEDC ON polozka_kategoria (polozka_id)');
        $this->addSql('CREATE INDEX IDX_D49DE0A9359B0684 ON polozka_kategoria (kategoria_id)');
    }
}
