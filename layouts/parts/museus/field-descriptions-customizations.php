<?php

use MapasCulturais\i;

?>

<small v-if="prop == 'shortDescription'">
    <small><?php i::_e("Descreva de forma sucinta sobre o Museu") ?></small>
</small>


<div v-if="prop == 'longDescription'">
    <label class="files-list__title"><?php i::_e("Descrição longa") ?></label> <br>
    <small><?php i::_e("Neste campo descreva detalhadamente sobre o museu, seu histórico, suas atividades, seu acervo e demais informações pertinentes.") ?></small>
</div>