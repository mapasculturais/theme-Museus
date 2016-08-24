<?php
$show_servicos = $this->isEditable() ||
        $entity->mus_servicos_visitaGuiada ||
        $entity->mus_servicos_atendimentoEstrangeiros;

$show_instalacoes = $this->isEditable() ||
        $entity->mus_instalacoes ||
        $entity->mus_instalacoes_capacidadeAuditorio ||
        $entity->mus_arquivo_possui ||
        $entity->mus_arquivo_acessoPublico ||
        $entity->mus_biblioteca_possui ||
        $entity->mus_biblioteca_acessoPublico;

$show_acervo = $this->isEditable() ||
        $entity->mus_acervo_comercializacao ||
        // $entity->mus_acervo_propriedade ||
        $entity->mus_acervo_comodato_formalizado ||
        $entity->mus_acervo_comodato_duracao ||
        // $entity->mus_acervo_material ||
        $entity->mus_acervo_material_emExpoicao ||
        $entity->mus_acervo_nucleoEdificado;

// $show_gestao = $this->isEditable() ||
//         $entity->mus_gestao_regimentoInterno ||
//         $entity->mus_gestao_planoMuseologico ||
//         $entity->mus_gestao_politicaAquisicao ||
//         $entity->mus_gestao_politicaDescarte;

$show_gestao = $this->isEditable();

$show_tipologia = $this->isEditable() ||
        $entity->mus_tipo ||
        $entity->mus_tipo_tematica;

?>
<div id="tab-mais" class="aba-content new-tab">
    <div class="servico">
        <?php if($this->isEditable() || $entity->mus_instituicaoMantenedora): ?>
        <p>
            <span class="label">Instituição mantenedora:</span>
            <span class="js-editable" data-edit="mus_instituicaoMantenedora" data-original-title="Instituição mantenedora" data-emptytext="Informe">
                <?php echo $entity->mus_instituicaoMantenedora; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_instumentoCriacao_tipo || $entity->mus_instumentoCriacao_descricao): ?>
        <p>
            <span class="label">Instrumento de criação:</span>
            <?php if($this->isEditable() || $entity->mus_instumentoCriacao_tipo): ?>
                <editable-singleselect entity-property="mus_instumentoCriacao_tipo" empty-label="Selecione" allow-other="true" box-title="O museu possui instrumento de criação?"></editable-singleselect>
            <?php endif; ?>
        </p>
        <p>
            <span class="label">Descrição:</span>
            <?php if($this->isEditable() || $entity->mus_instumentoCriacao_descricao): ?>
                <span
                    class="js-editable" data-edit="mus_instumentoCriacao_descricao"
                    data-original-title="Descrição do instrumento de criação" data-emptytext="Informe uma descrição"
                    >
                    <?php echo $entity->mus_instumentoCriacao_descricao; ?>
                </span>
                <em>somente para instrumento do tipo "Outros"</em>
            <?php endif; ?>
        </p>
        <?php endif; ?>


        <?php if($this->isEditable() || $entity->mus_anoDeAbertura): ?>
        <p>
            <span class="label">Status de abertura:</span>
            <span class="js-editable" data-edit="mus_status" data-original-title="Status de abertura" data-emptytext="Informe">
                <?php echo $entity->mus_status; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_abertura_ano): ?>
        <p>
            <span class="label">Ano de abertura:</span>
            <span class="js-editable" data-edit="mus_abertura_ano" data-original-title="Ano de abertura" data-emptytext="Informe">
                <?php echo $entity->mus_abertura_ano; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_abertura_publico): ?>
        <p>
            <span class="label">Tipo de público ao qual o museu é aberto:</span>
            <span class="js-editable" data-edit="mus_abertura_publico" data-original-title="Tipo de público ao qual o museu é aberto" data-emptytext="Informe">
                <?php echo $entity->mus_abertura_publico; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_atividadePrincipal): ?>
        <p>
            <span class="label">Atividade Principal:</span>
            <editable-singleselect entity-property="mus_atividadePrincipal" empty-label="Selecione" allow-other="true" box-title="Em relação à sua atividade principal, indique a opção que melhor caracterize a instituição"></editable-singleselect>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_caraterComunitario): ?>
        <p>
            <span class="label">O museu é de caráter comunitário?</span>
            <span class="js-editable" data-edit="mus_caraterComunitario" data-original-title="O museu é de caráter comunitário?" data-emptytext="Selecione">
                <?php echo $entity->mus_caraterComunitario; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_comunidadeRealizaAtividades): ?>
        <p>
            <span class="label">Em caso de museus comunitários, a comunidade realiza atividades museológicas?</span>
            <span class="js-editable" data-edit="mus_comunidadeRealizaAtividades" data-original-title="Em caso de museus comunitários, a comunidade realiza atividades museológicas?" data-emptytext="Selecione">
                <?php echo $entity->mus_comunidadeRealizaAtividades; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if ($show_tipologia): ?>
            <h5>Tipologia</h5> <!-- mover para o local apropriado -->
            <?php if($this->isEditable() || $entity->mus_tipo): ?>
            <p>
                <span class="label">Tipo:</span>
                <span class="js-editable" data-edit="mus_tipo" data-original-title="Tipo do museu" data-emptytext="Selecione">
                    <?php echo $entity->mus_tipo; ?>
                </span>
            </p>
            <?php endif; ?>


            <?php if($this->isEditable() || $entity->mus_tipo_tematica): ?>
            <p>
                <span class="label">Temática:</span>
                <span class="js-editable" data-edit="mus_tipo_tematica" data-original-title="Temática do museu" data-emptytext="Selecione">
                    <?php echo $entity->mus_tipo_tematica; ?>
                </span>
            </p>
            <?php endif; ?>
        <?php endif; ?>

        <?php if($this->isEditable()): ?>
        <p style="margin-top:1em"><em>somente para o tipo "Unidade de conservação da natureza"</em></p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_tipo_tematica === 'Unidade de conservação da natureza'): ?>
            <?php if($this->isEditable() || $entity->mus_tipo_unidadeConservacao): ?>
            <p>
                <span class="label">Tipo/categoria de manejo da Unidade de Conservação:</span>
                <span class="js-editable" data-edit="mus_tipo_unidadeConservacao" data-original-title="Tipo/categoria de manejo da Unidade de Conservação" data-emptytext="Selecione">
                    <?php echo $entity->mus_tipo_unidadeConservacao; ?>
                </span>
            </p>
            <?php endif; ?>

            <?php if($this->isEditable() || $entity->mus_tipo_unidadeConservacao_protecaoIntegral): ?>
            <p>
                <span class="label">Tipo de unidade de proteção integral:</span>
                <span class="js-editable" data-edit="mus_tipo_unidadeConservacao_protecaoIntegral" data-original-title="Tipo de unidade de proteção integral" data-emptytext="Selecione">
                    <?php echo $entity->mus_tipo_unidadeConservacao_protecaoIntegral; ?>
                </span>
            </p>
            <?php endif; ?>

            <?php if($this->isEditable() || $entity->mus_tipo_unidadeConservacao_usoSustentavel): ?>
            <p>
                <span class="label">Tipo de unidade de uso sustentável:</span>
                <span class="js-editable" data-edit="mus_tipo_unidadeConservacao_usoSustentavel" data-original-title="Tipo de unidade de uso sustentável" data-emptytext="Selecione">
                    <?php echo $entity->mus_tipo_unidadeConservacao_usoSustentavel; ?>
                </span>
            </p>
            <?php endif; ?>

        <?php endif; ?>

        <?php if($show_servicos): ?>
            <h5>Serviços</h5>
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
            <span class="label">Atendimento aos turistas estrangeiros:</span>
            <editable-multiselect entity-property="mus_servicos_atendimentoEstrangeiros" empty-label="Selecione" box-title="Atendimento ao turista estrangeiro" help-text="O museu possui recursos para atendimento de turistas estrangeiros, como sinalização, audioguia, folder etc. em outros idiomas?"></editable-multiselect>
        </p>
        <?php endif; ?>

        <?php if($show_instalacoes):?>
            <h5>Instalações</h5>
        <?php endif ?>

        <?php if($this->isEditable() || $entity->mus_instalacoes): ?>
        <p>
            <span class="label">Instalações básicas e serviços oferecidos:</span>
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

        <?php if($show_acervo): ?>
            <h5>Acervo e exposições</h5>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_acervo_comercializacao): ?>
        <p>
            <span class="label">Comercialização:</span>
            <span class="js-editable" data-edit="mus_acervo_comercializacao" data-original-title="Comercialização do acervo" data-emptytext="Selecione">
                <?php echo $entity->mus_acervo_comercializacao; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable()): ?>
        <p class="privado">
            <span class="icon icon-private-info"></span>
            <span class="label">Propriedade:</span>
            <span class="js-editable" data-edit="mus_acervo_propriedade" data-original-title="Propriedade do acervo" data-emptytext="Selecione">
                <?php echo $entity->mus_acervo_propriedade; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_acervo_comodato_formalizado): ?>
        <p>
            <span class="label">O comodato/empréstimo está formalizado:</span>
            <span class="js-editable" data-edit="mus_acervo_comodato_formalizado" data-original-title="O comodato/empréstimo está formalizado por meio de documento legal?" data-emptytext="Selecione">
                <?php echo $entity->mus_acervo_comodato_formalizado; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_acervo_comodato_duracao): ?>
        <p>
            <span class="label">Duração do comodato/empréstimo (em meses):</span>
            <span class="js-editable" data-edit="mus_acervo_comodato_duracao" data-original-title="Especifique, em meses, a duração do comodato/empréstimo" data-emptytext="Informe">
                <?php echo $entity->mus_acervo_comodato_duracao; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable()): ?>
        <p class="privado">
            <span class="icon icon-private-info"></span>
            <span class="label">Possui acervo material:</span>
            <span class="js-editable" data-edit="mus_acervo_material" data-original-title="O museu possui acervo material?" data-emptytext="Selecione">
                <?php echo $entity->mus_acervo_material; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_acervo_material_emExpoicao): ?>
        <p>
            <span class="label">O acervo material encontra-se em exposição:</span>
            <span class="js-editable" data-edit="mus_acervo_material_emExposicao" data-original-title="O acervo material encontra-se em exposição?" data-emptytext="Selecione">
                <?php echo $entity->mus_acervo_material_emExposicao; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || $entity->mus_acervo_nucleoEdificado): ?>
        <p>
            <span class="label">Núcleo Edificado:</span>
            <editable-multiselect entity-property="mus_acervo_nucleoEdificado" empty-label="Selecione" box-title="Núcleo Edificado"></editable-multiselect>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable()): ?>
        <p class="privado">
            <span class="icon icon-private-info"></span>
            <span class="label">Duração das exposições:</span>
            <span class="js-editable" data-edit="mus_exposicoes_duracao" data-original-title="Duração das exposições" data-emptytext="Selecione">
                <?php echo $entity->mus_exposicoes_duracao; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable()): ?>
        <p class="privado">
            <span class="icon icon-private-info"></span>
            <span class="label">O museu é itinerante:</span>
            <span class="js-editable" data-edit="mus_itinerante" data-original-title="O museu é itinerante?" data-emptytext="Selecione">
                <?php echo $entity->mus_itinerante; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable()): ?>
        <p class="privado">
            <span class="icon icon-private-info"></span>
            <span class="label">Depende de recursos financeiros de outra instituição para a itinerância da exposição:</span>
            <span class="js-editable" data-edit="mus_itinerante_dependeRecursos" data-original-title="O museu depende de recursos financeiros de outra instituição para a itinerância da exposição?" data-emptytext="Selecione">
                <?php echo $entity->mus_itinerante_dependeRecursos; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($show_gestao): ?>
            <h5>Gestão</h5>
            <p class="privado">
                <span class="icon icon-private-info"></span>
                <span class="label">Posui regimento interno?</span>
                <span class="js-editable" data-edit="mus_gestao_regimentoInterno" data-original-title="O museu posui regimento interno?" data-emptytext="Selecione">
                    <?php echo $entity->mus_gestao_regimentoInterno; ?>
                </span>
            </p>
            <p class="privado">
                <span class="icon icon-private-info"></span>
                <span class="label">Possui plano museológico?</span>
                <span class="js-editable" data-edit="mus_gestao_planoMuseologico" data-original-title="O museu possui plano museológico?" data-emptytext="Selecione">
                    <?php echo $entity->mus_gestao_planoMuseologico; ?>
                </span>
            </p>
            <p class="privado">
                <span class="icon icon-private-info"></span>
                <span class="label">Possui política de aquisição de acervo?</span>
                <span class="js-editable" data-edit="mus_gestao_politicaAquisicao" data-original-title="O museu possui política de aquisição de acervo?" data-emptytext="Selecione">
                    <?php echo $entity->mus_gestao_politicaAquisicao; ?>
                </span>
            </p>
            <p class="privado">
                <span class="icon icon-private-info"></span>
                <span class="label">Possui política de descarte de acervo?</span>
                <span class="js-editable" data-edit="mus_gestao_politicaDescarte" data-original-title="O museu possui política de descarte de acervo?" data-emptytext="Selecione">
                    <?php echo $entity->mus_gestao_politicaDescarte; ?>
                </span>
            </p>
        <?php endif; ?>
    </div>
</div>