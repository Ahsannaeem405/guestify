<div class="btn-group">
    <?php $codes = Configure::read('Locales'); ?>
    <?php foreach($codes as $locale => $name) { ?>
        <?php echo $this->Html->link($this->Html->image('/img/flags/'.substr($locale, 0, 2).'.png'), array('controller' => 'users', 'action' => 'setInterfaceLanguage', $locale), array('class' => 'btn btn-link', 'title' => $name, 'alt' => $name.' flag', 'escape' => false)); ?>
    <?php } ?>
    <?php
    /*
    <span class="btn btn-link lang-tooltip" data-toggle="tooltip" data-placement="top" title="Coming soon"><img src="/img/flags/fr.png" alt=""></span>
    <span class="btn btn-link lang-tooltip" data-toggle="tooltip" data-placement="top" title="Coming soon"><img src="/img/flags/es.png" alt=""></span>
    <span class="btn btn-link lang-tooltip" data-toggle="tooltip" data-placement="top" title="Coming soon"><img src="/img/flags/it.png" alt=""></span>
    */
    ?>
</div>

<script>

    $(document).ready(function() {

        $('.lang-tooltip').tooltip({html: true});

    });

</script>
