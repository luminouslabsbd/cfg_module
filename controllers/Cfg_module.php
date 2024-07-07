<?php
defined('BASEPATH') or exit('No direct script access allowed');

// class Frontend_module extends  ClientsController
class Cfg_module extends  AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Cfg_model');

    }

    public function get_table_data()
    {
        // Initialize DataTables parameters
        $draw = intval($this->input->get('draw'));
        $start = intval($this->input->get('start'));
        $length = intval($this->input->get('length'));
        $search = $this->input->get('search')['value'];
        $order = $this->input->get('order');
        $columns = $this->input->get('columns');

        // Load necessary libraries and helpers
        $this->load->database();

        // Define DataTables columns and initial setup
        $aColumns = [
            'name',
            'CONCAT(firstname, " ", lastname) as created_by',
        ];

        $sIndexColumn = 'id';
        $sTable = db_prefix() . 'cfg_manage';

        $join = ['LEFT JOIN ' . db_prefix() . 'staff ON ' . db_prefix() . 'staff.staffid = ' . db_prefix() . 'cfg_manage.created_by'];

        // Initialize DataTables and get result
        $result = data_tables_init($aColumns, $sIndexColumn, $sTable, $join, [], ['id']);

        $output = $result['output'];
        $rResult = $result['rResult'];

        $output = [
            'draw' => $rResult,
            'recordsTotal' => count($rResult),
            'recordsFiltered' => count($rResult),
            'data' => [],
        ];

        foreach ($rResult as $row) {

            $options = '<div class="row-options">';
            $options .= '<a href="' . admin_url('cfg_module/cfg_module/edit_group/' . $row['id']) . '" data-id="' . $row['id'] . '" data-name="' . $row['name'] . '" data-created-by="' . $row['created_by'] . '" onclick="manage_edit_cfg(' . $row['id'] . '); return false;">' . _l('edit') . '</a>';

            $options .= ' | <a href="' . admin_url('cfg_module/cfg_module/delete_group/' . $row['id']) . '" class="text-danger _delete">' . _l('delete') . '</a>';
            $options .= '</div>';
    
            $output['data'][] = [
                0 => $row['name'],
                1 => $row['created_by'],
                2 => $options,
            ];
        }

        ob_end_clean();
        echo json_encode($output);
        die;

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($output));
    }

    public function ll_home()
    {
        if (!is_admin()) {
            access_denied('Customer Groups');
        }

        if ($this->input->is_ajax_request()) {
            $this->get_table_data();
        }
        
        $data['title'] = _l('customer_groups');
        $this->load->view('groups_manage', $data);

    }

    // tblcfg_manage
    public function custom_fields_group()
    {

        if ($this->input->is_ajax_request()) {

            if ($data['id'] == '') {
                $data = $this->input->post();
                $data['created_by'] = get_staff_user_id() ;
                $data['status'] = 1 ;

                $id      = $this->Cfg_model->add($data);
                $message = $id ? _l('added_successfully', _l('cfg_group')) : '';

                echo json_encode([
                    'success' => $id ? true : false,
                    'message' => $message,
                    'id'      => $id,
                    'name'    => $data['name'],
                ]);
            } 
        }
    }

    public function delete_group($id)
    {
        if (!is_admin()) {
            access_denied('Delete Customer Group');
        }
        if (!$id) {
            redirect(admin_url('clients/groups'));
        }
        $response = $this->Cfg_model->delete($id);
        if ($response == true) {
            set_alert('success', _l('deleted', _l('customer_group')));
        } else {
            set_alert('warning', _l('problem_deleting', _l('customer_group_lowercase')));
        }
        redirect(admin_url('cfg_module/cfg_module/ll_home'));
    }

    public function edit_group($id)
    {
        if (!is_admin()) {
            access_denied('Delete Customer Group');
        }
        if (!$id) {
            redirect(admin_url('clients/groups'));
        }
        $response = $this->Cfg_model->edit($id);

        $data['title'] = _l('customer_groups');
        $data['response'] = $response;

        $this->load->view('cfg_group_edit', $data);

    }

    public function update_fields_group()
    {

        if ($this->input->post()) {

            $data = $this->input->post();

            $data['created_by'] = get_staff_user_id() ;

            $id      = $this->Cfg_model->update_group($data,$data['id']);

            $message = $id ? _l('added_successfully', _l('cfg_group')) : '';

            set_alert('success', _l('Custom Field Group Updated'));

            redirect(admin_url('cfg_module/cfg_module/ll_home'));
            
        }

    }

    


}
