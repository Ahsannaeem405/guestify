<div>
    <ul class="pagination">
        <li><?php echo $this->Paginator->first(__('First', true)); ?></li>
        <?php
            echo $this->Paginator->prev(' '.'<span class="glyphicon glyphicon-chevron-left"></span>'.' ', array('tag' => 'li', 'escape' => false), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a', 'escape' => false));
            echo $this->Paginator->numbers(array('class' => 'hidden-xs', 'separator' => '','currentTag' => 'a', 'currentClass' => 'active','tag' => 'li', /*'first' => 1,*/ 'escape' => false));
            echo $this->Paginator->next(' '.'<span class="glyphicon glyphicon-chevron-right"></span>'.' ', array('tag' => 'li','currentClass' => 'disabled', 'escape' => false), null, array('tag' => 'li','class' => 'disabled','disabledTag' => 'a', 'escape' => false));
        ?>
        <li><?php echo $this->Paginator->last(__('Last', true)); ?></li>
    </ul>
</div>

