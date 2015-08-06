<?php
 require_once("base.class.php");//Todas as classes são criadas derivadas da classe base.class.php. se for criar outra classe tem que incluir o arquivo base.class.php e a classe tera de ser um extends
 class clientes extends base{
	 public function __construct($campos=array()){
	    parent::__construct();
		$this->tabela ="email";//aqui seta os campos na tabela do banco de dados
		if(sizeof($campos)<=0):
		   $this->campos_valores = array(
		      "nome" => NULL,//Aqui se coloca os campos da tabela especificada que por padrão é nulo
			  "email" => NULL,
			  "telefone" => NULL,
			  "mensagem" => NULL,
			  			  
		   );
		   else:
		    $this->campos_valores = $campos;
			endif;
			$this->campopk = "id";
	 }//Aqui é o metodo construct metodo é a ação do obejeto ou seja o que ele vai fazer
 }//fim da classe clientes. Se for adicionar alguma propiedade na classe cliente deve ser adicionada aqui
?>