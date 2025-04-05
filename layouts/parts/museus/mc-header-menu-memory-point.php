<?php

/**
 * @var MapasCulturais\App $app
 * @var MapasCulturais\Themes\MapasMuseus\Theme $this
 */

use MapasCulturais\i;

?>
<?php $this->applyTemplateHook('mc-header-menu-memory', 'before') ?>
<li>
    <?php $this->applyTemplateHook('mc-header-menu-memory', 'begin') ?>
    <a href="<?= $app->createUrl('search', 'memory') ?>" class="mc-header-menu--item memory">
        <span class="icon"> <mc-icon name="space"> </span>
        <p class="label"> <?php i::_e('Pontos de memória') ?> </p>
    </a>
    <?php $this->applyTemplateHook('mc-header-menu-memory', 'end') ?>
</li>
<?php $this->applyTemplateHook('mc-header-menu-memory', 'after') ?>