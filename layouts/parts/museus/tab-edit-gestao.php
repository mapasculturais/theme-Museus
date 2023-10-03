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

<mc-tab label="<?= i::esc_attr__('Gestao') ?>" slug="gest">
    <mc-container>
        <p class="fulwidth"><?php i::_e("Forneça algumas informações administrativos do museu sobre a gestão e como esse museu se caracteriza") ?></p>

        <mc-card class="fulwidth">
            <template #title>
                <label><?php i::_e("Informações sobre a gestão"); ?></label>
            </template>
            <template #content>
                <div class="grid-12">
                    <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('Se Museu Federal, selecione a vinculação ministerial') ?>" prop="mus_esfera_tipo_federal"></entity-field>
                    <!-- <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('CNPJ') ?>" prop="mus_cnpj"></entity-field> -->
                    <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('Ano de abertura do museu') ?>" prop="mus_abertura_ano"></entity-field>
                    <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('Especifique o instrumento de criação do museu:') ?>" prop="mus_instumentoCriacao_tipo"></entity-field>
                    <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('Descrição do instrumento de criação') ?>" prop="mus_instumentoCriacao_descricao"></entity-field>
                    <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('O museu possui algum contrato para sua gestão?') ?>" prop="mus_contrato_gestao"></entity-field>
                    <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('Caso outros, informe a descrição:') ?>" prop="mus_contrato_gestao_s_outros"></entity-field>
                    <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('Em caso positivo especifique a estrutura jurídica da instituição contratada:') ?>" prop="mus_contrato_gestao_s"></entity-field>
                    <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('Em caso positivo especifique a estrutura jurídica da instituição contratada:') ?>" prop="mus_contrato_qualificacoes"></entity-field>
                    <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('Quantas pessoas trabalham no museu (contabilizar terceirizados, estagiários e voluntários)?') ?>" prop="mus_num_pessoas"></entity-field>
                    <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('O museu possui funcionários terceirizados?') ?>" prop="mus_func_tercerizado"></entity-field>
                    <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('Quantos?') ?>" prop="mus_func_tercerizado_s"></entity-field>
                    <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('O museu possui estagiários?') ?>" prop="mus_func_estagiario"></entity-field>
                    <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('Possui Regimento Interno?') ?>" prop="mus_gestao_regimentoInterno"></entity-field>
                    <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('O museu Plano Museológico?') ?>" prop="mus_gestao_planoMuseologico"></entity-field>
                </div>
            </template>
        </mc-card>

        <mc-card class="fulwidth">
            <template #title>
                <label><?php i::_e("Caracterização"); ?></label>
            </template>
            <template #content>
                <div class="grid-12">
                    <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('O museu é:') ?>" prop="mus_tipo"></entity-field>
                    <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('O museu é itinerante?') ?>" prop="mus_itinerante"></entity-field>
                    <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('A comunidade realiza atividades museológicas (inventário participativo, museografia etc.)?') ?>" prop="mus_comunidadeRealizaAtividades"></entity-field>
                    <entity-field :entity="entity" classes="col-12" label="<?= i::esc_attr__('Em relação à temática do museu, classifique a instituição em APENAS UMA opção:') ?>" prop="mus_tipo_tematica"></entity-field>
                </div>
            </template>
        </mc-card>
    </mc-container>
</mc-tab>