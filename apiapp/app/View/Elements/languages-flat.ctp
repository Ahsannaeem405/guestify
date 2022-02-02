<div class="btn-group">
    <?php $codes = Configure::read('Locales'); ?>
    <?php foreach($codes as $locale => $name) { ?>
        <?php echo $this->Html->link($this->Html->image('/img/flags/'.substr($locale, 0, 2).'.png'), array('controller' => 'users', 'action' => 'setInterfaceLanguage', $locale), array('class' => 'btn btn-link', 'title' => '', 'escape' => false)); ?>
    <?php } ?>
</div>
