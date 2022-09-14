<br/>
<?php if($app->user->profile->num_sniic):?>
<?php \MapasCulturais\i::_e('O Nº SNIIC do seu agente padrão') ?> "<?php echo $app->user->profile->name ?>" <?php \MapasCulturais\i::_e('é') ?> <?php echo $app->user->profile->num_sniic ?>
<?php endif?>