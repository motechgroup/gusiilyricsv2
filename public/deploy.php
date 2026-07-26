<?php
/**
 * Shared Hosting Browser Deployment & Maintenance Tool for GusiiLyrics.com
 * Access via: https://gusiilyrics.com/deploy.php?secret=deploy123
 */

define('LARAVEL_START', microtime(true));

// Auto-detect vendor & bootstrap paths for shared hosting
$autoloadPath = file_exists(__DIR__ . '/../vendor/autoload.php') 
    ? __DIR__ . '/../vendor/autoload.php' 
    : __DIR__ . '/vendor/autoload.php';

$bootstrapPath = file_exists(__DIR__ . '/../bootstrap/app.php') 
    ? __DIR__ . '/../bootstrap/app.php' 
    : __DIR__ . '/bootstrap/app.php';

if (!file_exists($autoloadPath)) {
    echo "<!DOCTYPE html><html><head><title>Deployment Error</title><style>body{font-family:sans-serif;background:#090d16;color:#fff;padding:2rem;}</style></head><body>";
    echo "<h2 style='color:#ef4444;'>❌ Vendor Directory Not Found</h2>";
    echo "<p>The <code>vendor/</code> directory is missing on your server. Please upload your project's <code>vendor</code> folder or unzip vendor files onto your shared hosting server.</p>";
    echo "</body></html>";
    exit;
}

require $autoloadPath;
$app = require_once $bootstrapPath;

// Bootstrap console kernel to enable Artisan commands
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

// Clear configuration cache so .env edits take effect immediately
try {
    Artisan::call('config:clear');
} catch (\Exception $e) {}

$SECRET_KEY = "deploy123";
$providedKey = $_REQUEST['secret'] ?? '';

if ($providedKey !== $SECRET_KEY) {
    header('HTTP/1.1 403 Forbidden');
    echo "<!DOCTYPE html><html><head><title>Access Denied</title><style>body{font-family:sans-serif;background:#090d16;color:#fff;display:flex;align-items:center;justify-content:center;height:100vh;margin:0;}.card{background:#111827;padding:2rem;border-radius:1rem;border:1px solid #1f2937;max-width:400px;width:100%;text-align:center;}input,button{width:100%;padding:0.75rem;margin-top:1rem;border-radius:0.5rem;border:1px solid #374151;box-sizing:border-box;}input{background:#030712;color:#fff;}button{background:#10b981;color:#000;font-weight:bold;cursor:pointer;}</style></head><body>";
    echo "<div class='card'>";
    echo "<h2 style='color:#10b981;margin-top:0;'>🔒 GusiiLyrics Web Deployer</h2>";
    echo "<p style='color:#9ca3af;font-size:0.875rem;'>Enter the deployment secret key to manage your live site database and caches from your browser.</p>";
    echo "<form method='GET'><input type='password' name='secret' placeholder='Enter secret key...' required><button type='submit'>Access Deployment Panel</button></form>";
    echo "</div></body></html>";
    exit;
}

$action = $_REQUEST['action'] ?? '';
$outputLog = [];
$dbStatus = 'Unknown';
$dbError = '';

try {
    DB::connection()->getPdo();
    $dbStatus = 'Connected (' . DB::connection()->getDatabaseName() . ')';
} catch (\Exception $e) {
    $dbStatus = 'Disconnected';
    $dbError = $e->getMessage();
}

if ($action === 'full_deploy') {
    try {
        Artisan::call('key:generate', ['--force' => true]);
        $outputLog[] = "🔑 Key Generate: " . Artisan::output();

        Artisan::call('migrate:fresh', ['--force' => true, '--seed' => true]);
        $outputLog[] = "📦 Database Migrate & Seed: " . Artisan::output();

        Artisan::call('storage:link', ['--force' => true]);
        $outputLog[] = "🔗 Storage Link: " . Artisan::output();

        Artisan::call('config:cache');
        $outputLog[] = "⚡ Config Cache: " . Artisan::output();

        Artisan::call('route:cache');
        $outputLog[] = "⚡ Route Cache: " . Artisan::output();

        Artisan::call('view:cache');
        $outputLog[] = "⚡ View Cache: " . Artisan::output();

        $outputLog[] = "✅ Full Browser Deployment Executed Successfully!";
    } catch (\Exception $e) {
        $outputLog[] = "❌ Error during deployment: " . $e->getMessage();
    }
} elseif ($action === 'migrate_seed') {
    try {
        Artisan::call('migrate:fresh', ['--force' => true, '--seed' => true]);
        $outputLog[] = "📦 Database Migrate & Seed Output:\n" . Artisan::output();
    } catch (\Exception $e) {
        $outputLog[] = "❌ Migration Error: " . $e->getMessage();
    }
} elseif ($action === 'clear_cache') {
    try {
        Artisan::call('optimize:clear');
        $outputLog[] = "🧹 Cache Clear Output:\n" . Artisan::output();
    } catch (\Exception $e) {
        $outputLog[] = "❌ Cache Clear Error: " . $e->getMessage();
    }
} elseif ($action === 'storage_link') {
    try {
        Artisan::call('storage:link', ['--force' => true]);
        $outputLog[] = "🔗 Storage Link Output:\n" . Artisan::output();
    } catch (\Exception $e) {
        $outputLog[] = "❌ Storage Link Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GusiiLyrics Shared Hosting Browser Deployment</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #090d16; color: #f3f4f6; margin: 0; padding: 2rem; }
        .container { max-w: 800px; margin: 0 auto; background: #111827; border: 1px solid #1f2937; border-radius: 1.5rem; padding: 2rem; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); }
        h1 { margin-top: 0; color: #10b981; font-size: 1.5rem; display: flex; align-items: center; gap: 0.5rem; }
        .badge { background: #064e3b; color: #34d399; font-size: 0.75rem; padding: 0.25rem 0.75rem; border-radius: 9999px; border: 1px solid #059669; }
        .status-box { background: #030712; border: 1px solid #1f2937; border-radius: 1rem; padding: 1rem; margin: 1.5rem 0; font-size: 0.875rem; }
        .status-item { display: flex; justify-content: space-between; margin-bottom: 0.5rem; }
        .status-item:last-child { margin-bottom: 0; }
        .btn-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; margin-bottom: 1.5rem; }
        .btn { display: inline-flex; align-items: center; justify-content: center; padding: 0.875rem 1rem; border-radius: 0.75rem; font-weight: bold; text-decoration: none; font-size: 0.875rem; border: none; cursor: pointer; transition: background 0.2s; }
        .btn-primary { background: #10b981; color: #022c22; }
        .btn-primary:hover { background: #34d399; }
        .btn-secondary { background: #1f2937; color: #f3f4f6; border: 1px solid #374151; }
        .btn-secondary:hover { background: #374151; }
        .log-box { background: #030712; border: 1px solid #1f2937; border-radius: 1rem; padding: 1rem; font-family: monospace; font-size: 0.8125rem; color: #a7f3d0; white-space: pre-wrap; word-break: break-word; max-height: 400px; overflow-y: auto; }
        a { color: #34d399; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 GusiiLyrics Web Deployer <span class="badge">Shared Hosting</span></h1>
        <p style="color: #9ca3af; font-size: 0.875rem;">Run database migrations, seeders, and optimization commands directly from your web browser without terminal access.</p>

        <div class="status-box">
            <div class="status-item">
                <span>PHP Environment:</span>
                <strong style="color: #34d399;">PHP <?= PHP_VERSION ?> (Compatible)</strong>
            </div>
            <div class="status-item">
                <span>Database Connection:</span>
                <strong style="color: <?= $dbStatus === 'Disconnected' ? '#ef4444' : '#34d399' ?>;"><?= htmlspecialchars($dbStatus) ?></strong>
            </div>
            <?php if ($dbError): ?>
                <div style="color: #ef4444; font-size: 0.75rem; margin-top: 0.5rem; word-break: break-all;">
                    ⚠️ Error: <?= htmlspecialchars($dbError) ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="btn-grid">
            <a href="?secret=<?= urlencode($SECRET_KEY) ?>&action=full_deploy" class="btn btn-primary" onclick="return confirm('Run full deployment (Key Gen, Fresh Migrate, Seed, Caches)?');">
                ⚡ Run Full Deployment
            </a>
            <a href="?secret=<?= urlencode($SECRET_KEY) ?>&action=migrate_seed" class="btn btn-secondary" onclick="return confirm('Migrate fresh and seed database?');">
                📦 Migrate & Seed Database
            </a>
            <a href="?secret=<?= urlencode($SECRET_KEY) ?>&action=clear_cache" class="btn btn-secondary">
                🧹 Clear All Caches
            </a>
            <a href="?secret=<?= urlencode($SECRET_KEY) ?>&action=storage_link" class="btn btn-secondary">
                🔗 Create Storage Link
            </a>
        </div>

        <?php if (!empty($outputLog)): ?>
            <h3 style="font-size: 1rem; color: #f3f4f6;">Execution Log</h3>
            <div class="log-box"><?= htmlspecialchars(implode("\n\n----------------------------------------\n\n", $outputLog)) ?></div>
        <?php endif; ?>

        <div style="margin-top: 2rem; border-top: 1px solid #1f2937; pt-4; text-align: center; font-size: 0.75rem; color: #6b7280;">
            <p>After completing your deployment, you can log into your staff dashboard at <a href="/mkuu" target="_blank">/mkuu</a>.</p>
        </div>
    </div>
</body>
</html>
