#!/usr/bin/env bash

set -e

echo "php-cs-fixer start"

PHP_CS_FIXER_LOCAL="./vendor/bin/php-cs-fixer"
PHP_CS_FIXER_GLOBAL="~/.composer/vendor/bin/php-cs-fixer"

if [ -x $PHP_CS_FIXER_GLOBAL ]; then
    PHP_CS_FIXER=$PHP_CS_FIXER_GLOBAL
else
    PHP_CS_FIXER=$PHP_CS_FIXER_LOCAL
fi

if [ -x $PHP_CS_FIXER ]; then
    if git diff --cached --name-only --diff-filter=ACMRTUXB | grep -q '\.php$'; then
        STAGED_FILES=$(git diff --cached --name-only --diff-filter=ACMRTUXB | grep '\.php$')
        $PHP_CS_FIXER fix --verbose --allow-risky=yes --config=.php_cs -- ${STAGED_FILES[@]};
        git add ${STAGED_FILES[@]}
    fi
else
    echo ""
    echo "Please install php-cs-fixer, e.g.:"
    echo ""
    echo "    composer global require friendsofphp/php-cs-fixer"
    echo " or composer require --dev friendsofphp/php-cs-fixer"
    echo ""
fi
