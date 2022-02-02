<!DOCTYPE html>
<html>
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            Guestify - <?php echo $title_for_layout; ?>
        </title>
        <?php
            echo $this->Html->meta('icon');
            echo $this->Html->css('bootstrap/css/bootstrap.min');
            echo $this->Html->css('common');

            echo $this->Html->script('jquery-1.11.1.min');
            echo $this->Html->script('../css/bootstrap/js/bootstrap.min');
            echo $this->Html->script('common');

            echo $this->fetch('meta');
            echo $this->fetch('css');
            echo $this->fetch('script');
        ?>
        <link href='https://fonts.googleapis.com/css?family=Oswald:400,300' rel='stylesheet' type='text/css'>
        <meta name="viewport" content="width=device-width" />
    </head>

    <body class="widget">

        <?php echo $this->Session->flash(); ?>
        <?php echo $this->fetch('content'); ?>


        <div class="container bg-warning">
            <?php echo $this->element('sql_dump'); ?>
        </div>

    </body>
</html>
