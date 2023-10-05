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

<mc-tab label="<?= i::esc_attr__('Acervo') ?>" slug="acervo">
    <mc-container>
        <p class="fulwidth"><?php i::_e("Nos dê informações sobre o acervo que o museu abriga.") ?></p>

        <mc-card class="fulwidth">
            <template #title>
                <label><?php i::_e("Informe sobre o acervo"); ?></label>
            </template>
            <template #content>
                <div class="grid-12">
                    <entity-field :entity="entity" classes="col-12" prop="mus_num_total_acervo"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_num_total_acervo_prec"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_acervo_propriedade"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_instr_documento"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_gestao_politicaAquisicao"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_gestao_politicaDescarte"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_instituicaoMantenedora"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_outros_cadastros"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_resp_formacao"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_area_formacao"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_equipe_tecnica"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_periodo_museologico"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_tipo_unidadeConservacao"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_tipo_unidadeConservacao_protecaoIntegral"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_tipo_unidadeConservacao_usoSustentavel"></entity-field>
                </div>
            </template>
        </mc-card>
        <mc-card class="fulwidth">
            <template #title>
                <label><?php i::_e("Somente para museus virtuais"); ?></label>
            </template>
            <template #content>
                <div class="grid-12">
                    <entity-field :entity="entity" classes="col-12" prop="mus_acervo_material"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_acervo_material_emExposicao"></entity-field>
                </div>
            </template>
        </mc-card>
    </mc-container>
</mc-tab>