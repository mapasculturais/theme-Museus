<?php

/**
 * @var MapasCulturais\App $app
 * @var MapasCulturais\Themes\BaseV2\Theme $this
 */

use MapasCulturais\i;

$this->import('
    entity-data
    entity-field
    entity-terms
    mc-card
    mc-container
    mc-title
');
?>

<mc-tab label="<?= i::esc_attr__('Acervo') ?>" slug="collection">
    <div class="tabs__info">
        <mc-container>
            <main class="fullwidth">
                <div class="grid-12">
                    <mc-title tag="h4" size="medium" class="bold col-12"><?= i::__("Sobre o acervo do museu"); ?></mc-title>
                    <entity-data :entity="entity" prop="mus_num_total_acervo" class="col-12"></entity-data>
                    <entity-data :entity="entity" prop="mus_num_total_acervo_prec" class="col-12"></entity-data>
                    <entity-data :entity="entity" prop="mus_acervo_propriedade" class="col-12"></entity-data>
                    <entity-data v-if="entity.mus_acervo_propriedade && entity.mus_acervo_propriedade.includes('Possui SOMENTE acervo em comodato/empréstimo')" :entity="entity" class="col-12" prop="num_acervo_prest"></entity-data>

                    <div class="field col-12">
                        <label><?= i::__('Classifique as tipologias de acervo existentes no museu:')?></label>
                        <entity-terms :entity="entity" taxonomy="mus_area"></entity-terms>
                    </div>
                    <entity-data :entity="entity" prop="mus_instr_documento" class="col-12"></entity-data>
                    <entity-data :entity="entity" prop="mus_gestao_politicaAquisicao" class="col-12"></entity-data>
                    <entity-data :entity="entity" prop="mus_gestao_politicaDescarte" class="col-12"></entity-data>
                    <entity-data :entity="entity" prop="mus_outros_cadastros" class="col-12"></entity-data>
                    <entity-data :entity="entity" prop="mus_resp_formacao" class="col-12"></entity-data>
                    <entity-data :entity="entity" prop="mus_area_formacao" class="col-12"></entity-data>
                    <entity-data :entity="entity" prop="mus_equipe_tecnica" class="col-12"></entity-data>
                    <entity-data :entity="entity" prop="mus_equipe_tecnica" class="col-12"></entity-data>
                    <entity-data :entity="entity" prop="mus_tipo_unidadeConservacao" class="col-12"></entity-data>
                    <entity-data :entity="entity" prop="mus_tipo_unidadeConservacao_protecaoIntegral" class="col-12"></entity-data>
                    <entity-data :entity="entity" prop="mus_tipo_unidadeConservacao_usoSustentavel" class="col-12"></entity-data>

                    <div class="divider col-12"></div>

                    <mc-title tag="h4" size="medium" class="bold col-12"><?= i::__("Museus virtuais"); ?></mc-title>
                    <entity-data :entity="entity" prop="mus_acervo_material" class="col-12"></entity-data>
                    <entity-data :entity="entity" prop="mus_acervo_material_emExposicao" class="col-12"></entity-data>
                </div>
            </main>
        </mc-container>
    </div>
</mc-tab>