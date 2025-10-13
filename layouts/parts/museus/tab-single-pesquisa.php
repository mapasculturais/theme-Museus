<?php

/**
 * @var MapasCulturais\App $app
 * @var MapasCulturais\Themes\BaseV2\Theme $this
 */

use MapasCulturais\i;

$this->import('
    entity-data
    mc-card
    mc-container
    mc-title
');
?>

<mc-tab label="<?= i::esc_attr__('Pesquisa') ?>" slug="search">
    <mc-container>
        <main class="fullwidth">
            <div class="grid-12">
                <mc-title tag="h4" size="medium" class="bold col-12"><?= i::__("Pesquisa"); ?></mc-title>
                <entity-data :entity="entity" classes="col-12" prop="mus_exposicao_formato"></entity-data>
                <entity-data v-if="entity.mus_exposicao_formato == 'Outros'" :entity="entity" classes="col-12" prop="mus_exposicao_formato_outros"></entity-data>
                <entity-data :entity="entity" classes="col-12" prop="mus_exposicao_museu_cartaz"></entity-data>
                <entity-data :entity="entity" classes="col-12" prop="mus_realiza_atualizacao_expositivo"></entity-data>
                <entity-data :entity="entity" classes="col-12" prop="mus_instituicao_pesquisa"></entity-data>
                <entity-data v-if="entity.mus_instituicao_pesquisa == 'Sim'" :entity="entity" classes="col-12" prop="mus_instituicao_informacao_pesquisa"></entity-data>
                <entity-data v-if="entity.mus_instituicao_informacao_pesquisa == 'Outros'" :entity="entity" classes="col-12" prop="instituicao_informacao_pesquisa_outros"></entity-data>
                <entity-data :entity="entity" classes="col-12" prop="mus_recebe_pesquisadores"></entity-data>
                <entity-data :entity="entity" classes="col-12" prop="mus_pesquisa_devolutiva"></entity-data>
                <entity-data :entity="entity" classes="col-12" prop="mus_realiza_captacao_recurso"></entity-data>
                <entity-data v-if="entity.mus_realiza_captacao_recurso == 'Sim'" :entity="entity" classes="col-12" prop="mus_fonte_captacao_recurso"></entity-data>
                <entity-data v-if="entity.mus_fonte_captacao_recurso == 'Outros'" :entity="entity" classes="col-12" prop="mus_fonte_captacao_recurso_outros"></entity-data>
                <entity-data :entity="entity" classes="col-12" prop="mus_foi_contemplado_editais"></entity-data>
                <entity-data v-if="entity.mus_foi_contemplado_editais == 'Sim'" :entity="entity" classes="col-12" prop="mus_foi_contemplado_editais_quais"></entity-data>
                <entity-data :entity="entity" classes="col-12" prop="mus_foi_contemplado_editais_secult"></entity-data>
                <entity-data v-if="entity.mus_foi_contemplado_editais_secult_quais == 'Sim'" :entity="entity" classes="col-12" prop="mus_foi_contemplado_editais_secult_quais"></entity-data>
            </div>
        </main>
    </mc-container>
</mc-tab>