<?php

include 'config.php';
include 'db.php';
include 'user.php';


$users = User::all();

var_dump($users);

echo '<hr>';

foreach ($users as $k => $v) {
	echo $v->id.' : '.$v->username.' : '$v->password.'<br>';
}

echo '<hr>';


$user = new User();
$user = $user->get(1);

echo $user->username.' : '.$user->password.'<br>';

$user->username = 'new user';
$user->password = 'new pass';

$user->update();

echo $user->username.' : '.$user->password.'<br>';

echo '<hr>';

$user = new User();
$user->delete(2);

echo '<hr>';

# you can point my mistakes.. not a pro in php.. just do things for my own ease.. 
# thanks
# rummykhan

?>