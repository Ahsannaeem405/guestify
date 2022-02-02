<h3 class="text-center text-success"><?php echo __('Upgrade to PRO', true); ?></h3>

<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <div class="center text-center">
            <p class="lead">
                <?php echo __('Hey, obviously many people have been rating you a lot over Guestify!', true); ?>
            </p>
            <p><?php echo __('If you like to work with our service and you are interested in moving to the next level and gain more insights of your ratings, then Guestify PRO is the right choice! ', true ); ?> <?php echo __('You will not only get unlimited ratings, you will get all available time periods (day, week, month and year), you will be also able to export your statistics and premium support.', true); ?></p>

            <h4><?php echo __('Here is what you will able to do with Guestify PRO:', true); ?></h4>
            <small>&nbsp;</small>
        </div>

    </div>
</div>
<div class="row">
    <div class="col-xs-8 col-xs-offset-2">
        <div class="row">
            <div class="col-xs-4">
                <p class="lead"> <span class="text-success glyphicon glyphicon-ok-circle"></span> <?php echo __('Unlimited Ratings', true); ?></p>
            </div>
            <div class="col-xs-4">
                <p class="lead"> <span class="text-success glyphicon glyphicon-ok-circle"></span> <?php echo __('Individual Polls', true); ?></p>
            </div>
            <div class="col-xs-4">
                <p class="lead"> <span class="text-success glyphicon glyphicon-ok-circle"></span> <?php echo __('Excel Exports', true); ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-4">
                <p class="lead"> <span class="text-success glyphicon glyphicon-ok-circle"></span> <?php echo __('Weekly, Monthly and Yearly Statistics', true); ?></p>

            </div>
            <div class="col-xs-4">
                <p class="lead"> <span class="text-success glyphicon glyphicon-ok-circle"></span> <?php echo __('Premium Support', true); ?></p>
            </div>
            <div class="col-xs-4">
                <p class="lead"> <span class="text-success glyphicon glyphicon-ok-circle"></span> <?php echo __('Email Notification', true); ?></p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">

            <?php /*<h2 class="text-danger text-center">"<?php echo __('Last week alone, Guestify helped', true); ?> 358 <?php echo __('companies to better understand their guests!', true); ?>"</h2>*/ ?>
            <?php /*<h2 class="text-danger text-center">"<?php echo __('I did not imagine what I was missing all the time!', true); ?>"</h2>*/ ?>
            <h2 class="text-danger text-center"><?php echo __('Improve the guest experience in your restaurant!', true); ?></h2>
            <small>&nbsp;</small>
        </div>
    </div>
    <div class="row">
        <div class="col-xs-8 col-xs-offset-2">
            <?php
                echo $this->Html->link('<span class="glyphicon glyphicon-certificate"></span> '.__('Proceed to Upgrade', true), array('action' => 'upgrade', $poll['Poll']['id']), array('class' => 'btn btn-lg btn-block btn-upgrade', 'escape' => false));
            ?>
        </div>
    </div>
    <p>&nbsp;</p>
</div>
