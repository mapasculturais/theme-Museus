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
<small class="col-12">Adicionar props corretas</small>
<entity-field :entity="entity" classes="col-6 sm:col-12" label="<?php i::esc_attr_e("campo adicional 1") ?>" prop="name"></entity-field>
<entity-field :entity="entity" classes="col-6 sm:col-12" label="<?php i::esc_attr_e("campo adicional 2") ?>" prop="name"></entity-field>