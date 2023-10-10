<?php

require_once ABSPATH . 'vendor/autoload.php';

// Vehicle bg process
class Vehicle_Background_Process extends WP_Background_Process {
    
    protected $action = 'vehicle_background_process';
    private $task_completed  = false;
    private $stop_process  = false;


    public function stop_process(){
        $this->stop_process = true;
        error_log("****** Stop import vehicles process ! *******");
    }
    protected function task($data) {
        global $overlay_settings;
        if(!$this->task_completed)
            $overlay_settings = get_overlay_settings();
            
        if ($this->task_completed || $this->stop_process) {
            error_log("****** End import vehicles process ! *******");
            return false;
        }
        $taskData = gettype($data)=="String" ? unserialize($data) : $data;
        if (!empty($taskData) && $taskData !== null) {
            try {
                foreach ($taskData as $item) {
                    $res = save_vehicle($item);
                    error_log(json_encode($res));
                }
            } catch (Exception $e) {
                error_log("Vehicles : Error occurring when inserting data:=>".$e->getMessage());
            }
        }else{
            return false;
        }
        sleep(2);
        $this->task_completed  = true;
    }
}

// Photo bg process
class Photo_Background_Process extends WP_Background_Process {
    
    protected $action = 'photo_background_process';
    private $task_completed  = false;
    private $stop_process  = false;


    public function stop_process(){
        $this->stop_process = true;
        error_log("****** Stop import photos process ! *******");
    }
    protected function task($data) {
        global $overlay_settings;
        if(!$this->task_completed)
            $overlay_settings = get_overlay_settings();

        if ($this->task_completed || $this->stop_process) {
            error_log("****** End import photos process ! *******");
            return false;
        }
        $taskData = gettype($data)=="String" ? unserialize($data) : $data;
        if (!empty($taskData) && $taskData !== null) {
            try {
                $res = wp_update_post($taskData,true);
                if (is_wp_error($res)) {
                    $error='Error: ' . $res->get_error_message();
                    error_log("Photos : UPDAT POST : ".$error);
                } 
            } catch (Exception $e) {
                error_log("Photos : Error occurring when updating data:=>".$e->getMessage());
            }
        }else{
            return false;
        }
        sleep(2);
        $this->task_completed  = true;
    }
}
