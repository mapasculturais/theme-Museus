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

<mc-tab label="<?= i::esc_attr__('Acervo') ?>" slug="acervo">
    <div class="tabs__info">
        <mc-container>
            <mc-card class="fullwidth">
                <template #title>
                    <label><?php i::_e("Sobre o acervo do museu"); ?></label>
                </template>
                <template #content>
                    <div class="grid-12">
                        <div class="col-12">
                            <entity-data :entity="entity" prop="mus_num_total_acervo"></entity-data>
                        </div>
                        <div class="col-12">
                            <entity-data :entity="entity" prop="mus_num_total_acervo_prec"></entity-data>
                        </div>
                        <div class="col-12">
                            <entity-data :entity="entity" prop="mus_acervo_propriedade"></entity-data>
                        </div>
                        <div class="col-12">
                            <entity-data :entity="entity" prop="mus_instr_documento"></entity-data>
                        </div>
                        <div class="col-12">
                            <entity-data :entity="entity" prop="mus_gestao_politicaAquisicao"></entity-data>
                        </div>
                        <div class="col-12">
                            <entity-data :entity="entity" prop="mus_gestao_politicaDescarte"></entity-data>
                        </div>
                        <div class="col-12">
                            <entity-data :entity="entity" prop="mus_instituicaoMantenedora"></entity-data>
                        </div>
                        <div class="col-12">
                            <entity-data :entity="entity" prop="mus_outros_cadastros"></entity-data>
                        </div>
                        <div class="col-12">
                            <entity-data :entity="entity" prop="mus_resp_formacao"></entity-data>
                        </div>
                        <div class="col-12">
                            <entity-data :entity="entity" prop="mus_area_formacao"></entity-data>
                        </div>
                        <div class="col-12">
                            <entity-data :entity="entity" prop="mus_equipe_tecnica"></entity-data>
                        </div>
                        <div class="col-12">
                            <entity-data :entity="entity" prop="mus_equipe_tecnica"></entity-data>
                        </div>
                        <div class="col-12">
                            <entity-data :entity="entity" prop="mus_periodo_museologico"></entity-data>
                        </div>
                        <div class="col-12">
                            <entity-data :entity="entity" prop="mus_tipo_unidadeConservacao"></entity-data>
                        </div>
                        <div class="col-12">
                            <entity-data :entity="entity" prop="mus_tipo_unidadeConservacao_protecaoIntegral"></entity-data>
                        </div>
                        <div class="col-12">
                            <entity-data :entity="entity" prop="mus_tipo_unidadeConservacao_usoSustentavel"></entity-data>
                        </div>
                    </div>
                </template>
            </mc-card>
            <mc-card class="fullwidth">
                <template #title>
                    <label><?php i::_e("Somente para museus virtuais"); ?></label>
                </template>
                <template #content>
                    <div class="grid-12">
                        <div class="col-12">
                            <entity-data :entity="entity" prop="mus_acervo_material"></entity-data>
                        </div>
                        <div class="col-12">
                            <entity-data :entity="entity" prop="mus_acervo_material_emExposicao"></entity-data>
                        </div>
                    </div>
                </template>
            </mc-card>
        </mc-container>
    </div>
</mc-tab>