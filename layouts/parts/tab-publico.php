<div id="tab-publico" class="aba-content new-tab">
    <div class="servico">
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
                <span class="label">Descrição do valor da entrada:</span> 
                <span class="js-editable" data-edit="mus_ingresso_valor" data-original-title="Valor da entrada no museu" data-emptytext="Descreva"><?php echo $this->isEditable() ? $entity->mus_ingresso_valor : nl2br($entity->mus_ingresso_valor); ?></span>
            </p>
        <?php endif; ?>

        <h5>Horários de Funcionamento</h5>

        <?php if($this->isEditable() || ($entity->mus_horario_segunda_das && $entity->mus_horario_segunda_ate)): ?>
        <p>
            <span class="bib-horario-dia">Segundas-feiras</span> <?php if(!$this->isEditable()) echo 'das'; ?>
            <span class="js-editable js-mask-time" data-edit="mus_horario_segunda_das" data-original-title="Horário de abertura segundas-feiras" data-emptytext="das">
                <?php echo $entity->mus_horario_segunda_das; ?>
            </span>
            <?php if(!$this->isEditable()) echo 'até as'; ?>
            <span class="js-editable js-mask-time" data-edit="mus_horario_segunda_ate" data-original-title="Horário de fechamento segundas-feiras" data-emptytext="até as">
                <?php echo $entity->mus_horario_segunda_ate; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || ($entity->mus_horario_terca_das && $entity->mus_horario_terca_ate)): ?>
        <p>
            <span class="bib-horario-dia">Terças-feiras</span> <?php if(!$this->isEditable()) echo 'das'; ?>
            <span class="js-editable js-mask-time" data-edit="mus_horario_terca_das" data-original-title="Horário de abertura terças-feiras" data-emptytext="das">
                <?php echo $entity->mus_horario_terca_das; ?>
            </span>
            <?php if(!$this->isEditable()) echo 'até as'; ?>
            <span class="js-editable js-mask-time" data-edit="mus_horario_terca_ate" data-original-title="Horário de fechamento terças-feiras" data-emptytext="até as">
                <?php echo $entity->mus_horario_terca_ate; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || ($entity->mus_horario_quarta_das && $entity->mus_horario_quarta_ate)): ?>
        <p>
            <span class="bib-horario-dia">Quartas-feiras</span> <?php if(!$this->isEditable()) echo 'das'; ?>
            <span class="js-editable js-mask-time" data-edit="mus_horario_quarta_das" data-original-title="Horário de abertura quartas-feiras" data-emptytext="das">
                <?php echo $entity->mus_horario_quarta_das; ?>
            </span>
            <?php if(!$this->isEditable()) echo 'até as'; ?>
            <span class="js-editable js-mask-time" data-edit="mus_horario_quarta_ate" data-original-title="Horário de fechamento quartas-feiras" data-emptytext="até as">
                <?php echo $entity->mus_horario_quarta_ate; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || ($entity->mus_horario_quinta_das && $entity->mus_horario_quinta_ate)): ?>
        <p>
            <span class="bib-horario-dia">Quintas-feiras</span> <?php if(!$this->isEditable()) echo 'das'; ?>
            <span class="js-editable js-mask-time" data-edit="mus_horario_quinta_das" data-original-title="Horário de abertura quintas-feiras" data-emptytext="das">
                <?php echo $entity->mus_horario_quinta_das; ?>
            </span>
            <?php if(!$this->isEditable()) echo 'até as'; ?>
            <span class="js-editable js-mask-time" data-edit="mus_horario_quinta_ate" data-original-title="Horário de fechamento quintas-feiras" data-emptytext="até as">
                <?php echo $entity->mus_horario_quinta_ate; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || ($entity->mus_horario_sexta_das && $entity->mus_horario_sexta_ate)): ?>
        <p>
            <span class="bib-horario-dia">Sextas-feiras</span> <?php if(!$this->isEditable()) echo 'das'; ?>
            <span class="js-editable js-mask-time" data-edit="mus_horario_sexta_das" data-original-title="Horário de abertura sextas-feiras" data-emptytext="das">
                <?php echo $entity->mus_horario_sexta_das; ?>
            </span>
            <?php if(!$this->isEditable()) echo 'até as'; ?>
            <span class="js-editable js-mask-time" data-edit="mus_horario_sexta_ate" data-original-title="Horário de fechamento sextas-feiras" data-emptytext="até as">
                <?php echo $entity->mus_horario_sexta_ate; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || ($entity->mus_horario_sabado_das && $entity->mus_horario_sabado_ate)): ?>
        <p>
            <span class="bib-horario-dia">Sábados</span> <?php if(!$this->isEditable()) echo 'das'; ?>
            <span class="js-editable js-mask-time" data-edit="mus_horario_sabado_das" data-original-title="Horário de abertura sábados" data-emptytext="das">
                <?php echo $entity->mus_horario_sabado_das; ?>
            </span>
            <?php if(!$this->isEditable()) echo 'até as'; ?>
            <span class="js-editable js-mask-time" data-edit="mus_horario_sabado_ate" data-original-title="Horário de fechamento sábados" data-emptytext="até as">
                <?php echo $entity->mus_horario_sabado_ate; ?>
            </span>
        </p>
        <?php endif; ?>

        <?php if($this->isEditable() || ($entity->mus_horario_domingo_das && $entity->mus_horario_domingo_ate)): ?>
        <p>
            <span class="bib-horario-dia">Domingos</span> <?php if(!$this->isEditable()) echo 'das'; ?>
            <span class="js-editable js-mask-time" data-edit="mus_horario_domingo_das" data-original-title="Horário de abertura domingos" data-emptytext="das">
                <?php echo $entity->mus_horario_domingo_das; ?>
            </span>
            <?php if(!$this->isEditable()) echo 'até as'; ?>
            <span class="js-editable js-mask-time" data-edit="mus_horario_domingo_ate" data-original-title="Horário de fechamento domingos" data-emptytext="até as">
                <?php echo $entity->mus_horario_domingo_ate; ?>
            </span>
        </p>
        <?php endif; ?>
    </div>
</div>