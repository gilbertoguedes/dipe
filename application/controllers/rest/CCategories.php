<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class CCategories extends REST_Controller
{
    public function categories_deparment_get()
    {
        $this->load->model('Categories');

        $deparment = $this->Categories->department_list();

        $this->response($deparment,201);
    }

    public function categories_all_get()
    {
        $this->load->model('Categories');

        $deparment = $this->Categories->department_list();

        $nivel0 = array();

        for($i=0;$i<count($deparment);$i++)
        {
            $nivel0[$i]['padre'] = $deparment[$i];
            $nivel1 = array();

            $families = $this->Categories->son_of_parent_list($deparment[$i]['category_id']);

            for($j=0;$j<count($families);$j++)
            {

                $nivel1[$j]['padre'] = $families[$j];

                $subfamilies = $this->Categories->son_of_parent_list2($families[$j]['category_id'],$deparment[$i]['category_id']);
                $nivel2 = array();
                for($k=0;$k<count($subfamilies);$k++)
                {
                    $nivel2[$k]['padre'] = $subfamilies[$k];
                }
                $nivel1[$j]['hijos'] = $nivel2;
            }

            $nivel0[$i]['hijos'] = $nivel1;


        }

        $this->response($nivel0,201);
    }


}

?>