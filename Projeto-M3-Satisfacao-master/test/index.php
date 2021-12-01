<?php 

require_once ('class/object.class.php');
require_once ('class/user.class.php');

$inicio = '2021-11-02';
$fim = '2021-11-30';
$email = 'ramon.a@gmail.com';
$password = '123456';

$usr = 'ramon.z@gmail.com';
$passwd = '098765';

echo "<pre>";
//var_dump($user->Login($email, $password));
//var_dump($user->register($usr, $passwd));
//var_dump($user->count());
//var_dump($user->dataInicial($email));
var_dump($user->listHumorAdmin($email, $inicio, $fim));
echo "</pre>";




#---------------------------------------------#

/*echo "<pre>";
var_dump($object->Count([$email, $password]));
echo "</pre>";


echo "<pre>";
var_dump($object->dataInicial([$email]));
echo "</pre>";

echo "<pre>";
var_dump($object->Register([$email, $password]));
echo "</pre>";

echo "<pre>";
var_dump($object->Login($email, $password));
echo "</pre>";

echo "<pre>";
var_dump($object->updateHumor($userID = 20, $humor = 1, $comment = 'texto', $day = 25));
echo "</pre>";

echo "<pre>";
var_dump($object->listHumorByUser($Inicio, $Fim, $email));
echo "</pre>";*/
?>