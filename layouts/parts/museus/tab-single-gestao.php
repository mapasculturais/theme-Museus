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
    mc-title
');
?>

<mc-tab label="<?= i::esc_attr__('Gestao') ?>" slug="management">
    <mc-container>
        <main class="fullwidth">
            <div class="grid-12">
                <mc-title tag="h4" size="medium" class="bold col-12"><?= i::__("Gestão e administração"); ?></mc-title>
                <entity-data :entity="entity" prop="mus_esfera_tipo_federal" class="col-12"></entity-data>
                <entity-data :entity="entity" prop="mus_abertura_ano" class="col-12"></entity-data>
                <entity-data :entity="entity" prop="mus_instumentoCriacao_tipo" class="col-12"></entity-data>
                <entity-data :entity="entity" prop="mus_instumentoCriacao_descricao" class="col-12"></entity-data>
                <entity-data :entity="entity" prop="mus_contrato_gestao" class="col-12"></entity-data>
                <entity-data :entity="entity" prop="mus_contrato_gestao_s_outros" class="col-12"></entity-data>
                <entity-data :entity="entity" prop="mus_contrato_gestao_s" class="col-12"></entity-data>
                <entity-data :entity="entity" prop="mus_contrato_qualificacoes" class="col-12"></entity-data>
                <entity-data :entity="entity" prop="mus_num_pessoas" class="col-12"></entity-data>
                <entity-data :entity="entity" prop="mus_func_tercerizado_s" class="col-12"></entity-data>
                <entity-data :entity="entity" prop="mus_func_estagiario" class="col-12"></entity-data>
                <entity-data :entity="entity" prop="mus_gestao_regimentoInterno" class="col-12"></entity-data>
                <entity-data :entity="entity" prop="mus_gestao_planoMuseologico" class="col-12"></entity-data>

                <div class="divider col-12"></div>

                <mc-title tag="h4" size="medium" class="bold col-12"><?= i::__("Caracterização"); ?></mc-title>
                <entity-data :entity="entity" prop="mus_gestao_planoMuseologico" class="col-12"></entity-data>
                <entity-data :entity="entity" prop="mus_tipo" class="col-12"></entity-data>
                <entity-data :entity="entity" prop="mus_itinerante" class="col-12"></entity-data>
                <entity-data :entity="entity" prop="mus_comunidadeRealizaAtividades" class="col-12"></entity-data>
                <entity-data :entity="entity" prop="mus_tipo_tematica" class="col-12"></entity-data>
            </div>
        </main>
    </mc-container>
</mc-tab>