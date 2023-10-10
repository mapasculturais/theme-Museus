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

<mc-tab label="<?= i::esc_attr__('Visitação') ?>" slug="visit">
    <mc-container>
        <p class="fullwidth semibold"><?php i::_e("Informe aos visitantes o horário de funcionamento do museu, formas de entrada, acessibilidade e instalações  do local e as atividades realizadas.") ?></p>

        <mc-card class="fullwidth">
            <template #title>
                <label><?php i::_e("Público, acessibilidade e serviços"); ?></label>
                <p class="card__title--description"><?php i::_e("Os dados inseridos abaixo serão exibidos para todos os usuários") ?></p>
            </template>
            <template #content>
                <div class="grid-12">
                    <entity-field :entity="entity" classes="col-12" prop="mus_status"></entity-field>
                    <entity-field :entity="entity" classes="col-3" prop="mus_previsao_abertura_ano"></entity-field>
                    <entity-field :entity="entity" classes="col-3" prop="mus_previsao_abertura_mes"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_ingresso_cobrado"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_ingresso_valor"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_obs_horario"></entity-field>
                </div>
            </template>
        </mc-card>

        <mc-card class="fullwidth">
            <template #title>
                <label><?php i::_e("Acessibilidade"); ?></label>
            </template>
            <template #content>
                <div class="grid-12">
                    <entity-field :entity="entity" classes="col-12" prop="mus_arquivo_acessoPublico"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_acess_visual_auditiva"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_acessibilidade_visual"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_servicos_atendimentoEstrangeiros"></entity-field>
                </div>
            </template>
        </mc-card>

        <mc-card class="fullwidth">
            <template #title>
                <label><?php i::_e("Instalações"); ?></label>
            </template>
            <template #content>
                <div class="grid-12">
                    <entity-field :entity="entity" classes="col-12" prop="mus_instalacoes"></entity-field>
                    <entity-field :entity="entity" classes="col-3" prop="mus_instalacoes_capacidadeAuditorio"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_arquivo_possui"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_biblioteca_possui"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_servicos_visitaGuiada"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_servicos_visitaGuiada_s"></entity-field>
                </div>
            </template>
        </mc-card>

        <mc-card class="fullwidth">
            <template #title>
                <label><?php i::_e("Atividades educativas e culturais "); ?></label>
            </template>
            <template #content>
                <div class="grid-12">
                    <entity-field :entity="entity" classes="col-12" prop="mus_atividade_pub_especif"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_atividade_pub_especif_s"></entity-field>
                </div>
            </template>
        </mc-card>

    </mc-container>
</mc-tab>