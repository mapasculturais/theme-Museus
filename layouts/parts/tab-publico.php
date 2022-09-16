<?php

$show_acessibilidade = $this->isEditable() ||
    $entity->acessibilidade ||
    $entity->acessibilidade_fisica ||
    $entity->mus_acessibilidade_visual;


$show_instalacoes = $this->isEditable() ||
    $entity->mus_instalacoes ||
    $entity->mus_instalacoes_capacidadeAuditorio ||
    $entity->mus_arquivo_possui ||
    $entity->mus_arquivo_acessoPublico ||
    $entity->mus_biblioteca_possui ||
    $entity->mus_biblioteca_acessoPublico;
?>

<div id="tab-publico" class="aba-content new-tab">
    <div class="servico">
        <?php if($this->isEditable() || $entity->mus_status): ?>
        <p>
            <span class="label">O Museu encontra-se:</span>
            <span class="js-editable" data-edit="mus_status" data-original-title="Status do museu" data-emptytext="Selecione status do museu"><?php echo $entity->mus_status; ?></span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_previsao_abertura_mes || $entity->mus_previsao_abertura_ano): ?>
            <p>
                <span class="label">Em caso de museu fechado, qual a previsão de abertura?</span><br>
                <?php if ($this->isEditable() || $entity->mus_previsao_abertura_mes): ?>
                    <span class="label">Mês:</span>
                    <span class="js-editable" data-edit="mus_previsao_abertura_mes" data-original-title="Previsão de Abertura (Mês)" data-emptytext="Selecione o mês"><?php echo $entity->mus_previsao_abertura_mes; ?></span><br>
                <?php endif; ?>
                <?php if ($this->isEditable() || $entity->mus_previsao_abertura_ano): ?>
                    <span class="label">Ano:</span>
                    <span class="js-editable" data-edit="mus_previsao_abertura_ano" data-original-title="Previsão de Abertura (Ano)" data-emptytext="Selecione o ano"><?php echo $entity->mus_previsao_abertura_ano; ?></span>
                <?php endif; ?>
            </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_metodo_contagem_pub): ?>
            <p><span class="label">Método de contagem de publico: </span><span class="js-editable" data-edit="mus_metodo_contagem_pub" data-original-title="Método de contagem de publico" data-emptytext="Método de contagem de publico"><?php echo $entity->mus_metodo_contagem_pub; ?></span></p>
        <?php endif; ?>
            <br>
        <?php if($this->isEditable() || $entity->mus_ingresso_cobrado || $entity->mus_ingresso_valor): ?>
        <h5 style="margin-top:0">Entrada</h5>
        <?php endif; ?>
        <?php if($this->isEditable() || $entity->mus_ingresso_cobrado): ?>
            <p>
                <span class="label">Entrada é cobrada:</span>
                <span class="js-editable" data-edit="mus_ingresso_cobrado" data-original-title="A entrada no museu é cobrada?" data-emptytext="Selecione"><?php echo $entity->mus_ingresso_cobrado; ?></span>
            </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_ingresso_valor): ?>
            <p>
                <span class="label">Em caso positivo, informe o valor cobrado SOMENTE para o público em geral:</span>
                <span class="js-editable" data-edit="mus_ingresso_valor" data-original-title="Em caso positivo, informe o valor cobrado SOMENTE para o público em geral" data-emptytext="Informe"><?php echo $entity->mus_ingresso_valor; ?></span>
            </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_desc_valor_ingresso): ?>
            <p>
                <span class="label">Observações sobre cobrança de entrada:</span>
                <span class="js-editable" data-edit="mus_desc_valor_ingresso" data-original-title="Observações sobre cobrança de entrada" data-emptytext="Descreva"><?php echo $this->isEditable() ? $entity->mus_desc_valor_ingresso : nl2br($entity->mus_ingresso_valor); ?></span>
            </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->horario): ?>
            <p><span class="label">Dias e horários de abertura ao público: </span><span class="js-editable" data-edit="horario" data-original-title="Dias e horários de abertura ao público:" data-emptytext="Insira os dias e horários de abertura ao público:"><?php echo $entity->horario; ?></span></p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_obs_horario): ?>
            <p><span class="label">Observações dias e horários de abertura:</span><span class="js-editable" data-edit="mus_obs_horario" data-original-title="Observações dias e horários de abertura:" data-emptytext="Insira as observações dos dias e horários de abertura"><?php echo $entity->mus_obs_horario; ?></span></p>
        <?php endif; ?>
        
        <?php if($show_acessibilidade):?>
            <h5>Acessibilidade</h5>
        <?php endif ?>

        <?php if($this->isEditable() || $entity->acessibilidade): ?>
            <p><span class="label">O museu possui infraestrutura para atender visitantes que apresentam dificuldade de locomoção?</span><span class="js-editable" data-edit="acessibilidade" data-original-title="O museu possui infraestrutura para atender visitantes que apresentam dificuldade de locomoção?"><?php echo $entity->acessibilidade; ?></span></p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->acessibilidade_fisica): ?>
            <p>
                <span class="label">Em caso positivo, especifique:</span>
                <editable-multiselect entity-property="acessibilidade_fisica" empty-label="Selecione" allow-other="true" box-title="Em caso positivo, especifique:"></editable-multiselect>
            </p>
        <?php endif; ?>
        <?php $this->applyTemplateHook('acessibilidade','after'); ?>

        <?php if($this->isEditable() || $entity->mus_acess_visual_auditiva): ?>
            <p><span class="label">O museu oferece instalações e serviços destinados às pessoas com deficiências auditivas e/ou visuais?</span><span class="js-editable" data-edit="mus_acess_visual_auditiva" data-original-title="O museu oferece instalações e serviços destinados às pessoas com deficiências auditivas e/ou visuais?"><?php echo $entity->mus_acess_visual_auditiva; ?></span></p>
        <?php endif; ?>
        
        <?php if($this->isEditable() || $entity->mus_acessibilidade_visual): ?>
        <p>
            <span class="label">Em caso positivo, especifique:</span>
            <editable-multiselect entity-property="mus_acessibilidade_visual" empty-label="Selecione" allow-other="true" box-title="Em caso positivo, especifique:" help-text="Em caso positivo, especifique"></editable-multiselect>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_servicos_atendimentoEstrangeiros): ?>
        <p>
            <span class="label">O museu possui recursos para atendimento de turistas estrangeiros como sinalização, audioguia, folder etc. em outros idiomas?</span>
            <editable-multiselect entity-property="mus_servicos_atendimentoEstrangeiros" empty-label="Selecione" box-title="Atendimento ao turista estrangeiro" help-text="O museu possui recursos para atendimento de turistas estrangeiros, como sinalização, audioguia, folder etc. em outros idiomas?"></editable-multiselect>
        </p>
        <?php endif; ?>

        <?php if($show_instalacoes):?>
            <h5>Instalações</h5>
        <?php endif ?>

        <?php if($this->isEditable() || $entity->mus_instalacoes): ?>
        <p>
            <span class="label">Assinale as instalações básicas e serviços oferecidos pelo museu:</span>
            <editable-multiselect entity-property="mus_instalacoes" empty-label="Selecione" box-title="Assinale as instalações básicas e serviços oferecidos pelo museu" allow-other="true"></editable-multiselect>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_instalacoes_capacidadeAuditorio): ?>
        <p>
            <span class="label">Capacidade do teatro/auditório (assentos):</span>
            <span class="js-editable" data-edit="mus_instalacoes_capacidadeAuditorio" data-original-title="Capacidade do teatro/auditório (assentos)" data-emptytext="Informe">
                <?php echo $entity->mus_instalacoes_capacidadeAuditorio; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_arquivo_possui): ?>
        <p>
            <span class="label">O museu possui arquivo histórico (arquivos/coleções adquiridas)? </span>
            <span class="js-editable" data-edit="mus_arquivo_possui" data-original-title="O museu possui arquivo histórico (arquivos/coleções adquiridas)?" data-emptytext="Selecione">
                <?php echo $entity->mus_arquivo_possui; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_arquivo_acessoPublico): ?>
        <p>
            <span class="label">O arquivo histórico está aberto para consulta de usuários externos?</span>
            <span class="js-editable" data-edit="mus_arquivo_acessoPublico" data-original-title="O arquivo histórico está aberto para consulta de usuários externos?" data-emptytext="Selecione">
                <?php echo $entity->mus_arquivo_acessoPublico; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_biblioteca_possui): ?>
        <p>
            <span class="label">O Museu possui biblioteca?</span>
            <span class="js-editable" data-edit="mus_biblioteca_possui" data-original-title="O Museu possui biblioteca?" data-emptytext="Selecione">
                <?php echo $entity->mus_biblioteca_possui; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_biblioteca_acessoPublico): ?>
        <p>
            <span class="label">O acervo bibliográfico está aberto para consulta de usuários externos?</span>
            <span class="js-editable" data-edit="mus_biblioteca_acessoPublico" data-original-title="O acervo bibliográfico está aberto para consulta de usuários externos?" data-emptytext="Selecione">
                <?php echo $entity->mus_biblioteca_acessoPublico; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_equipe_dev_educativo): ?>
        <p>
            <span class="label">O museu possui equipe PRÓPRIA para desenvolvimento e realização de ações educativas e culturais?</span>
            <span class="js-editable" data-edit="mus_equipe_dev_educativo" data-original-title="O museu possui equipe PRÓPRIA para desenvolvimento e realização de ações educativas e culturais?" data-emptytext="Selecione">
                <?php echo $entity->mus_equipe_dev_educativo; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_servicos_visitaGuiada): ?>
        <p>
            <span class="label">O museu promove visitas com guia/mediador/monitor/educador/orientador?</span>
            <span class="js-editable" data-edit="mus_servicos_visitaGuiada" data-original-title="O museu promove visitas com guia/mediador/monitor/educador/orientador?" data-emptytext="Selecione">
                <?php echo $entity->mus_servicos_visitaGuiada; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_servicos_visitaGuiada_s): ?>
        <p>
            <span class="label">Em caso positivo, especifique:</span>
            <span class="js-editable" data-edit="mus_servicos_visitaGuiada_s" data-original-title="Em caso positivo, especifique" data-emptytext="Selecione">
                <?php echo $entity->mus_servicos_visitaGuiada_s; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_atividade_pub_especif || $entity->mus_atividade_pub_especif_s): ?>
            <h5>Atividades educativas e culturais</h5>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_atividade_pub_especif): ?>
            <p>
                <span class="label">O museu realiza atividades educativas e culturais para públicos específicos?</span>
                <span class="js-editable" data-edit="mus_atividade_pub_especif" data-original-title="O museu realiza atividades educativas e culturais para públicos específicos?" data-emptytext="Selecione"><?php echo $entity->mus_atividade_pub_especif; ?></span>
            </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_atividade_pub_especif_s): ?>
            <p>
                <span class="label">Em caso positivo, especifique:</span>
                <editable-multiselect entity-property="mus_atividade_pub_especif_s" empty-label="Selecione" allow-other="true" box-title="Em caso positivo, especifique:"></editable-multiselect>
            </p>
        <?php endif; ?>
    </div>
</div>