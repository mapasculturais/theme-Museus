<?php

/**
 * @var MapasCulturais\App $app
 * @var MapasCulturais\Themes\BaseV2\Theme $this
 */

use MapasCulturais\i;

$this->import('
    entity-field

');
?>
<entity-field :entity="entity" classes="col-6 sm:col-6" prop="mus_cod"></entity-field>
<entity-field :entity="entity" classes="col-6 sm:col-6" prop="num_sniic"></entity-field>