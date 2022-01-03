TO SECURE API
1. composer require symfony/security-bundle
2. php bin/console make:user
3. php composer.phar require "lexik/jwt-authentication-bundle"
4. php bin/console lexik:jwt:generate-keypair