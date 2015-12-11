<div id="tab-mais" class="aba-content">
    <div class="servico">

        <?php if($this->isEditable() || $entity->mus_servicos_instalacoes): ?>
        <p>
            <span class="label">Assinale as instalações básicas e serviços oferecidos pelo museu:</span>
            <editable-multiselect entity-property="mus_servicos_instalacoes" empty-label="Selecione" box-title="Assinale as instalações básicas e serviços oferecidos pelo museu" allow-other="true"></editable-multiselect>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_servicos_instalacoes_capacidadeAuditorio): ?>
        <p>
            <span class="label">Capacidade do teatro/auditório (assentos):</span>
            <span class="js-editable" data-edit="mus_servicos_instalacoes_capacidadeAuditorio" data-original-title="Capacidade do teatro/auditório (assentos)" data-emptytext="Informe">
                <?php echo $entity->mus_servicos_instalacoes_capacidadeAuditorio; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_servicos_visitaGuiada): ?>
        <p>
            <span class="label">O museu promove visitas guiadas?</span>
            <span class="js-editable" data-edit="mus_servicos_visitaGuiada" data-original-title="O museu promove visitas guiadas?" data-emptytext="Selecione">
                <?php echo $entity->mus_servicos_visitaGuiada; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_servicos_atendimentoEstrangeiros): ?>
        <p>
            <span class="label">O museu possui recursos para atendimento de turistas estrangeiros, como sinalização, audioguia, folder etc. em outros idiomas?</span>
            <editable-multiselect entity-property="mus_servicos_atendimentoEstrangeiros" empty-label="Selecione" allow-other="true" box-title="O museu possui recursos para atendimento de turistas estrangeiros, como sinalização, audioguia, folder etc. em outros idiomas?"></editable-multiselect>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_acessibilidade_fisica): ?>
        <p>
            <span class="label">O museu possui infraestrutura para atender visitantes que apresentam dificuldade de locomoção?</span>
            <editable-multiselect entity-property="mus_acessibilidade_fisica" empty-label="Selecione" allow-other="true" box-title="O museu possui infraestrutura para atender visitantes que apresentam dificuldade de locomoção?"></editable-multiselect>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_acessibilidade_visual): ?>
        <p>
            <span class="label">O museu oferece instalações e serviços destinados às pessoas com deficiências auditivas e visuais?</span>
            <editable-multiselect entity-property="mus_acessibilidade_visual" empty-label="Selecione" allow-other="true" box-title="O museu oferece instalações e serviços destinados às pessoas com deficiências auditivas e visuais?"></editable-multiselect>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_arquivo_possui): ?>
        <p>
            <span class="label">O museu possui arquivo histórico?</span>
            <span class="js-editable" data-edit="mus_arquivo_possui" data-original-title="O museu possui arquivo histórico?" data-emptytext="Selecione">
                <?php echo $entity->mus_arquivo_possui; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_arquivo_acessoPublico): ?>
        <p>
            <span class="label">O arquivo tem acesso ao público?</span>
            <span class="js-editable" data-edit="mus_arquivo_acessoPublico" data-original-title="O arquivo tem acesso ao público?" data-emptytext="Selecione">
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
            <span class="label">A biblioteca tem acesso ao público?</span>
            <span class="js-editable" data-edit="mus_biblioteca_acessoPublico" data-original-title="A biblioteca tem acesso ao público?" data-emptytext="Selecione">
                <?php echo $entity->mus_biblioteca_acessoPublico; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_biblioteca_acessoPublico): ?>
        <p>
            <span class="label">A biblioteca tem acesso ao público?</span>
            <span class="js-editable" data-edit="mus_biblioteca_acessoPublico" data-original-title="A biblioteca tem acesso ao público?" data-emptytext="Selecione">
                <?php echo $entity->mus_biblioteca_acessoPublico; ?>
            </span>
        </p>
        <?php endif; ?>

        <!-- cnpj baseminc -->

        <?php if($this->isEditable() || $entity->mus_atividadePrincipal): ?>
        <p>
            <span class="label">Em relação à sua atividade principal, indique a opção que melhor caracterize a instituição:</span>
            <editable-singleselect entity-property="mus_atividadePrincipal" empty-label="Selecione" allow-other="true" box-title="Em relação à sua atividade principal, indique a opção que melhor caracterize a instituição"></editable-singleselect>
        </p>
        <?php endif; ?>

    </div>
</div>