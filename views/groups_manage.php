<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php init_head(); ?>
<div id="wrapper">
    <div class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="tw-mb-2 sm:tw-mb-4">
                    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#cfg_group_modal">
                        <i class="fa-regular fa-plus tw-mr-1"></i>
                        <?php echo _l('cfg_create_button'); ?>
                    </a>
                </div>

                <div class="panel_s">
                    <div class="panel-body panel-table-full">
                        <?php render_datatable([
                        _l('customer_group_name'),
                        _l('Created By'),
                        _l('options'),
                        ], 'cfg-manage'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('cfg_group'); ?>
<?php init_tail(); ?>
<script>
$(function() {
    initDataTable('.table-cfg-manage', window.location.href);
});
</script>

</body>

</html>