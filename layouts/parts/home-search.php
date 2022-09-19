<section id="home-intro" class="js-page-menu-item home-entity clearfix">
    <?php $this->applyTemplateHook('home-search','begin'); ?>
    <div class="box">
        <h1><?php echo $app->view->renderMarkdown($this->dict('home: title',false)); ?></h1>
        <div style="text-align: justify;line-height: 2em;font-size: 18px;">
            <p><?php echo $app->view->renderMarkdown($this->dict('home: welcome',false)); ?></p>
        </div>
        <?php $this->applyTemplateHook('home-search-form','begin'); ?>
        <form id="home-search-form" class="clearfix" ng-non-bindable>
            <?php $this->applyTemplateHook('home-search-form','before'); ?>
           
            <?php $this->applyTemplateHook('home-search-form','end'); ?>
        </form>
        <?php $this->applyTemplateHook('home-search-form','after'); ?>
    </div>
    <div class="view-more"><a class="hltip icon icon-select-arrow" href="#home-events" title="<?php \MapasCulturais\i::esc_attr_e("Saiba mais");?>"></a></div>
    <?php $this->applyTemplateHook('home-search','end'); ?>
</section>

