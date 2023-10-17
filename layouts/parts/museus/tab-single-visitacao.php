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
    mc-title
');
?>

<mc-tab label="<?= i::esc_attr__('Visitação') ?>" slug="visit">
    <mc-container>
        <main class="fullwidth">
            <div class="grid-12">
                <mc-title tag="h4" size="medium" class="bold col-12"><?= i::__("Sobre o acervo do museu"); ?></mc-title>
                <entity-data :entity="entity" prop="mus_status" class="col-12"></entity-data>
                <entity-data v-if="entity.mus_status == 'fechado'" :entity="entity" prop="mus_previsao_abertura_ano" class="col-12"></entity-data>
                <entity-data v-if="entity.mus_status == 'fechado'" :entity="entity" prop="mus_previsao_abertura_mes" class="col-12"></entity-data>
                <entity-data :entity="entity" prop="mus_metodo_contagem_pub" class="col-12"></entity-data>
                <entity-data :entity="entity" prop="mus_ingresso_cobrado" class="col-12"></entity-data>
                <entity-data v-if="mus_ingresso_cobrado == 'sim'" :entity="entity" prop="mus_ingresso_valor" class="col-12"></entity-data>
                <entity-data v-if="mus_ingresso_cobrado == 'sim'" :entity="entity" prop="mus_desc_valor_ingresso" class="col-12"></entity-data>
                <entity-data :entity="entity" prop="mus_obs_horario" class="col-12"></entity-data>

                <div class="divider col-12"></div>

                <mc-title tag="h4" size="medium" class="bold col-12"><?= i::__("Recursos de acessibilidade"); ?></mc-title>
                <entity-data :entity="entity" prop="mus_arquivo_acessoPublico" class="col-12"></entity-data>
                <entity-data :entity="entity" prop="mus_acessibilidade_visual" class="col-12"></entity-data>
                <entity-data :entity="entity" prop="mus_acess_visual_auditiva" class="col-12"></entity-data>
                <entity-data :entity="entity" prop="mus_servicos_atendimentoEstrangeiros" class="col-12"></entity-data>

                <div class="divider col-12"></div>

                <mc-title tag="h4" size="medium" class="bold col-12"><?= i::__("Instalações que o museu oferece aos visitantes"); ?></mc-title>
                <entity-data :entity="entity" prop="mus_instalacoes" class="col-12"></entity-data>
                <entity-data :entity="entity" prop="mus_instalacoes_capacidadeAuditorio" class="col-12"></entity-data>
                <entity-data :entity="entity" prop="mus_arquivo_possui" class="col-12"></entity-data>
                <entity-data :entity="entity" prop="mus_arquivo_acessoPublico" class="col-12"></entity-data>
                <entity-data :entity="entity" prop="mus_biblioteca_possui" class="col-12"></entity-data>
                <entity-data :entity="entity" prop="mus_biblioteca_acessoPublico" class="col-12"></entity-data>
                <entity-data :entity="entity" prop="mus_equipe_dev_educativo" class="col-12"></entity-data>
                <entity-data :entity="entity" prop="mus_servicos_visitaGuiada" class="col-12"></entity-data>
                <entity-data :entity="entity" prop="mus_servicos_visitaGuiada_s" class="col-12"></entity-data>

                <div class="divider col-12"></div>

                <mc-title tag="h4" size="medium" class="bold col-12"><?= i::__("Atividades educativas e culturais para públicos específicos"); ?></mc-title>
                <entity-data :entity="entity" prop="mus_atividade_pub_especif" class="col-12"></entity-data>
                <entity-data :entity="entity" prop="mus_atividade_pub_especif_s" class="col-12"></entity-data>
            </div>
        </main>
    </mc-container>
</mc-tab>