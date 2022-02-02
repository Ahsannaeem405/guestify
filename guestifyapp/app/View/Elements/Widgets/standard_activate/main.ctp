<div id="modal-standard-activate" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Activate" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><?php echo __('Activate entry?', true); ?></h3>
            </div>
            <div class="modal-body">
                <p class="modal-body-text">
                    <?php echo __('Are you sure you want to activate this entry?', true); ?>
                </p>
            </div>
            <div class="modal-footer">
                <img src="/img/spinner.gif" class="spinner" id="standard-activate-spinner"/>
                <button class="btn btn-default" id="standard-activate-cancel" data-dismiss="modal" aria-hidden="true"><?php echo __('Cancel', true); ?></button>
                <button class="btn btn-success" id="standard-activate-confirm" type="button"><?php echo __('Activate', true); ?></button>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function() {

        $('#standard-activate-spinner').hide();

        var activate_url = '';

        $(document).on('click', 'a.standard-activate', function() {
            activate_url = $(this).attr('href');
            $('#modal-standard-activate').modal();
            return false;
        });


        $('#standard-activate-confirm').click(function() {
           $('#standard-activate-spinner').show();
           document.location = activate_url;
           return false;
        });


    });

</script>
