<?php if(!$app->user->is('guest') && !$entity->owned && !$entity->ownerUser->equals($app->user)): ?>
<a href="<?php echo $app->createUrl('space', 'own', [$entity->id]); ?>" class="btn btn-danger btn-meu-museu-single js-botao-meu-museu" >Este é o meu museu</a>
<?php endif; ?>