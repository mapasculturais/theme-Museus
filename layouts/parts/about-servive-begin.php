<?php if($this->isEditable() || $entity->acessibilidade_fisica): ?>
<p>
    <span class="label">O Museu encontra-se:</span> 
    <span class="js-editable" data-edit="mus_status" data-original-title="Status do museu" data-emptytext="Selecione status do museu"><?php echo $entity->mus_status; ?></span>
</p>
<?php endif; ?>