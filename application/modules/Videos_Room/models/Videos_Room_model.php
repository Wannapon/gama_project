<?php

    Class Videos_Room_model extends CI_Model{

        public function __construct()
        {
            parent::__construct();
            $this->output->set_content_type("application/json", 'utf-8');
            $this->videos = 'videos';
            $this->video_room = 'video_room';

        }
        // get all Videos
        public function get_all_videos()
        {
            $videosAll = $this->db->get($this->videos)->result(); 
            return json_encode($videosAll);  
        }
        // get all Video_room
        public function get_all_video_room()
        {               
            // $this->db->order_by('vr_id', 'DESC');
            $videosAll = $this->db->get($this->video_room)->result(); 
            return json_encode($videosAll);  
        }
        // insert Room
        public function insert_room($data = array())
        {
            $lastID;
            $ins = $this->db->insert($this->video_room,$data);
            if($ins){
                $lastID = $this->db->insert_id();
                }
            return json_encode($lastID);
        }
        // insert Videos
        public function insert_videos($data = array())
        {
            $lastID = array();
            for($i=0; $i<sizeof($data); $i++){
            $ins = $this->db->insert($this->videos,$data[$i]);
                if($ins){
                    array_push($lastID,$this->db->insert_id());
                }
            }
            return $lastID;
        }
        // update Room
        public function update_video_room($data = array(), $where = array())
        {
            return json_encode($this->db->where($where)->update($this->video_room,$data));
        }
        






        
    }
?>