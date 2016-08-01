<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 31.07.2016
 * Time: 16:07
 */
class download_controller extends controller
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
        $this->view('page' . DS . 'download');
    }

    private function getTableParams()
    {
        $params = [];
        $params['table'] = 'data_table';
        $params['select'] = [
            'qty', 'part_number', 'manufacturer', 'product_line', 'description', 'datasheet'
        ];
        return $params;
    }

    private function createReport($params)
    {
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