<?php
abstract class banco{
	//Popiedades do banco
    public $servidor        = "localhost";
    public $usuario         = "root";
    public $senha           = "";
    public $nomebanco       = "sistemahx";
    public $conexao         = NULL;
    public $dataset         = NULL;
    public $linhasafetadas  = -1;


//Métodos 
public function __construct(){
    $this->conecta();
  
 }//Metodo construtor
public function __destruct(){
    if($this->conexao != NULL):
       mysql_close($this->conexao) ;  
     endif;
}//Metodo destrutor,

public function conecta(){//Aqui fica a conexao com o banco de dados
      $this->conexao = mysql_connect($this->servidor,$this->usuario,$this->senha,TRUE)
       or die($this->trataerro(__FILE__,__FUNCTION__,mysql_errno(),mysql_error(),TRUE));
      mysql_select_db($this->nomebanco) or die($this->trataerro(__FILE__,__FUNCTION__,mysql_errno(),mysql_error(),TRUE));
      mysql_query("SET NAMES 'utf8'");
      mysql_query("SET character_set_connection=utf8");
      mysql_query("SET character_set_cliente=utf8");
      mysql_query("SET character_set_results=utf8");//Aqui fica o metodo para setar caracteres utf8 no banco
      
}//conecta

public function inserir($objeto){//Aqui fica a classe responsavel por inserir dados no banco de dados
	
	$sql = "INSERT INTO ".$objeto->tabela." (";
	for($i=0; $i<count($objeto->campos_valores); $i++):
        $sql .= key($objeto->campos_valores);
        if($i< (count($objeto->campos_valores)-1)):
           $sql.=", ";
        else:
            $sql.=") ";
        endif;	
        next($objeto->campos_valores);
	endfor;	
    reset($objeto->campos_valores);
    $sql .="VALUES (";
    for($i=0; $i<count($objeto->campos_valores); $i++):
        $sql .= is_numeric($objeto->campos_valores[key($objeto->campos_valores)]) ? 
              $objeto->campos_valores[key($objeto->campos_valores)]:
              "'".$objeto->campos_valores[key($objeto->campos_valores)]."'";

        if($i < (count($objeto->campos_valores)-1)):
           $sql .=", ";
        else:
            $sql.=") ";
        endif;	
        next($objeto->campos_valores);
	endfor;	
        return 	$this->execultaSQL($sql);	
}//fim da função Inserir
public function atualizar($objeto){//função de update no banco
   
	$sql = "UPDATE ".$objeto->tabela." SET ";
	for($i=0; $i<count($objeto->campos_valores); $i++):
        $sql .= key($objeto->campos_valores)."=";
     $sql .= is_numeric($objeto->campos_valores[key($objeto->campos_valores)]) ? 
              $objeto->campos_valores[key($objeto->campos_valores)]:
              "'".$objeto->campos_valores[key($objeto->campos_valores)]."'";
        if($i< (count($objeto->campos_valores)-1)):
           $sql.=", ";
        else:
            $sql.=" ";
        endif;	
        next($objeto->campos_valores);
	endfor;
	$sql.= "WHERE ".$objeto->campopk."=";
	$sql.= is_numeric($objeto->valorpk) ? $objeto->valorpk : "'".$objeto->valorpk."'";
     
   
        return 	$this->execultaSQL($sql);
}//Atualizar
public function deletar($objeto){//Função de deletar no banco
      	$sql = "DELETE FROM ".$objeto->tabela;
		$sql.= " WHERE ".$objeto->campopk."=";
	    $sql.= is_numeric($objeto->valorpk) ? $objeto->valorpk : "'".$objeto->valorpk."'";
        return 	$this->execultaSQL($sql);
}//deletar
public function selecionaTudo($objeto){
       $sql = "SELECT * FROM ".$objeto->tabela;
       if($objeto->extras_select!=NULL):
       	    $sql .= " ".$objeto->extras_select;
       endif;
       return $this->execultaSQL($sql);
}//Seleciona tudo
public function selecionaCampos($objeto){
       $sql = "SELECT ";
       
       for($i=0; $i<count($objeto->campos_valores); $i++):
        $sql .= key($objeto->campos_valores);
        if($i< (count($objeto->campos_valores)-1)):
           $sql.=", ";
        else:
            $sql.=" ";
        endif;	
        next($objeto->campos_valores);
	endfor;	

       $sql .= " FROM ".$objeto->tabela;
       if($objeto->extras_select!=NULL):
       	    $sql .= " ".$objeto->extras_select;
       endif;
       return $this->execultaSQL($sql);
}//Seleciona tudo
public function execultaSQL($sql=NULL){
      if($sql!=NULL):
         $query = mysql_query($sql) or $this->trataerro(__FILE__,__FUNCTION__);
         $this->linhasafetadas = mysql_affected_rows($this->conexao);
         if(substr(trim(strtolower($sql)),0,6)=='select'):
             $this->dataset = $query;
             return $query;
         else:
            return $this->linhasafetadas;
         endif;
      else:
         $this->trataerro(__FILE__,__FUNCTION__,NULL,'Comando Sql não informado na rotina',FALSE);
      endif;
}//ExecultaSQL
public function retornaDados($tipo=NULL){
      switch (strtolower($tipo)):
           case "array":
               return mysql_fetch_array($this->dataset);
               break;
            case  "assoc":
                return mysql_fetch_assoc($this->dataset);
            break; 
           case "object":   
               return mysql_fetch_object($this->dataset);
             break;
           default:
               return mysql_fetch_object($this->dataset);
             break;
      endswitch;
}//retornaDados
public function  trataerro($arquivo=NULL,$rotina=NULL,$numerro=NULL,$msgerro=NULL,$geraexcept=FALSE){
     if($arquivo==NULL) $arquivo="nao informado";
     if($rotina==NULL) $rotina="nao informada";
     if($numerro==NULL) $numerro=mysql_errno($this->conexao);
     if($msgerro==NULL)  $mserro=mysql_error($this->conexao);
     $resultado = 'Ocorreu um erro com os seguintes detalhes:<br/>
       	           <strong>Arquivo:</<strong> '.$arquivo.'<br/>
                   <strong>Rotina:</<strong> '.$rotina.'<br/>
                   <strong>Codigo:</<strong> '.$numerro.'<br/>
                   <strong>Menssagem:</<strong> '.$msgerro;

if($geraexcept==FALSE):  
     echo ($resultado); 
else: 
    die($resultado) ;
endif;                       
}//Rotina de tratamento de erro 

}//Fim da classe banco


?>