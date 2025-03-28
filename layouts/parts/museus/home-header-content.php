<?php
/**
 * @var MapasCulturais\App $app
 * @var MapasCulturais\Themes\MapasMuseus\Theme $this
 */

use MapasCulturais\i;
$auth = $app->createUrl('auth', 'index');

$this->import('
    create-space
    mc-icon
')
?>

<?php if ($app->user->is('guest')):  ?>
    <div class="home-header-content">
        <a href="<?= $auth ?>" class="home-header-content__button button button--primary button--icon">
            <mc-icon name="add"></mc-icon>
            <span><?= i::__('Criar Espaço') ?></span>
        </a>
    </div>
<?php else:  ?>
    <div class="home-header-content">
        <create-space #default="{modal}">
            <button @click="modal.open()" class="home-header-content__button button button--primary button--icon">
                <mc-icon name="add"></mc-icon>
                <span><?= i::__('Criar Espaço') ?></span>
            </button>
        </create-space>
    </div>
<?php endif  ?>

