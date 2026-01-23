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
    <div class="home-header__banner">
        <a href="<?= $auth ?>">
            <img :src="banner" />
        </a>
    </div>
<?php else:  ?>
    <div class="home-header-content">
        <create-space #default="{modal}">
            <div class="home-header__banner">
                <a href="javascript:void(0)"  @click="modal.open()">
                    <img :src="banner" />
                </a>
            </div>
        </create-space>
    </div>
<?php endif  ?>

