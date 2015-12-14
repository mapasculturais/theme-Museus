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
    </div>
</div>