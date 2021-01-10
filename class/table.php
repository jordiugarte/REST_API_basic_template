<?php

require_once "connection/connection.php";
require_once "response.php";

class table extends connection {

    private $table = "nameOfTheTable";
    private $id="";
    private $details="";
    private $info="";

    public function listTables() {
        $query = "SELECT * FROM " . $this->table;
        return parent::getData($query);
    }

    public function getTable($id) {
        $query = "SELECT * FROM " . $this->table . " WHERE id = '$id'";
        return parent::getData($query);
    }

    public function store($json){
        $_response= new response();
        $data = json_decode($json,true);
        if (!isset($data['details'])||!isset($data['info'])){
            return $_response->error_400();
        }else{
            $this->details=$data['details'];
            $this->info=$data['info'];

            $save=$this->saveData();

            if ($save){
                $response=$_response->response;
                $response["result"]=array(
                    "tableId"=>$save
                );
                return $response;
            }else{
                return $_response->error_500();
            }
        }
    }

    public function update($json){
        $_response=new response();
        $data=json_decode($json,true);
        if (!isset($data['id'])){
            return $_response->error_400();
        }else{
            $this->id=$data['id'];
            if (isset($data['details']))$this->details=$data['details'];
            if (isset($data['info']))$this->info=$data['info'];
            $update=$this->updateData();
            if ($update){
                $response=$_response->response;
                $response['result']=array(
                    "tableId"=>$this->id
                );
                return $response;
            }else{
                return $_response->error_500();
            }
        }
    }

    public function delete($json){
        $_response = new response();
        $data=json_decode($json,true);
        if (!isset($data['id'])){
            return $_response->error_400();
        }else{
            $this->id=$data['id'];
            $destroy=$this->deleteData();
            if ($destroy){
                $response=$_response->response;
                $response['result']=array(
                    "tableoId"=>$this->id
                );
                return $response;
            }else{
                return $_response->error_500();
            }
        }
    }

    private function saveData(){
        $query ="INSERT INTO ".$this->table." (details,info)values('".$this->details."','".$this->info."')";
        $save = parent::nonQueryid($query);
        if ($save)return $save;
        else return 0;

    }
    private function updateData(){
        $query="UPDATE ".$this->table." SET details='".$this->details."', info='".$this->info."' WHERE id='".$this->id."'";
        $update=parent::nonQuery($query);
        if ($update>=1)return $update;
        else return 0;
    }
    private function deleteData(){
        $query="DELETE FROM ".$this->table." WHERE id='".$this->id."'";
        $destroy=parent::nonQuery($query);
        if ($destroy >=1)return $destroy;
        else return 0;
    }
}

?>