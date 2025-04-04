<?php

use MapasCulturais\i;

/**
 * @var MapasCulturais\App $app
 * @var MapasCulturais\Themes\BaseV2\Theme $this
 */

$seal_id = $app->config['museus.memoryPoint.sealId'];
?>

<label> <input v-model="pseudoQuery['@seals']" true-value="<?=$seal_id?>" :false-value="undefined" type="checkbox"> <?php i::_e('Pontos de memória') ?> </label>