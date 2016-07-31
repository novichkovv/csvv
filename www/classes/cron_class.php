<?php
class cron_class extends base
{
    public function upwork()
    {
        $latest = [];
        foreach ($this->model('upwork')->getAll('id DESC', 20) as $v) {
            $latest[$v['guid']] = $v;
        }
        $res = '';
        $rows = [];
        $text = file_get_contents('https://www.upwork.com/ab/feed/topics/rss?securityToken=f5b4a3e2c9db58a24f985e078b7b90f2b80a98ce4f982d9a371757afcbd2fbb27e6e7a7b2276eb666f63c230509e66f6bb8fb771e86444e62da3decb785cc5e3&userUid=540085637412036608');
        $xml = new SimpleXMLElement($text);
        foreach ($xml->channel->item as $item) {
            if(isset($latest["" . $item->guid])) {
                continue;
            }
            if(preg_match("/Budget<\/b>:\s*.{1}([0-9]+)/", $item->description, $matches)) {
                if($matches[1] >= 300) {
                    $reg_exp = "/(wp|wordpress|drupal|laravel|yii|zend|magento|opencart|woo|woocommerce|codeigniter|joomla|pakistan)/i";
                    if(!preg_match($reg_exp, $item->title)) {
                        if(!preg_match($reg_exp, $item->description)) {
                            $res .= '<h3>' . $item->title . '</h3>' . "\n" . $item->description . "<br>" . '<a href="' . $item->guid . '">' . $item->guid . '</a>' ."<hr>\r\n";
                            $rows['guid'] = $item->guid;
                            $this->model('upwork')->insert($rows);
                        }
                    }
                }
            }
        }
        if($res) {
            $headers= "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n"
                ."From: webmaster@lonty.ru\r\n"
                ."Reply-To: webmaster@lonty.ru\r\n"
                ."X-Mailer: PHP/" . phpversion();
            mail('novichkovv@bk.ru', 'Upwork Feed', $res, $headers);

        }
    }
}