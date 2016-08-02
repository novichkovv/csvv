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
            if(array_pop(explode('.', $_FILES['file']['name'])) != 'xls') {
                $this->render('error', 'Wrong file format');
            } else {
                if ($xsl = tools_class::readXLS($_FILES['file']['tmp_name'])) {
                    $this->model('data_table')->deleteAll();
                    $dir = ROOT_DIR . 'html' . DS;
                    if(!file_exists($dir)) {
                        mkdir($dir);
                    }
                    $f = scandir($dir);
                    foreach ($f as $file){
                        if($file == '.' || $file == '..') {
                            continue;
                        }
                        unlink($dir . $file);
                    }
                    $date = date('Y-m-d H:i:s');
                    $rowIterator = $xsl->getRowIterator();
                    $highestDataRow = $xsl->getHighestDataRow();
                    foreach ($rowIterator as $row_number => $row) {
                        $cellIterator = $row->getCellIterator();
                        $fields = [];
                        foreach ($cellIterator as $cell_number => $cell) {
                            if($cell_number == 6 && $cell->hasHyperlink()) {
                                $url = $cell->getHyperlink()->getUrl();
                                if($pos = strpos($url, '.pdf')) {
                                    $url = substr($url, 0, $pos) . '.pdf';
                                }
                                $fields[$cell_number] = '<a href="' . $url . '">' . $cell->getValue() . '</a>';
                            } else {
                                $fields[$cell_number] = $cell->getValue();
                            }
                        }
                        if($row_number < 5) {
                            if($fields[0] == '' || $fields[0] == 'QTY') {
                                continue;
                            }
                        }
                        $row = [];
                        $row['qty'] = $fields[0];
                        $row['part_number'] = $fields[1];
                        $row['manufacturer'] = $fields[2];
                        $row['product_line'] = $fields[4];
                        $row['description'] = $fields[5];
                        $row['datasheet'] = $fields[6];
                        $row['create_date'] = $date;
                        $name = urlencode($row['part_number']) . '.html';
                        $row['url'] = $name;
                        $this->render('record', $row);
                        $template = $this->fetch('page' . DS . 'index');
                        file_put_contents(ROOT_DIR . 'html' . DS . $name, $template);
                        $rows[] = $row;
                        if(($row_number % 10000 == 0 || $row_number == $highestDataRow) && $row_number != 0) {
                            $this->model('data_table')->insertRows($rows);
                            $rows = [];
                        }
                    }
                    header('Location: ' . SITE_DIR . 'backend/');
                    exit;
                }
            }
        }
        $this->view('page' . DS . 'upload');
    }
}