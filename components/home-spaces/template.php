<?php
/**
 * @var MapasCulturais\App $app
 * @var MapasCulturais\Themes\MapasMuseus\Theme $this
 */

use MapasCulturais\i;

$this->import('
	entity-card
	mc-avatar
');
?>
<div v-if="global.enabledEntities.spaces" class="home-spaces">
	<div class="home-spaces__header">
		<div class="home-spaces__header title">
			<label> <?= $this->text('title', i::__('Conheça os museus de Pernambuco'))?> </label>
		</div>        
		
	</div>    
	<div class="home-spaces__content">
		<div v-if="spaces.length <= 2" :class="['home-spaces__cards', {'home-spaces__cards--column': spaces.length==2}]" >
			<entity-card  v-for="space in spaces" :entity="space" portrait slice-description ></entity-card> 
		</div>
		<div v-if="spaces.length > 2" class="home-spaces__content cards">
			<carousel :settings="settings" :breakpoints="breakpoints">
				<slide v-for="space in spaces" :key="space.id">
					<entity-card :entity="space" portrait slice-description></entity-card> 
				</slide> 
				<template v-if="spaces.length > 1" #addons>
					<div class="actions">
						<navigation :slideWidth="368" />
					</div>
				</template>
			</carousel>
		</div>

		<span v-if="spaces.length <= 0" class="semibold">
                <?= $this->text('Museus encontrados', i::__('Nenhuma museu foi encontrada.')); ?>
            </span>
	</div>
</div>