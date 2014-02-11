<?php
namespace Home\Model;
use Zend\Db\TableGateway\TableGateway;

class HomeTable
{
    protected $tableGateway;
   
    public function __construct(TableGateway $tableGateway)
    {
       $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {  
       $resultSet = $this->tableGateway->select();
       return $resultSet;
    }

    public function getHome($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(array('id' => $id));
        $row = $rowset->current();
        if(!$row){
          throw new \Exception("Could not find row $id");
        }
        return $row;
    }

   public function saveHome(Home $home)
   {
       $data =  array(
           'id'        => $home->id,
           'name'      => $home->name,
           'price'     => $home->price,
           'quantity'  => $home->quantity
           );
       $id = (int)$home->id;
       if($id==0){
            $this->tableGateway->insert($data);
       } else {
           if($this->getHome($id)){
              $this->tableGateway->update($data,array('id' => $id));
           }else{
               throw new \Exception('Home id does not exist');
               }
       }
    }   
          
   public function deleteHome($id)
   {
       $this->tableGateway->delete(array('id'=>$id));
   }

}
?>
