<?php
$entityClass = $entity->getClassName();
$entityName = strtolower(array_slice(explode('\\', $entityClass),-1)[0]);
?>
    <?php if($this->isEditable()): ?>
        <span style="display: none" class="js-editable-taxonomy" data-original-title="Área de Atuação" data-taxonomy="area">Museu</span>
    <?php endif;?>