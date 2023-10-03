<?php

/**
 * @var MapasCulturais\App $app
 * @var MapasCulturais\Themes\BaseV2\Theme $this
 */

use MapasCulturais\i;

$this->import('
    entity-field
    mc-container

');
?>

<mc-tab label="<?= i::esc_attr__('Visitação') ?>" slug="visit">
    <mc-container>
        <p class="fulwidth"><?php i::_e("Informe aos visitantes o horário de funcionamento do museu, formas de entrada, acessibilidade e instalações  do local e as atividades realizadas.") ?></p>

        <mc-card class="fulwidth">
            <template #title>
                <label><?php i::_e("Público, acessibilidade e serviços"); ?></label>
                <p class="card__title--description"><?php i::_e("Os dados inseridos abaixo serão exibidos para todos os usuários") ?></p>
            </template>
            <template #content>
                <div class="grid-12">
                    <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('O museu encontra-se') ?>" prop="mus_status"></entity-field>
                    <div class="grid-12 col-12">
                        <p class="col-12"><?php i::_e("Em caso de museu fechado, qual a previsão de abertura? Descreva mês e o ano abaixo") ?></p>
                        <entity-field :entity="entity" classes="col-3" label="<?= i::esc_attr__('Mes/Ano') ?>" prop="mus_previsao_abertura_ano"></entity-field>
                    </div>
                    <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('A entrada do museu é cobrada?') ?>" prop="mus_ingresso_cobrado"></entity-field>
                    <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('Informe o valor cobrado para o público geral') ?>" prop="mus_ingresso_valor"></entity-field>
                    <div class="grid-12 col-12">
                        <p class="col-12"><?php i::_e("Dias e horário de funcionamento") ?></p>
                        <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('Insira os dias e horários de funcionamento do museu') ?>" prop="mus_obs_horario"></entity-field>
                    </div>
                </div>
            </template>
        </mc-card>

        <mc-card class="fulwidth">
            <template #title>
                <label><?php i::_e("Acessibilidade"); ?></label>
            </template>
            <template #content>
                <div class="grid-12">
                    <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('O espaço oferece acessibilidade?') ?>" prop="mus_arquivo_acessoPublico"></entity-field>
                    <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('Adicionar recursos de acessibilibidade física') ?>" prop="mus_acessibilidade_visual"></entity-field>
                    <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('Adicionar recursos de acessibilibidade para pessoas com deficiência auditiva e/ou visuais') ?>" prop="mus_acess_visual_auditiva"></entity-field>
                    <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('Possui recursos de atendimento para estrangeiros?') ?>" prop="mus_servicos_atendimentoEstrangeiros"></entity-field>
                </div>
            </template>
        </mc-card>

        <mc-card class="fulwidth">
            <template #title>
                <label><?php i::_e("Instalações"); ?></label>
            </template>
            <template #content>
                <div class="grid-12">
                    <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('Informe as instação básicas e serviços oferecidos pelo museu') ?>" prop="mus_instalacoes"></entity-field>
                    <entity-field :entity="entity" classes="col-3" label="<?= i::esc_attr__('Capacidade do teatro/auditótio') ?>" prop="mus_instalacoes_capacidadeAuditorio"></entity-field>
                    <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('Possui arquivo histórico?') ?>" prop="mus_arquivo_possui"></entity-field>
                    <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('O museu possui biblioteca?') ?>" prop="mus_biblioteca_possui"></entity-field>
                    <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('O museu possui visita guiada?') ?>" prop="mus_servicos_visitaGuiada"></entity-field>
                    <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('Especifique:') ?>" prop="mus_servicos_visitaGuiada_s"></entity-field>
                </div>
            </template>
        </mc-card>

        <mc-card class="fulwidth">
            <template #title>
                <label><?php i::_e("Atividades educativas e culturais "); ?></label>
            </template>
            <template #content>
                <div class="grid-12">
                    <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('O museu realiza atividades educativas e culturais para públicos específicos?') ?>" prop="mus_atividade_pub_especif"></entity-field>
                    <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('Especifique com quais públicos:') ?>" prop="mus_atividade_pub_especif_s"></entity-field>
                </div>
            </template>
        </mc-card>

    </mc-container>
</mc-tab>