<div id="modal-standard-delete" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="StandardDelete" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h3><?php echo __('Delete entry?', true); ?></h3>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <p class="modal-body-text">
                        <?php echo __('Are you sure you want to delete this entry?', true); ?>
                    </p>
                </div>
            </div>
            <div class="modal-footer">
                <img src="/img/spinner.gif" class="spinner" id="standard-delete-spinner"/>
                <button class="btn btn-default" id="standard-delete-cancel" data-dismiss="modal" aria-hidden="true"><?php echo __('Cancel', true); ?></button>
                <button class="btn btn-danger" id="standard-delete-confirm" type="button"><?php echo __('Delete', true); ?></button>
            </div>
        </div>
    </div>
</div>


<script>

    $(document).ready(function() {

        $('#standard-delete-spinner').hide();

        var delete_url = '';

        $(document).on('click', 'a.standard-delete', function() {
            delete_url = $(this).attr('href');
            $('#modal-standard-delete').modal();
            return false;
        });

        $('#standard-delete-confirm').click(function() {
           $('#standard-delete-spinner').show();
           document.location = delete_url;
           return false;
        });

    });

</script>
