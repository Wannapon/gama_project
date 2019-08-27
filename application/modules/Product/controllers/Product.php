<?php header('Access-Control-Allow-Origin: *'); ?>
<?php
    class Product extends CI_Controller
    {
        // public $JSON_DATA;
        public function __construct()
        {
            parent::__construct();
            $this->load->model("product_model");
            $this->load->model('../../Check_/models/Check__model');
            $this->output->set_content_type("application/json", 'utf-8');
            // $this->output->set_header("Access-Control-Allow-Origin: *");
            $this->output->set_header("Access-Control-Allow-Methods: GET, POST , OPTIONS");
            $this->output->set_header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");

            $this->load->helper("URL", "DATE", "URI", "FORM");//
            $this->load->library('form_validation');//

        }
        // get all Product
        public function get_all_product()
        {
            echo $this->product_model->get_all_product();
        }
        // insert Product
        public function insert_product()
        {
            // check status for insert
            $creator = json_decode($this->input->post('creator'));
            if($creator==null || $creator==''){
                echo 'fail';
                exit;
            }
            $creatorID  = $this->Check__model->chk_token($creator);
            $statusUser = $this->Check__model->chk_status($creatorID);
            if( $statusUser != 'admin' ){
                echo 'fail';
                exit ;
            }
            // insert
            $product = (array)json_decode($this->input->post('product'));
                $ranSTR = date('dmYHis').substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', mt_rand(1,10))), 1, 10);
                $nameF = substr(strrev($_FILES['userfile']['name']), 0, strrpos(strrev($_FILES['userfile']['name']),"."));
                $typeF = strrev($nameF);
                $_FILES['userfile']['name'] = $ranSTR.'.'.$typeF;
                $config = array(
                    'upload_path'      => './../client/src/assets/Product/',
                    'allowed_types' => '*',
                    'max_size'      => '0',
                );
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('userfile')){
                    $data = array('upload_data' => $this->upload->data());
                    
                    $product['p_image'] = $_FILES['userfile']['name'];
                    $createM ;
                        if(date('m')==1){
                            $createM = 'มกราคม';
                        }else if(date('m')==2){
                            $createM = 'กุมภาพันธ์';
                        }else if(date('m')==3){
                            $createM = 'มีนาคม';
                        }else if(date('m')==4){
                            $createM = 'เมษายน';
                        }else if(date('m')==5){
                            $createM = 'พฤษภาคม';
                        }else if(date('m')==6){
                            $createM = 'มิถุนายน';
                        }else if(date('m')==7){
                            $createM = 'กรกฎาคม';
                        }else if(date('m')==8){
                            $createM = 'สิงหาคม';
                        }else if(date('m')==9){
                            $createM = 'กันยายน';
                        }else if(date('m')==10){
                            $createM = 'ตุลาคม';
                        }else if(date('m')==11){
                            $createM = 'พฤษจิกายน';
                        }else if(date('m')==12){
                            $createM = 'ธันวาคม';                            
                        }
                    $createY = date('Y')+543;
                    $product['p_create_date'] = date('d').' '.$createM.' '.$createY;
                    $thisID = $this->product_model->insert_product($product);
                    $product['p_id']=$thisID;
                    echo json_encode($product);

                }else{
                    $error = array('error' => $this->upload->display_errors());
                    print_r($error);
                }
        }
        // update Product
        public function update_product(){
            // check status for insert
            $creator = json_decode($this->input->post('creator'));
            if($creator==null || $creator==''){
                echo 'fail';
                exit;
            }
            $creatorID  = $this->Check__model->chk_token($creator);
            $statusUser = $this->Check__model->chk_status($creatorID);
            if( $statusUser != 'admin' ){
                echo 'fail';
                exit ;
            }
            //update
            $product = (array)json_decode($this->input->post('product'));
            if($_FILES['userfile']){
                $ranSTR = date('dmYHis').substr(str_shuffle(str_repeat('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', mt_rand(1,10))), 1, 10);
                $nameF = substr(strrev($_FILES['userfile']['name']), 0, strrpos(strrev($_FILES['userfile']['name']),"."));
                $typeF = strrev($nameF);
                $_FILES['userfile']['name'] = $ranSTR.'.'.$typeF;
                $config = array(
                    'upload_path'      => './../client/src/assets/Product/',
                    'allowed_types' => '*',
                    'max_size'      => '0',
                );
                $this->load->library('upload', $config);
                if ($this->upload->do_upload('userfile')){
                    $data = array('upload_data' => $this->upload->data());
                    $product['p_image'] = $_FILES['userfile']['name'];
                }else{
                    $error = array('error' => $this->upload->display_errors());
                    print_r($error);
                    exit;
                }
            }
                $productEditID['p_id'] = $product['p_id'];
                unset($product['p_id']); 
                $product['p_update_date'] = null; 
                $thisUpdate = $this->product_model->update_product($product,$productEditID);
                if($thisUpdate == true){
                    $product['p_id'] = $productEditID['p_id'];
                    echo json_encode($product);
                }
        }










        
    }

?>