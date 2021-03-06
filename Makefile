
install: vendor

vendor: composer.phar
	@php ./composer.phar install

composer.phar:
	@curl -sS https://getcomposer.org/installer | php

test: install
	@vendor/bin/phpunit --colors test/
	@php ./composer.phar validate

release:
	@printf "releasing ${VERSION}..."
	@printf '<?php\nglobal $$PLAINFLOW_VERSION;\n$$PLAINFLOW_VERSION = "%b";\n?>' ${VERSION} > ./lib/Plainflow/Version.php
	@node -e "var fs = require('fs'), pkg = require('./composer'); pkg.version = '${VERSION}'; fs.writeFileSync('./composer.json', JSON.stringify(pkg, null, '\t'));"
	@git tag ${VERSION}
	@git push --tags

clean:
	rm -rf \
		composer.phar \
		vendor \
		composer.lock

.PHONY: test release
