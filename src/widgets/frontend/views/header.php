<h<?= $size ?> <?= implode(' ', array_map(
    function ($v, $k) { return sprintf("%s='%s'", $k, $v); },
    $attributes,
    array_keys($attributes)
)) ?>><?= $content ?></h<?= $size ?>>