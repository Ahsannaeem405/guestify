<div class="row">
    <div class="col-lg-4">
        <div class="well text-center">
            <h3><?php echo __('Overall', true); ?></h3>
            <span class="lead">
                <?php echo $scorecard['count_overall']; ?>
            </span>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="well text-center">
            <h3><?php echo __('Opened emails', true); ?></h3>
            <span class="lead">
                <?php echo $scorecard['count_openend']; ?>
            </span>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="well text-center">
            <h3><?php echo __('Open rate', true); ?></h3>
            <span class="lead">
                <?php echo $scorecard['rate_opened']; ?>%
            </span>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-3">
        <div class="well text-center">
            <h4><?php echo __('Activation link', true); ?></h4>
            <span class="lead"><?php echo $scorecard['count_links_activation_clicked']; ?> / <?php echo $scorecard['rate_link_activation_clicked']; ?>%</span>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="well text-center">
            <h4><?php echo __('Facebook', true); ?></h4>
            <span class="lead"><?php echo $scorecard['count_links_facebook_clicked']; ?> / <?php echo $scorecard['rate_link_facebook_clicked']; ?>%</span>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="well text-center">
            <h4><?php echo __('Twitter', true); ?></h4>
            <span class="lead"><?php echo $scorecard['count_links_twitter_clicked']; ?> / <?php echo $scorecard['rate_link_twitter_clicked']; ?>%</span>
        </div>
    </div>

    <div class="col-lg-3">
        <div class="well text-center">
            <h4><?php echo __('Explore', true); ?></h4>
            <span class="lead"><?php echo $scorecard['count_links_explore_clicked']; ?> / <?php echo $scorecard['rate_link_explore_clicked']; ?>%</span>
        </div>
    </div>
</div> 
