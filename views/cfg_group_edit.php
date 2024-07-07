<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>

<div id="wrapper">
    <div class="content">
    <?php echo form_open('cfg_module/cfg_module/update_fields_group'); ?>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="tw-flex tw-justify-between tw-mb-2">
                    <h4 class="tw-mt-0 tw-font-semibold tw-text-neutral-700">
                        <span class="tw-text-lg"><?php echo $title; ?></span>
                    </h4>
                </div>

                <div class="panel_s">
                    <div class="panel-body">
                        
                        <div class="row">

                            <div class="form-group col-md-12" app-field-wrapper="campaign">
                                <label for="Campaign" class="control-label">Custom Field Group</label><span style="color:red">*</span>
                                <input type="text" id="name" name="name" value="<?php  echo $response != null ? $response->name : '' ?>" require class="form-control">
                                <input type="hidden" id="id" name="id" value="<?php  echo $response != null ? $response->id : '' ?>" require class="form-control">
                            
                            </div>  
  
                        </div>

                        </div>
                        

                        <div class="panel-footer text-right">
                        <button type="submit" class="btn btn-primary">
                            <?php echo _l('submit'); ?>
                        </button>
                    </div>

                    </div>

                </div>
            </div>

        </div>
        <?php echo form_close(); ?>
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
