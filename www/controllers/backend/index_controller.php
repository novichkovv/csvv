<?php
/**
 * Created by PhpStorm.
 * User: enovichkov
 * Date: 28.08.2015
 * Time: 17:20
 */
class index_controller extends controller
{
    public function index()
    {

        if(isset($_POST['download_btn'])) {
            $params = $this->getTableParams();
            if(is_array($_POST['params'])) {
                foreach($_POST['params'] as $k=>$v)
                {
                    $params['where'][$k] = array(
                        'sign' => $v['sign'],
                        'value' => $v['value'],
                    );
                    if($v['sign'] == 'IN') {
                        $params['where'][$k]['noquotes'] = true;
                    }
                }
            }
            $params['limits'] = isset($_REQUEST['iDisplayStart']) ? $_REQUEST['iDisplayStart'].','.$_REQUEST['iDisplayLength'] : '';
            $params['order'] = $_REQUEST['iSortCol_0'] !== 0 ? $params['select'][$_REQUEST['iSortCol_0']] . ($_REQUEST['sSortDir_0'] ? ' ' . $_REQUEST['sSortDir_0'] : $params['order']) : $params['order'];
            $csv = $this->createReport($params);
            header ( "Expires: Mon, 1 Apr 1974 05:00:00 GMT" );
            header ( "Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT" );
            header ( "Cache-Control: no-cache, must-revalidate" );
            header ( "Pragma: no-cache" );
            header ( "Content-Disposition: attachment; filename=Table.csv" );
            echo $csv;
            exit;
        }
        $this->view('index' . DS . 'index');
    }

    public function index_ajax()
    {
        switch ($_REQUEST['action']) {
            case "data_table":
                $params = $this->getTableParams();
                echo json_encode($this->getDataTable($params));
                exit;
                break;

            case "get_edit_form":
                $this->render('record', $this->model('data_table')->getById($_POST['id']));
                $template = $this->fetch('index' . DS . 'ajax' . DS . 'edit_form');
                echo json_encode(array('status' => 1, 'template' => $template));
                exit;
                break;

            case "edit_record":
                $old = $this->model('data_table')->getById($_POST['record']['id']);
                unlink(ROOT_DIR . 'html' . DS . $old['url']);
                $this->render('record', $_POST['record']);
                $template = $this->fetch('page' . DS . 'index');
                $name = md5($_POST['record']['qty'] . $_POST['record']['part_number'] . rand() . time()) . '.html';
                $_POST['record']['url'] = $name;
                $this->model('data_table')->insert($_POST['record']);
                file_put_contents(ROOT_DIR . 'html' . DS . $name, $template);
                echo json_encode(array('status' => 1));
                exit;
                break;

            case "delete_record":
                $old = $this->model('data_table')->getById($_POST['delete_id']);
                unlink(ROOT_DIR . 'html' . DS . $old['url']);
                if($_POST['delete_id']) {
                    $this->model('data_table')->deleteById($_POST['delete_id']);
                }
                echo json_encode(array('status' => 1));
                exit;
                break;
        }
    }

    private function getTableParams()
    {
        $params = [];
        $params['table'] = 'data_table';
        $params['select'] = [
            'qty', 'part_number', 'manufacturer', 'product_line', 'description', 'datasheet',
            'CONCAT("<a data-toggle=\"modal\" href=\"#edit_modal\" class=\"btn btn-icon edit_btn btn-xs\" data-id=\"", id, "\">
                                <i class=\"fa fa-edit\"></i>
                            </a>
                            <a data-toggle=\"modal\" href=\"#delete_modal\" class=\"btn btn-icon delete_btn btn-xs\" data-id=\"", id, "\">
                                <i class=\"fa fa-trash text-danger\"></i>
                            </a>
                            <a href=\"' . SITE_DIR . 'html/", url, "\" class=\"btn btn-icon btn-xs\">
                                <i class=\"fa fa-link\"></i>
                            </a>")'
        ];
        return $params;
    }

    private function createReport($params)
    {
        array_pop($params['select']);
        $res = $this->model('default')->getFromParams($params);
        $csv = '';
        foreach ($res as $row) {
            $arr = [];
            foreach ($row as $v) {
                $arr[] = '"' . $v . '"';
            }
            $csv .= implode(',', $arr) . "\n";
        }
        return $csv;
    }
}