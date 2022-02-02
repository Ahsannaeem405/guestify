<?php
    if(isset($latest_invoice) && !empty($latest_invoice)) { 
        $type = __('Extension period', true);
    } else {
        $type = __('Upgrade period', true);
    }
?>

<div class="clearfix text-center">
    <strong><?php echo $type; ?></strong>
    <p class="lead">
        <strong><?php echo $this->Time->format($formats['date'], $valid_from); ?> - <?php echo $this->Time->format($formats['date'], $valid_until); ?></strong>
    </p>
</div>