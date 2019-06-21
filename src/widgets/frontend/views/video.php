<video playsinline <?= implode(' ', array_map(
    function ($v, $k) {
        if ($v === '1' || $v === '0') {
            if ((bool)$v) {
                return sprintf("%s", $k);
            }
            return '';
        }
        return sprintf("%s='%s'", $k, $v);
    },
    $attributes,
    array_keys($attributes)
)) ?>>
    <?php if ($urlMp4): ?>
        <source src="v<?= $urlMp4 ?>" type="video/mp4">
    <?php endif; ?>
    <?php if ($urlWebm): ?>
        <source src="<?= $urlWebm ?>" type="video/webm">
    <? endif; ?>
</video>