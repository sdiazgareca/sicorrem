<?php
// valida_rut($r) v0.001
// No importa si el RUT esta con punto (.), comas (,),
// guion (-),k (minuscula | mayuscula) da igual.
// ----------------------------------------------------
// Autor: Juan Pablo Aqueveque <jp [arroba] juque [punto] cl >
// Script completamente gratis, eso si! mándame un email si lo ocupas
// o si encuentras algún problema :-)
//
// Temuco, 31 octubre 2002 11:48:00
function valida_rut($r)
{
	$r=strtoupper(ereg_replace('\.|,|-','',$r));
	$sub_rut=substr($r,0,strlen($r)-1);
	$sub_dv=substr($r,-1);
	$x=2;
	$s=0;
	for ( $i=strlen($sub_rut)-1;$i>=0;$i-- )
	{
		if ( $x >7 )
		{
			$x=2;
		}
		$s += $sub_rut[$i]*$x;
		$x++;
	}
	$dv=11-($s%11);
	if ( $dv==10 )
	{
		$dv='K';
	}
	if ( $dv==11 )
	{
		$dv='0';
	}
	if ( $dv==$sub_dv )
	{
		return true;
	}
	else
	{
		return false;
	}
}

//llamada de la funcion

if ( valida_rut($_GET['rut']) )
{
	echo 'el rut es CORRECTO :-)';
}
else
{
	 echo 'el rut es incorrecto :-(';
}
?>
<form method="get" action="rut2.php">
<input type="text" name="rut" id="rut">
<input type="submit" value="ja">
</form>