<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 31.07.2016
 * Time: 16:07
 */
class upload_controller extends controller
{
    public function index()
    {
        if(isset($_FILES['file'])) {
            $file = $_FILES['file'];
            if(array_pop(explode('.', $file['name'])) != 'csv') {
                $this->render('error', 'Wrong File Format');
            } else {
                $rows = [];
                $lines = file($file['tmp_name']);
                if($lines) {
                    $this->model('data_table')->deleteAll();
                    $date = date('Y-m-d H:i:s');
                    foreach ($lines as $k => $line) {
                        $fields = explode(',', $line);
                        if($k < 10) {
                            if(!trim($fields[0])) {
                                continue;
                            }
                            if(trim($fields[0]) == 'QTY') {
                                continue;
                            }
                            if($k == 0) {
                                continue;
                            }
                        }
                        $row = [];
                        $row['qty'] = $fields[0];
                        $row['part_number'] = $fields[1];
                        $row['manufacturer'] = $fields[2];
                        $row['product_line'] = $fields[3];
                        $row['description'] = $fields[4];
                        $row['datasheet'] = $fields[5];
                        $row['create_date'] = $date;
                        $rows[] = $row;
                        if(($k % 10000 == 0 || $k == count($lines) - 1) && $k != 0) {
                            $this->model('data_table')->insertRows($rows);
                            $rows = [];
                        }
                    }
                }
                header('Location: ' . SITE_DIR);
                exit;
            }
        }
        $this->view('page' . DS . 'upload');
    }
}