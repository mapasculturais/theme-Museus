<?php

/**
 * @var MapasCulturais\App $app
 * @var MapasCulturais\Themes\BaseV2\Theme $this
 */

use MapasCulturais\i;

$this->jsObject['config']['filter'] = ['municipios' => array_values($app->config['busca.lista.municipios'])];

$this->import('
    museum-filters
');
?>

<museum-filters :pseudo-query.sync="pseudoQuery"></museum-filters>