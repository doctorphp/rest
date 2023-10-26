.PHONY: stan
stan:
	php -d memory_limit=256M vendor/bin/phpstan analyse src -c phpstan.neon --level 8

.PHONY: cs
cs:
	vendor/bin/phpcs --standard=vendor/contributte/dev/ruleset.xml --extensions=php,phpt --tab-width=4 --ignore=temp -sp src

.PHONY: csf
csf:
	vendor/bin/phpcbf --standard=vendor/contributte/dev/ruleset.xml --extensions=php,phpt --tab-width=4 --ignore=temp -sp src
