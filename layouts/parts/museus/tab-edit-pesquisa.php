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

<mc-tab label="<?= i::esc_attr__('Pesquisa') ?>" slug="search">
    <mc-container>
        <mc-card class="fullwidth">
            <template #title>
                <label><?php i::_e("Exposições, Pesquisa e Fomento"); ?></label>
            </template>
            <template #content>
                <div class="grid-12">
                    <entity-field :entity="entity" classes="col-12" prop="mus_exposicao_formato"></entity-field>
                    <entity-field v-if="entity.mus_exposicao_formato == 'Outros'":entity="entity" classes="col-12" prop="mus_exposicao_formato_outros"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_exposicao_museu_cartaz"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_realiza_atualizacao_expositivo"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_instituicao_pesquisa"></entity-field>
                    <entity-field v-if="entity.mus_instituicao_pesquisa == 'Sim'" :entity="entity" classes="col-12" prop="mus_instituicao_informacao_pesquisa"></entity-field>
                    <entity-field v-if="entity.mus_instituicao_informacao_pesquisa == 'Outros'" :entity="entity" classes="col-12" prop="instituicao_informacao_pesquisa_outros"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_recebe_pesquisadores"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_pesquisa_devolutiva"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_realiza_captacao_recurso"></entity-field>
                    <entity-field v-if="entity.mus_realiza_captacao_recurso == 'Sim'" :entity="entity" classes="col-12" prop="mus_fonte_captacao_recurso"></entity-field>
                    <entity-field v-if="entity.mus_fonte_captacao_recurso == 'Outros'" :entity="entity" classes="col-12" prop="mus_fonte_captacao_recurso_outros"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_foi_contemplado_editais"></entity-field>
                    <entity-field v-if="entity.mus_foi_contemplado_editais == 'Sim'" :entity="entity" classes="col-12" prop="mus_foi_contemplado_editais_quais"></entity-field>
                    <entity-field :entity="entity" classes="col-12" prop="mus_foi_contemplado_editais_secult"></entity-field>
                    <entity-field v-if="entity.mus_foi_contemplado_editais_secult == 'Sim'" :entity="entity" classes="col-12" prop="mus_foi_contemplado_editais_secult_quais"></entity-field>
                </div>
            </template>
        </mc-card>
    </mc-container>
</mc-tab>