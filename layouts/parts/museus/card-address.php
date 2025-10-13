<?php

/**
 * @var MapasCulturais\App $app
 * @var MapasCulturais\Themes\BaseV2\Theme $this
 */

use MapasCulturais\i;

$this->import('
    entity-field
');
?>

<div class="grid-12">
    
    <entity-field :entity="entity" classes="col-12 sm:col-6" prop="mus_endereco_correspondencia_visitacao"></entity-field>
    
    <div v-if="entity.mus_endereco_correspondencia_visitacao == 'Não'" class="col-12 grid-12">
        <h3 class="col-12"><?= i::__('Informe abaixo o endereço de correspondência') ?></h3>
        
        <entity-field :entity="entity" classes="col-4 sm:col-6" prop="mus_cep_visitacao"></entity-field>
        <entity-field :entity="entity" classes="col-8 sm:col-6" prop="mus_logradouro_visitacao"></entity-field>
        <entity-field :entity="entity" classes="col-3 sm:col-6" prop="mus_numero_visitacao"></entity-field>
        <entity-field :entity="entity" classes="col-9" prop="mus_bairro_visitacao"></entity-field>
        <entity-field :entity="entity" classes="col-12 sm:col-6" prop="mus_complemento_visitacao"></entity-field>
        <entity-field :entity="entity" classes="col-6" prop="mus_estado_visitacao"></entity-field>
        <entity-field :entity="entity" classes="col-6" prop="mus_municipio_visitacao"></entity-field>
    </div>
</div>