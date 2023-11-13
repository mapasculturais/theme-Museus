<?php
/**
 * @var MapasCulturais\App $app
 * @var MapasCulturais\Themes\BaseV2\Theme $this
 */

$this->jsObject['config']['filter'] = ['municipios' => array_values($app->config['busca.lista.municipios'])];