<?php

/**
 * @var MapasCulturais\App $app
 * @var MapasCulturais\Themes\BaseV2\Theme $this
 */

use MapasCulturais\i;

$this->import('
    entity-data
    entity-field
    mc-card
    mc-container
');
?>

<mc-tab label="<?= i::esc_attr__('Gestao') ?>" slug="gest">
    <mc-container>
        <p class="fullwidth"><?php i::_e("Forneça algumas informações administrativos do museu sobre a gestão e como esse museu se caracteriza") ?></p>

        <mc-card class="fullwidth">
            <template #title>
                <label><?php i::_e("Informações sobre a gestão"); ?></label>
            </template>
            <template #content>
                <div class="grid-12">
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_esfera_tipo_federal"></entity-data>
                    </div>
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_abertura_ano"></entity-data>
                    </div>
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_instumentoCriacao_tipo"></entity-data>
                    </div>
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_instumentoCriacao_descricao"></entity-data>
                    </div>
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_contrato_gestao"></entity-data>
                    </div>
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_contrato_gestao_s_outros"></entity-data>
                    </div>
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_contrato_gestao_s"></entity-data>
                    </div>
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_contrato_qualificacoes"></entity-data>
                    </div>
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_num_pessoas"></entity-data>
                    </div>
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_func_tercerizado_s"></entity-data>
                    </div>
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_func_estagiario"></entity-data>
                    </div>
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_gestao_regimentoInterno"></entity-data>
                    </div>
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_gestao_planoMuseologico"></entity-data>
                    </div>
                </div>
            </template>
        </mc-card>

        <mc-card class="fullwidth">
            <template #title>
                <label><?php i::_e("Caracterização"); ?></label>
            </template>
            <template #content>
                <div class="grid-12">
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_gestao_planoMuseologico"></entity-data>
                    </div>
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_tipo"></entity-data>
                    </div>
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_itinerante"></entity-data>
                    </div>
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_comunidadeRealizaAtividades"></entity-data>
                    </div>
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_tipo_tematica"></entity-data>
                    </div>
                </div>
            </template>
        </mc-card>
    </mc-container>
</mc-tab>