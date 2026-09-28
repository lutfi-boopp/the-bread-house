<?php
$sourceDir = 'C:\Users\Noirr`\.gemini\antigravity-ide\brain\ad19f049-2546-4997-9316-4fc9bdada342';
$destDir = 'C:\laragon\www\upibakery\public\images';

if (!is_dir($destDir)) {
    mkdir($destDir, 0777, true);
}

$files = scandir($sourceDir);
foreach ($files as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) === 'jpg') {
        if (strpos($file, 'hero_promo') !== false) {
            copy($sourceDir . '\\' . $file, $destDir . '\hero_promo.jpg');
        } elseif (strpos($file, 'product_sourdough') !== false) {
            copy($sourceDir . '\\' . $file, $destDir . '\product_sourdough.jpg');
        } elseif (strpos($file, 'product_croissant') !== false) {
            copy($sourceDir . '\\' . $file, $destDir . '\product_croissant.jpg');
        } elseif (strpos($file, 'product_cinnamon') !== false) {
            copy($sourceDir . '\\' . $file, $destDir . '\product_cinnamon.jpg');
        } elseif (strpos($file, 'product_pain_au_choc') !== false) {
            copy($sourceDir . '\\' . $file, $destDir . '\product_pain_au_choc.jpg');
        }
    }
}
echo "Images copied successfully.";
