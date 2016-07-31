<?php
/**
 * Created by PhpStorm.
 * User: asus1
 * Date: 14.06.2016
 * Time: 19:52
 */
class companies_model extends model
{
    public function getCompany($company_id)
    {
        $stm = $this->pdo->prepare('
            SELECT * FROM companies c LEFT JOIN companies_contacts cc ON c.id = cc.companyID WHERE c.id = :company_id
        ');
        return $this->get_row($stm, array('company_id' => $company_id));
    }

}