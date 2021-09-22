<?php

require_once("model/Storage.php");
require_once("model/Ghibli.php");
require_once("model/GhilbiBuilder.php");

class GhilbiStorageMysql implements Storage{
  private $bd;

  public function __construct($bd){
    $this->bd = $bd;
  }

  //lecture d'une ligne de la table ProduitGhibli
  public function read($id){
    $rq = 'SELECT * FROM ProduitGhibli WHERE id= :id' ;
    $stmt = $this->bd->prepare($rq);
    $data  = array(":id" => $id);
    $stmt->execute($data);
    $res =  $stmt->fetch();
    $data = array("nomProd"=>$res['nom'],"typeProd"=>$res['type'],"image"=>$res['lien_image'],"date"=>$res['creation_date'],"id_crea"=>$res['id_utilisateur'],"id_objet"=>$id);
    $ghilbiB = new GhilbiBuilder($data);
    $ghilbi = $ghilbiB->createGhibli();
    return $ghilbi;

  }

  //lecture de l'ensemble des lignes de la table ProduitGhibli de la table ProduitGhibli
  function readAll(){
    $rq = 'SELECT * FROM ProduitGhibli';
    $stmt = $this->bd->prepare($rq);
    $stmt->execute();
    $tab =  $stmt->fetchall();
    $res = array();
    $cpt = 1;

    foreach($tab as $key=>$value){
      $data = array("nomProd"=>$value['nom'],"typeProd"=>$value['type'],"image"=>$value['lien_image'],"date"=>$value['creation_date'],"id_crea"=>$value['id_utilisateur'],"id_objet"=>$value['id']);
      $ghibliB = new GhilbiBuilder($data);
      $ghibli = $ghibliB->createGhibli();
      $res[$cpt]= $ghibli;
      $cpt+=1;
    }
    return $res;
  }

  //création d'un objet dans la table Produit Ghibli
  function create(Ghibli $object){
    $tab = self::readAll();
    $next = 0;
    foreach ($tab as $key => $value) {
      if($key != $value->__getIdObjet()){
        $next = $key;
        break;
      }
    }
    if(!$next){
      $next = count($tab) + 1;
    }
    $rq = 'INSERT INTO ProduitGhibli(id, id_utilisateur, nom, lien_image, type, creation_date) VALUES (:id,:id_util,:nom,:image,:type,:dateCrea)';
    $stmt = $this->bd->prepare($rq);
    $data  = array(":id" => $next,":id_util"=>$object->__getIdCreateur(),":nom" =>$object->__getNomProduit(), ":image" => $object->__getURLImage(), ":type" =>$object->__getTypeProduit(),":dateCrea" =>$object->__getDateCreation());
    $stmt->execute($data);
    return $object;
  }

  //modification d'un objet dans la table Produit Ghibli
  function modif(Ghibli $object){
    $rq = 'UPDATE ProduitGhibli SET nom=:nom, lien_image=:image, type=:type, creation_date=:dateCrea WHERE id=:id';
    $stmt = $this->bd->prepare($rq);
    $data  = array(":id"=>$object->__getIdObjet(),":nom" =>$object->__getNomProduit(), ":image" => $object->__getURLImage(), ":type" =>$object->__getTypeProduit(),":dateCrea" =>$object->__getDateCreation());
    $stmt->execute($data);
    return $object;
  }

  //supression d'un objet dans la table Produit Ghibli
  function delete($id){
    $rq = 'DELETE FROM ProduitGhibli WHERE id=:id;';
    $stmt = $this->bd->prepare($rq);
    $data  = array(":id"=>$id);
    $stmt->execute($data);
  }
}

 ?>
