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

<div class="grid-12 card-acessibilidade">
    <br>
    <entity-field :entity="entity" classes="col-12" prop="mus_acess_visual_auditiva"></entity-field>
    <entity-field v-if="entity.mus_acess_visual_auditiva == 'Sim'" :entity="entity" classes="col-12" prop="mus_acessibilidade_visual"></entity-field>
    <entity-field :entity="entity" classes="col-12" prop="mus_servicos_atendimentoEstrangeiros"></entity-field>
</div>