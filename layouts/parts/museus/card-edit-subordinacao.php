<?php

/**
 * @var MapasCulturais\App $app
 * @var MapasCulturais\Themes\BaseV2\Theme $this
 */

use MapasCulturais\i;

$this->import('
    entity-field
    mc-card
');
?>

<entity-field :entity="entity" classes="col-12 sm:col-6" prop="mus_subordinado_museu_matriz"></entity-field>

<small class="col-12">
    <?= i::__('Museu que tem sob sua subordinação museu filial (dependente de outro quanto à sua direção e gestão, inclusive financeira, mas que possui plano museológico autônomo) e seccional (parte diferenciada de um museu que, com a finalidade de executar seu plano museológico, ocupa um imóvel independente da sede principal). Filiais ou seccionais em endereços de visitação diferentes deverão responder um questionário para cada unidade, indicando aqui a qual museu mãe está subordinado.') ?>
</small>

<template v-if="entity.mus_subordinado_museu_matriz == 'Sim'">
    <entity-field :entity="entity" classes="col-12 sm:col-6" prop="mus_museu_matriz"></entity-field>

    <small class="col-12">
        <?= i::__('Os dados sensíveis do responsável serão ocultados para o público.') ?>
    </small>

    <entity-field :entity="entity" classes="col-6 sm:col-6" prop="mus_nome_responsavel_instituicao"></entity-field>
    <entity-field :entity="entity" classes="col-6 sm:col-6" prop="mus_cpf_responsavel_instituicao"></entity-field>
    <entity-field :entity="entity" classes="col-6 sm:col-6" prop="mus_email_responsavel_instituicao"></entity-field>
    <entity-field :entity="entity" classes="col-6 sm:col-6" prop="mus_telefone_responsavel_instituicao"></entity-field>
    <entity-field :entity="entity" classes="col-12 sm:col-6" prop="mus_funcao_responsavel_instituicao"></entity-field>

    <entity-field :entity="entity" classes="col-12" prop="mus_resp_formacao"></entity-field>
    <entity-field v-if="entity.mus_resp_formacao?.includes('Ensino superior')" :entity="entity" classes="col-12" prop="mus_area_formacao"></entity-field>
</template>
