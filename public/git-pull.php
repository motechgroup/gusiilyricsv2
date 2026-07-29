<?php
/**
 * Browser Git Pull & Update Tool for GusiiLyrics.com
 * Access via: https://gusiilyrics.com/git-pull.php?secret=deploy123
 */

define('LARAVEL_START', microtime(true));

// Auto-detect vendor & bootstrap paths
$autoloadPath = file_exists(__DIR__ . '/../vendor/autoload.php') 
    ? __DIR__ . '/../vendor/autoload.php' 
    : __DIR__ . '/vendor/autoload.php';

$bootstrapPath = file_exists(__DIR__ . '/../bootstrap/app.php') 
    ? __DIR__ . '/../bootstrap/app.php' 
    : __DIR__ . '/bootstrap/app.php';

if (file_exists($autoloadPath) && file_exists($bootstrapPath)) {
    require $autoloadPath;
    $app = require_once $bootstrapPath;
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
}

$SECRET_KEY = "deploy123";
$providedKey = $_REQUEST['secret'] ?? '';

if ($providedKey !== $SECRET_KEY) {
    header('HTTP/1.1 403 Forbidden');
    echo "<!DOCTYPE html><html><head><title>Access Denied</title><style>body{font-family:sans-serif;background:#090d16;color:#fff;display:flex;align-items:center;justify-content:center;height:100vh;margin:0;}.card{background:#111827;padding:2rem;border-radius:1rem;border:1px solid #1f2937;max-width:400px;width:100%;text-align:center;}input,button{width:100%;padding:0.75rem;margin-top:1rem;border-radius:0.5rem;border:1px solid #374151;box-sizing:border-box;}input{background:#030712;color:#fff;}button{background:#10b981;color:#000;font-weight:bold;cursor:pointer;}</style></head><body>";
    echo "<div class='card'>";
    echo "<h2 style='color:#10b981;margin-top:0;'>🐙 GusiiLyrics Git Updater</h2>";
    echo "<p style='color:#9ca3af;font-size:0.875rem;'>Enter the secret key to pull the latest code updates from GitHub onto your live server.</p>";
    echo "<form method='GET'><input type='password' name='secret' placeholder='Enter secret key...' required><button type='submit'>Access Git Updater</button></form>";
    echo "</div></body></html>";
    exit;
}

$action = $_REQUEST['action'] ?? '';
$outputLog = [];
$projectRoot = realpath(__DIR__ . '/..');

function runCmd($cmd, $cwd) {
    $command = "cd " . escapeshellarg($cwd) . " && " . $cmd . " 2>&1";
    $output = shell_exec($command);
    return trim($output ?? 'No output returned or command execution disabled by server.');
}

if ($action === 'pull') {
    $outputLog[] = "🔄 Running: git pull origin main";
    $outputLog[] = runCmd('git pull origin main', $projectRoot);

    if (class_exists('Illuminate\Support\Facades\Artisan')) {
        try {
            \Illuminate\Support\Facades\Artisan::call('optimize:clear');
            $outputLog[] = "🧹 Caches Cleared:\n" . \Illuminate\Support\Facades\Artisan::output();
        } catch (\Exception $e) {
            $outputLog[] = "⚠️ Cache Clear Notice: " . $e->getMessage();
        }
    }
} elseif ($action === 'full_update') {
    $outputLog[] = "🔄 Running: git pull origin main";
    $outputLog[] = runCmd('git pull origin main', $projectRoot);

    if (class_exists('Illuminate\Support\Facades\Artisan')) {
        try {
            \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
            $outputLog[] = "📦 Database Migrations:\n" . \Illuminate\Support\Facades\Artisan::output();

            \Illuminate\Support\Facades\Artisan::call('optimize:clear');
            $outputLog[] = "🧹 Caches Cleared:\n" . \Illuminate\Support\Facades\Artisan::output();
        } catch (\Exception $e) {
            $outputLog[] = "⚠️ Artisan Notice: " . $e->getMessage();
        }
    }
} elseif ($action === 'status') {
    $outputLog[] = "📊 Running: git status";
    $outputLog[] = runCmd('git status', $projectRoot);
    $outputLog[] = "📜 Running: git log -n 5 --oneline";
    $outputLog[] = runCmd('git log -n 5 --oneline', $projectRoot);
} elseif ($action === 'hard_reset') {
    $outputLog[] = "⚠️ Running: git fetch origin main && git reset --hard origin/main";
    $outputLog[] = runCmd('git fetch origin main && git reset --hard origin/main', $projectRoot);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GusiiLyrics Browser Git Pull & Update</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #090d16; color: #f3f4f6; margin: 0; padding: 2rem; }
        .container { max-width: 800px; margin: 0 auto; background: #111827; border: 1px solid #1f2937; border-radius: 1.5rem; padding: 2rem; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5); }
        h1 { margin-top: 0; color: #10b981; font-size: 1.5rem; display: flex; align-items: center; gap: 0.5rem; }
        .badge { background: #064e3b; color: #34d399; font-size: 0.75rem; padding: 0.25rem 0.75rem; border-radius: 9999px; border: 1px solid #059669; }
        .btn-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin: 1.5rem 0; }
        .btn { display: inline-flex; align-items: center; justify-content: center; padding: 0.875rem 1rem; border-radius: 0.75rem; font-weight: bold; text-decoration: none; font-size: 0.875rem; border: none; cursor: pointer; transition: background 0.2s; }
        .btn-primary { background: #10b981; color: #022c22; }
        .btn-primary:hover { background: #34d399; }
        .btn-secondary { background: #1f2937; color: #f3f4f6; border: 1px solid #374151; }
        .btn-secondary:hover { background: #374151; }
        .btn-danger { background: #991b1b; color: #feccae; border: 1px solid #7f1d1d; }
        .btn-danger:hover { background: #dc2626; color: #fff; }
        .log-box { background: #030712; border: 1px solid #1f2937; border-radius: 1rem; padding: 1.25rem; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; font-size: 0.8125rem; color: #a7f3d0; white-space: pre-wrap; word-break: break-word; max-height: 450px; overflow-y: auto; line-height: 1.6; }
        a { color: #34d399; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🐙 GusiiLyrics Git Updater <span class="badge">Web Pull</span></h1>
        <p style="color: #9ca3af; font-size: 0.875rem;">Pull latest commits from GitHub to update your live website directly from your browser.</p>

        <div class="btn-grid">
            <a href="?secret=<?= urlencode($SECRET_KEY) ?>&action=pull" class="btn btn-primary">
                🔄 Git Pull Codebase
            </a>
            <a href="?secret=<?= urlencode($SECRET_KEY) ?>&action=full_update" class="btn btn-secondary">
                🚀 Pull + Migrate + Clear Cache
            </a>
            <a href="?secret=<?= urlencode($SECRET_KEY) ?>&action=status" class="btn btn-secondary">
                📊 Check Git Status
            </a>
            <a href="?secret=<?= urlencode($SECRET_KEY) ?>&action=hard_reset" class="btn btn-danger" onclick="return confirm('WARNING: This will overwrite any uncommitted local changes on the server with origin/main. Proceed?');">
                ⚠️ Git Hard Reset
            </a>
        </div>

        <?php if (!empty($outputLog)): ?>
            <h3 style="font-size: 1rem; color: #f3f4f6; margin-bottom: 0.5rem;">Execution Terminal Output:</h3>
            <div class="log-box"><?= htmlspecialchars(implode("\n\n" . str_repeat('-', 50) . "\n\n", $outputLog)) ?></div>
        <?php endif; ?>

        <div style="margin-top: 2rem; border-top: 1px solid #1f2937; pt-4; text-align: center; font-size: 0.75rem; color: #6b7280;">
            <p>Access URL: <code>https://gusiilyrics.com/git-pull.php?secret=deploy123</code></p>
        </div>
    </div>
</body>
</html>
