<?php
// File: clear-cache.php
if (function_exists('opcache_reset')) {
    opcache_reset();
    echo "✅ OPcache cleared successfully!<br>";
} else {
    echo "❌ OPcache not available<br>";
}

if (function_exists('apc_clear_cache')) {
    apc_clear_cache();
    echo "✅ APC cache cleared successfully!<br>";
} else {
    echo "❌ APC cache not available<br>";
}

echo "<br>Cache clearing completed at: " . date('Y-m-d H:i:s');
?>