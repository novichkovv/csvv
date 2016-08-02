<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 02.08.2016
 * Time: 13:29
 */
class results_controller extends controller
{
    public function index()
    {
        $this->view('index' . DS . 'results');
    }

    public function index_ajax()
    {
        switch ($_REQUEST['action']) {
            case "data_table":
                $params = $this->getTableParams();
                echo json_encode($this->getDataTable($params));
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
            'CONCAT("
                <a href=\"' . SITE_DIR . 'html/", url, "\" class=\"btn btn-icon btn-xs\">
                    <i class=\"fa fa-link\"></i>
                </a>")'
        ];
        return $params;
    }
}