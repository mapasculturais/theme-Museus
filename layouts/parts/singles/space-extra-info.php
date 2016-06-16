<?php if ( $this->isEditable() || $entity->longDescription ): ?>
    <h3>Descrição</h3>
    <span class="descricao js-editable" data-edit="longDescription" data-original-title="Descrição <?php $this->dict('entities: of the Space') ?>" data-emptytext="Insira uma descrição <?php $this->dict('entities: of the space') ?>" ><?php echo $this->isEditable() ? $entity->longDescription : nl2br($entity->longDescription); ?></span>
    <h3>Informações Adicionais</h3>
    <span
        class="js-editable"
        data-edit="mus_add_info"
        data-original-title="Informações adicionais <?php $this->dict('entities: of the Space') ?>"
        data-emptytext="Insira informações adicionais <?php $this->dict('entities: of the space') ?>" >
        <?php echo $this->isEditable() ? $entity->mus_add_info : nl2br($entity->mus_add_info); ?>
    </span>
<?php endif; ?>
