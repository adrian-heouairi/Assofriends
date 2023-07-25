<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210321162419 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE adhesion (user_adherent_id INTEGER NOT NULL, association_id INTEGER NOT NULL, date_fin DATETIME NOT NULL, renouvellement_automatique BOOLEAN NOT NULL, relance_envoyee BOOLEAN NOT NULL, PRIMARY KEY(user_adherent_id, association_id))');
        $this->addSql('CREATE INDEX IDX_C50CA65A8CEBA5C6 ON adhesion (user_adherent_id)');
        $this->addSql('CREATE INDEX IDX_C50CA65AEFB9C8A5 ON adhesion (association_id)');
        $this->addSql('CREATE TABLE article_de_news (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, association_id INTEGER NOT NULL, titre VARCHAR(50) NOT NULL, contenu CLOB NOT NULL, date DATETIME NOT NULL)');
        $this->addSql('CREATE INDEX IDX_D1AA7380EFB9C8A5 ON article_de_news (association_id)');
        $this->addSql('CREATE TABLE association (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_gerant_id INTEGER NOT NULL, nom VARCHAR(50) NOT NULL, description VARCHAR(1000) NOT NULL, prix_adhesion_mensuelle DOUBLE PRECISION NOT NULL, formule_actuelle INTEGER NOT NULL, date_fin_formule DATETIME DEFAULT NULL, formule_mois_suivant INTEGER DEFAULT NULL)');
        $this->addSql('CREATE INDEX IDX_FD8521CCA5E024C0 ON association (user_gerant_id)');
        $this->addSql('CREATE TABLE campagne_de_don (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, association_id INTEGER NOT NULL, nom VARCHAR(50) NOT NULL, description VARCHAR(1000) NOT NULL, montant_recolte DOUBLE PRECISION NOT NULL)');
        $this->addSql('CREATE INDEX IDX_D5E9B0FEEFB9C8A5 ON campagne_de_don (association_id)');
        $this->addSql('CREATE TABLE campagne_de_financement_participatif (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, association_id INTEGER NOT NULL, nom VARCHAR(50) NOT NULL, description VARCHAR(1000) NOT NULL, montant_recolte DOUBLE PRECISION NOT NULL, montant_objectif DOUBLE PRECISION NOT NULL)');
        $this->addSql('CREATE INDEX IDX_48185C7EFB9C8A5 ON campagne_de_financement_participatif (association_id)');
        $this->addSql('CREATE TABLE commentaire (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_auteur_id INTEGER NOT NULL, association_id INTEGER NOT NULL, contenu VARCHAR(1000) NOT NULL, date DATETIME NOT NULL)');
        $this->addSql('CREATE INDEX IDX_67F068BC605BE202 ON commentaire (user_auteur_id)');
        $this->addSql('CREATE INDEX IDX_67F068BCEFB9C8A5 ON commentaire (association_id)');
        $this->addSql('CREATE TABLE evenement (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, association_id INTEGER NOT NULL, nom VARCHAR(50) NOT NULL, description VARCHAR(1000) NOT NULL, prix_billet DOUBLE PRECISION NOT NULL, montant_recolte DOUBLE PRECISION NOT NULL)');
        $this->addSql('CREATE INDEX IDX_B26681EEFB9C8A5 ON evenement (association_id)');
        $this->addSql('CREATE TABLE evenement_user (evenement_id INTEGER NOT NULL, user_id INTEGER NOT NULL, PRIMARY KEY(evenement_id, user_id))');
        $this->addSql('CREATE INDEX IDX_2EC0B3C4FD02F13 ON evenement_user (evenement_id)');
        $this->addSql('CREATE INDEX IDX_2EC0B3C4A76ED395 ON evenement_user (user_id)');
        $this->addSql('CREATE TABLE user (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles CLOB NOT NULL --(DC2Type:json)
        , password VARCHAR(255) NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649E7927C74 ON user (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE adhesion');
        $this->addSql('DROP TABLE article_de_news');
        $this->addSql('DROP TABLE association');
        $this->addSql('DROP TABLE campagne_de_don');
        $this->addSql('DROP TABLE campagne_de_financement_participatif');
        $this->addSql('DROP TABLE commentaire');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE evenement_user');
        $this->addSql('DROP TABLE user');
    }
}
