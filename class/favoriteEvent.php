<?php

require_once "connection/connection.php";
require_once "response.php";

class favoriteEvent extends connection {

    private $table = "favorite_events";
    private $id = "";
    private $uid = "";
    private $eid = "";
    private $isFavorite;

    public function listFavorites($Uid) {
        $query = "SELECT * FROM " . $this->table . " WHERE uid = '$Uid'";
        return parent::getData($query);
    }

    public function create($json) {
        $_response = new response();
        $data = json_decode($json,true);
        if (!isset($data['uid']) || !isset($data['eid'])){
            return $_response->error_400();
        }else{
            $this->uid = $data['uid'];
            $this->eid = $data['eid'];
            $aux = $this->getFavoriteEvent();
            if ($aux) {
                return $_response->error_400();
            } else {
                $save = $this->saveData();
                if ($save){
                    $response = $_response->response;
                    $response["result"] = array(
                        "favoriteEventId" => $save
                    );
                    return $response;
                } else {
                    return $_response->error_500();
                }
            }
            
        }
    }

    public function getFavoriteEvent() {
        $query = "SELECT * FROM " . $this->table . " WHERE uid = '$this->uid' AND eid = '$this->eid'";
        return parent::getData($query);
    }

    private function saveData() {
        $query = "INSERT INTO " . $this->table . " (uid, eid, is_favorite) VALUES ('" . $this->uid . "','" . $this->eid."', 1)";
        $save = parent::nonQuery($query);
        if ($save >= 1) {
            return $save;
        } else {
            return 0;
        }
    }

    public function update($json){
        $_response = new response();
        $data = json_decode($json,true);
        if (!isset($data['id'])){
            return $_response->error_400();
        }else{
            $this->id = $data['id'];
            if (isset($data['is_favorite'])) $this->isFavorite = $data['is_favorite'];
            $update=$this->updateData();
            if ($update){
                $response=$_response->response;
                $response['result']=array(
                    "favoriteEventId" => $this->id
                );
                return $response;
            }else{
                return $_response->error_500();
            }
        }
    }

    private function updateData(){
        $query = "UPDATE " . $this->table . " SET is_favorite = '" . $this->isFavorite . "' WHERE id = '". $this->id . "'";
        $update = parent::nonQuery($query);
        if ($update >= 1) {
            return $update;
        } else {
            return 0;
        }
    }

    /*
    public function delete($json){
        $_response = new response();
        $data = json_decode($json,true);
        if (!isset($data['id'])){
            return $_response->error_400();
        } else {
            $this->id = $data['id'];
            $destroy = $this->deleteData();
            if ($destroy){
                $response = $_response->response;
                $response['result'] = array(
                    "favoriteEventId" => $this->id
                );
                return $response;
            }else{
                return $_response->error_500();
            }
        }
    }

    private function deleteData(){
        $query = "DELETE FROM " . $this->table . " WHERE id = '" . $this->id . "'";
        $destroy = parent::nonQuery($query);
        if ($destroy >= 1) {
            return $destroy;
        } else {
            return 0;
        }
    }
    */

}

?>