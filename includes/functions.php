<?php
class Anderson_Makiyama_Functions{
	
	public static function makeData($data, $anoConta,$mesConta,$diaConta){
	   $ano = substr($data,0,4);
	   $mes = substr($data,5,2);
	   $dia = substr($data,8,2);
	   return date('Y-m-d',mktime (0, 0, 0, $mes+($mesConta), $dia+($diaConta), $ano+($anoConta)));	
	}
	
	public static function isSelected($campo, $varCampo){
		if($campo==$varCampo) return " selected=selected ";
		return "";
	}

}
?>