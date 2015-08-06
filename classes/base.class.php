<?php
  require_once("banco.class.php");//Aqui não altera nenhuma propiedade
  abstract class base extends banco{
      //propiedades
  	  public $tabela = "";
  	  public $campos_valores = array();
  	  public $campopk = NULL;
  	  public $valorpk = NULL;
  	  public $extras_select  = "";

  	  //métodos
      public function addCampo($campo=NULL,$valor=NULL){
          if($campo!=NULL):
             $this->campos_valores[$campo] = $valor;
          endif;
      }//addCampo
      public function delCampo($campo){
      	if(array_key_exists($campo,$this->campos_valores)):
      	   unset($this->campos_valores[$campo]);
      	endif;
      }//delCampo
      public function setValor($campo=NULL,$valor=NULL){//Aqui fica a função que coloca os dados na base de dados
             if($campo!=NULL && $valor!=NULL):
             $this->campos_valores[$campo] = $valor;
             endif;
      }//setValor
      public function getValor($campo=NULL){
             if($campo!=NULL && array_key_exists($campo,$this->campos_valores)):
                     return $this->campos_valores[$campo];
             else:
             	return FALSE;
             endif;
      }//getValor
  }//fim classes base
?>