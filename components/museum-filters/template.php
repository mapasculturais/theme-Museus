<?php

/**
 * @var MapasCulturais\App $app
 * @var MapasCulturais\Themes\BaseV2\Theme $this
 */

use MapasCulturais\i;
?>

<div v-if="municipios" class="field">
    <label><?php i::_e('Município') ?></label>

    <mc-multiselect :model="pseudoQuery['En_Municipio']" :items="municipios" #default="{popover, setFilter}" hide-filter hide-button>
        <input class="mc-multiselect--input" @keyup="setFilter($event.target.value)" @focus="popover.open()" placeholder="<?= i::esc_attr__('Selecione os municípios: ') ?>">
    </mc-multiselect>
    <mc-tag-list editable classes="space__background space__color" :tags="pseudoQuery['En_Municipio']"></mc-tag-list>
</div>

<div v-if="status" class="field">
    <label><?= i::__('Status do Museu') ?></label>

    <mc-multiselect :model="pseudoQuery['mus_status']" :items="status" #default="{popover, setFilter}" hide-filter hide-button>
        <input class="mc-multiselect--input" @keyup="setFilter($event.target.value)" @focus="popover.open()" placeholder="<?= i::esc_attr__('Selecione os status: ') ?>">
    </mc-multiselect>
    <mc-tag-list editable classes="space__background space__color" :tags="pseudoQuery['mus_status']"></mc-tag-list>
</div>

<div v-if="tematica" class="field">
    <label><?= i::__('tematica do Museu') ?></label>

    <mc-multiselect :model="pseudoQuery['mus_tipo_tematica']" :items="tematica" #default="{popover, setFilter}" hide-filter hide-button>
        <input class="mc-multiselect--input" @keyup="setFilter($event.target.value)" @focus="popover.open()" placeholder="<?= i::esc_attr__('Selecione as temáticas: ') ?>">
    </mc-multiselect>
    <mc-tag-list editable classes="space__background space__color" :tags="pseudoQuery['mus_tipo_tematica']"></mc-tag-list>
</div>

<div v-if="tipologia" class="field">
    <label><?= i::__('Tipologia do Museu') ?></label>

    <mc-multiselect :model="pseudoQuery['mus_tipo']" :items="tipologia" #default="{popover, setFilter}" hide-filter hide-button>
        <input class="mc-multiselect--input" @keyup="setFilter($event.target.value)" @focus="popover.open()" placeholder="<?= i::esc_attr__('Selecione as tipologias: ') ?>">
    </mc-multiselect>
    <mc-tag-list editable classes="space__background space__color" :tags="pseudoQuery['mus_tipo']"></mc-tag-list>
</div>

<div v-if="esferaTipo" class="field">
    <label><?= i::__('Esfera do Museu') ?></label>

    <mc-multiselect :model="pseudoQuery['esfera_tipo']" :items="esferaTipo" #default="{popover, setFilter}" hide-filter hide-button>
        <input class="mc-multiselect--input" @keyup="setFilter($event.target.value)" @focus="popover.open()" placeholder="<?= i::esc_attr__('Selecione as esferas: ') ?>">
    </mc-multiselect>
    <mc-tag-list editable classes="space__background space__color" :tags="pseudoQuery['esfera_tipo']"></mc-tag-list>
</div>