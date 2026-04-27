#!/usr/bin/env bash
# One-shot: clone ONLY backend/ into public_html/backend (no separate repo folder).
# Usage (replace path):
#   bash backend/scripts/git-clone-into-public-html-backend.sh /home/USER/domains/DOMAIN/public_html/backend
#
# Requires: git 2.25+, empty or removable target (script does rm -rf <folder> then mkdir).

set -euo pipefail
WEB_ROOT="${1:?Usage: $0 /home/USER/domains/DOMAIN/public_html/backend}"
PARENT="$(dirname "$WEB_ROOT")"
NAME="$(basename "$WEB_ROOT")"

cd "$PARENT"
rm -rf "$NAME"
mkdir "$NAME"
cd "$NAME"

git clone --filter=blob:none --sparse -b main https://github.com/kass2024/claude_web.git .
git sparse-checkout set backend

cp -a backend/public/. .

cat >index.php <<'PHP'
<?php

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/backend/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/backend/vendor/autoload.php';

/** @var Application $app */
$app = require_once __DIR__.'/backend/bootstrap/app.php';

$app->handleRequest(Request::capture());
PHP

cat >backend/.htaccess <<'HTACCESS'
<IfModule mod_authz_core.c>
    Require all denied
</IfModule>
HTACCESS

echo "OK: Laravel is under $WEB_ROOT (inner folder backend/) with web root files in $WEB_ROOT/"
echo "Next: cd $WEB_ROOT/backend && composer install --no-dev --optimize-autoloader && cp .env.production.example .env && nano .env"
echo "Then: php artisan key:generate --force && php artisan migrate --force && php artisan db:seed --force"
echo "     php artisan storage:link && php artisan config:cache && php artisan route:cache"
