#!/bin/bash

# Avant 3.0, phpDocumentor ne supporte pas la syntaxe « ?type » (nullable types).
# Ce script enlève donc temporairement les points d'interrogation.

[ -d src ] || exit 1

[ -e /tmp/assofriends-src ] && rm -r /tmp/assofriends-src
[ -e /tmp/assofriends-src ] && exit 1

[ -e /tmp/assofriends-phpdoc ] && rm -r /tmp/assofriends-phpdoc
[ -e /tmp/assofriends-phpdoc ] && exit 1

cp -r src /tmp/assofriends-src || exit 1

sed -i 's/ ?/ /g; s/(?/(/g' /tmp/assofriends-src/Entity/* || exit 1

phpdoc -d /tmp/assofriends-src -t /tmp/assofriends-phpdoc
