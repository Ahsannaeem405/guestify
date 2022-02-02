<div id="modal-standard-deactivate" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="Deactivate" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><?php echo __('Deactivate entry?', true); ?></h3>
            </div>
            <div class="modal-body">
                <p class="modal-body-text">
                    <?php echo __('Are you sure you want to deactivate this entry?', true); ?>
                </p>
            </div>
            <div class="modal-footer">
                <img src="/img/spinner.gif" class="spinner" id="standard-deactivate-spinner"/>
                <button class="btn btn-default" id="standard-deactivate-cancel" data-dismiss="modal" aria-hidden="true"><?php echo __('Cancel', true); ?></button>
                <button class="btn btn-warning" id="standard-deactivate-confirm" type="button"><?php echo __('Deactivate', true); ?></button>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function() {

        $('#standard-deactivate-spinner').hide();

        var deactivate_url = '';

        $(document).on('click', 'a.standard-deactivate', function() {
            deactivate_url = $(this).attr('href');
            $('#modal-standard-deactivate').modal();
            return false;
        });

        $('#standard-deactivate-confirm').click(function() {
           $('#standard-deactivate-spinner').show();
           document.location = deactivate_url;
           return false;
        });

    });

</script>
