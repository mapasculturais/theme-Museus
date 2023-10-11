<?php

/**
 * @var MapasCulturais\App $app
 * @var MapasCulturais\Themes\BaseV2\Theme $this
 */

use MapasCulturais\i;

$this->import('
    entity-field
    mc-container
    mc-card
');
?>

<mc-tab label="<?= i::esc_attr__('Gestao') ?>" slug="gest">
    <mc-container>
        <p class="fullwidth semibold"><?php i::_e("Forneça algumas informações administrativos do museu sobre a gestão e como esse museu se caracteriza") ?></p>

        <mc-card class="fullwidth">
            <template #title>
                <label><?php i::_e("Informações sobre a gestão"); ?></label>
            </template>
            <template #content>
                <div class="grid-12">
                    <entity-field :entity="entity" classes="col-12" prop="mus_mais_ent_federal"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_esfera_tipo_federal"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_priv_esfera_tipo"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_abertura_ano"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_instumentoCriacao_tipo"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_instumentoCriacao_descricao"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_contrato_gestao"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_contrato_gestao_s_outros"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_contrato_gestao_s"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_contrato_qualificacoes"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_num_pessoas"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_func_tercerizado"></entity-field>
                    <entity-field v-if="entity.mus_func_tercerizado == 's'":entity="entity" classes="col-12" prop="mus_func_tercerizado_s"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_func_voluntario"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_func_estagiario"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_gestao_regimentoInterno"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_gestao_planoMuseologico"></entity-field>
                </div>
            </template>
        </mc-card>

        <mc-card class="fullwidth">
            <template #title>
                <label><?php i::_e("Caracterização"); ?></label>
            </template>
            <template #content>
                <div class="grid-12">
                    <entity-field :entity="entity" classes="col-12" prop="mus_tipo"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_itinerante"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_comunidadeRealizaAtividades"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_tipo_tematica"></entity-field>
                </div>
            </template>
        </mc-card>
    </mc-container>
</mc-tab>