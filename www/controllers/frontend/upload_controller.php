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
            $arr = explode('.', $file['name']);
            $ext = array_pop($arr);
            if($ext != 'csv') {
                $this->render('error', 'Wrong File Format');
            } else {
                $rows = [];
                $lines = file($file['tmp_name']);
                if($lines) {
                    $this->model('data_table')->deleteAll();
                    $dir = ROOT_DIR . 'html' . DS;
                    $f = scandir($dir);
                    foreach ($f as $file){
                        if($file == '.' || $file == '..') {
                            continue;
                        }
                        unlink($dir . $file);
                    }
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
                        $name = md5($row['qty'] . $row['part_number'] . rand() . time()) . '.html';
                        $row['url'] = $name;
                        $this->render('record', $row);
                        $template = $this->fetch('page' . DS . 'index');
                        file_put_contents(ROOT_DIR . 'html' . DS . $name, $template);
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