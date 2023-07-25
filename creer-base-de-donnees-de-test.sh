#!/bin/bash

# Lancer une seule fois ce script. Après cela, on peut effectuer les tests unitaires en lançant la commande « php vendor/bin/phpunit ».

rm var/data_test.db
php bin/console --env=test doctrine:migrations:migrate
php bin/console --env=test doctrine:fixtures:load
