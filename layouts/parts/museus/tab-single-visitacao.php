<?php

/**
 * @var MapasCulturais\App $app
 * @var MapasCulturais\Themes\BaseV2\Theme $this
 */

use MapasCulturais\i;

$this->import('
    entity-data
    entity-field
    mc-container
    mc-card
');
?>

<mc-tab label="<?= i::esc_attr__('Visitação') ?>" slug="visit">
    <mc-container>
        <p class="fullwidth"><?php i::_e("Informe aos visitantes o horário de funcionamento do museu, formas de entrada, acessibilidade e instalações  do local e as atividades realizadas.") ?></p>

        <mc-card class="fullwidth">
            <template #title>
                <label><?php i::_e("Público, acessibilidade e serviços"); ?></label>
                <p class="card__title--description"><?php i::_e("Os dados inseridos abaixo serão exibidos para todos os usuários") ?></p>
            </template>
            <template #content>
                <div class="grid-12">
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_status"></entity-data>
                    </div>
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_previsao_abertura_ano"></entity-data>
                    </div>
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_previsao_abertura_mes"></entity-data>
                    </div>
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_ingresso_cobrado"></entity-data>
                    </div>
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_ingresso_valor"></entity-data>
                    </div>
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_obs_horario"></entity-data>
                    </div>
                </div>
            </template>
        </mc-card>

        <mc-card class="fullwidth">
            <template #title>
                <label><?php i::_e("Acessibilidade"); ?></label>
            </template>
            <template #content>
                <div class="grid-12">
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_arquivo_acessoPublico"></entity-data>
                    </div>
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_acessibilidade_visual"></entity-data>
                    </div>
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_acess_visual_auditiva"></entity-data>
                    </div>
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_servicos_atendimentoEstrangeiros"></entity-data>
                    </div>
                </div>
            </template>
        </mc-card>

        <mc-card class="fullwidth">
            <template #title>
                <label><?php i::_e("Instalações"); ?></label>
            </template>
            <template #content>
                <div class="grid-12">
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_instalacoes"></entity-data>
                    </div>
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_instalacoes_capacidadeAuditorio"></entity-data>
                    </div>
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_arquivo_possui"></entity-data>
                    </div>
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_biblioteca_possui"></entity-data>
                    </div>
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_servicos_visitaGuiada"></entity-data>
                    </div>
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_servicos_visitaGuiada_s"></entity-data>
                    </div>
                </div>
            </template>
        </mc-card>

        <mc-card class="fullwidth">
            <template #title>
                <label><?php i::_e("Atividades educativas e culturais "); ?></label>
            </template>
            <template #content>
                <div class="grid-12">
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_atividade_pub_especif"></entity-data>
                    </div>
                    <div class="col-12">
                        <entity-data :entity="entity" prop="mus_atividade_pub_especif_s"></entity-data>
                    </div>
                </div>
            </template>
        </mc-card>

    </mc-container>
</mc-tab>