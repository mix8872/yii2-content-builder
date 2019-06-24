<figure>
    <img <?= implode(' ', array_map(
        function ($v, $k) { return sprintf("%s='%s'", $k, $v); },
        $attributes,
        array_keys($attributes)
    )) ?> src='<?= $url ?>' alt='<?= $alt ?>' title='<?= $title ?>'>
    <figcaption><?= $description ?></figcaption>
</figure>