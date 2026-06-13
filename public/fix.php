<?php
$dirs = [
    __DIR__ . "/../storage/framework/views",
    __DIR__ . "/../storage/framework/cache",
    __DIR__ . "/../storage/framework/sessions",
    __DIR__ . "/../bootstrap/cache"
];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0777, true);
        echo "Created: " . $dir . "<br>";
    } else {
        echo "Already exists: " . $dir . "<br>";
    }
}
echo "<h1>BERHASIL! Silakan buka halaman utama web Anda sekarang!</h1>";
?>
