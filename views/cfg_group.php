<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="cfg_group_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button group="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <span class="edit-title"><?php echo _l('cfg_group_edit_heading'); ?></span>
                    <span class="add-title"><?php echo _l('cfg_group_add_heading'); ?></span>
                </h4>
            </div>
            <?php echo form_open('cfg_module/cfg_module/custom_fields_group', ['id' => 'customer-group-modal']); ?>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php echo render_input('name', 'customer_group_name'); ?>
                        <?php echo form_hidden('id'); ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button group="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                <button group="submit" class="btn btn-primary"><?php echo _l('submit'); ?></button>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
    
</div>

<script>
    window.addEventListener('load',function(){
       appValidateForm($('#customer-group-modal'), {
        name: 'required'
    }, manage_cfg_manage);

       $('#cfg_group_modal').on('show.bs.modal', function(e) {
        var invoker = $(e.relatedTarget);
        var group_id = $(invoker).data('id');
      
        $('#cfg_group_modal .add-title').removeClass('hide');
        $('#cfg_group_modal .edit-title').addClass('hide');
        $('#cfg_group_modal input[name="id"]').val('');
        $('#cfg_group_modal input[name="name"]').val('');
        // is from the edit button
        if (typeof(group_id) !== 'undefined') {
            $('#cfg_group_modal input[name="id"]').val(group_id);
            $('#cfg_group_modal .add-title').addClass('hide');
            $('#cfg_group_modal .edit-title').removeClass('hide');
            $('#cfg_group_modal input[name="name"]').val($(invoker).parents('tr').find('td').eq(0).text());
        }
    });
   });

   function manage_cfg_manage(form) {
    var data = $(form).serialize();
    var url = form.action;
    $.post(url, data).done(function(response) {
        response = JSON.parse(response);

        if (response.success == true) {
            if($.fn.DataTable.isDataTable('.table-cfg-manage')){
                $('.table-cfg-manage').DataTable().ajax.reload();
            }
            if($('body').hasClass('dynamic-create-groups') && typeof(response.id) != 'undefined') {
                var groups = $('select[name="groups_in[]"]');
                groups.prepend('<option value="'+response.id+'">'+response.name+'</option>');
                groups.selectpicker('refresh');
            }
            alert_float('success', response.message);
        }
        $('#cfg_group_modal').modal('hide');
    });
    return false;
}

</script>
