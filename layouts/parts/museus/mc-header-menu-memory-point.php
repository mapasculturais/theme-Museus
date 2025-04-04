<?php
/**
 * @var MapasCulturais\App $app
 * @var MapasCulturais\Themes\MapasMuseus\Theme $this
 */

use MapasCulturais\i;

?>
<div class="mc-header-menu--memory-point">
    <a href="<?= $app->createUrl('search', 'spaces') ?>/?ponto_memoria=true?" class="mc-header-menu--item space">
        <span class="icon"> <mc-icon name="space"> </span>
        <p class="label"> <?php i::_e('Pontos de memória') ?> </p>
    </a> 
</div>


