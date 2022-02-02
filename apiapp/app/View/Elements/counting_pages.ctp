<div class="pagination lead">
    <?php
        echo __('Page', true).' ';
        echo $this->Paginator->counter(array(
            'separator' => ' '.__('of', true).' '
        ));
    ?>
</div>
