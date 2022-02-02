<div class="clearfix">
    <strong><?php echo $this->Html->link(trim($recipient['User']['gender_label'] . ' ' . $recipient['User']['firstname'].' '.$recipient['User']['lastname']), array('controller' => 'users', 'action' => 'adminView', $recipient['User']['id'])); ?></strong> <br />
    ID: <?php echo $recipient['User']['id']; ?> | <?php echo $recipient['Account']['company_name']; ?> | <?php echo $recipient['User']['email']; ?>
</div>
