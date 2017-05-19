
<?php
/**
 * Salts and hashes and verify passwords
 * @author Michael Gacek 2/19/16
 */
function encrypt($input,$rounds = 10) {
	$salt = "";
	$salt_chars = array_merge(range('A','Z'),range('a','z'),range(0,9));
	for($i=0;$i < 22;$i++) {
		$salt .= $salt_chars[array_rand($salt_chars)];
	}
	return crypt($input,sprintf('$2y$%02d$',$rounds) . $salt);
}

function verify($password,$password_hash) {
	if(crypt($password,$password_hash)==$password_hash) {
		return true;
	}
	return false;
}

function setPassword($password) {
	$password_hash  = encrypt($password,10);
	return $password_hash;
}

function checkPassword($password,$password_hash) {
	if(verify($password,$password_hash)) {
		return true;
	}
	return false;
}
function getPassword($password,$password_hash) {
	if(verify($password,$password_hash)) {
		return crypt($password,$password_hash);
	}
	return 0;
}
//creates a random password before hashing
//run this password through the setPassword function to hash it.
function createRandomPassword() {
    $password="";
    $randomGenerator=array_merge(range('A','Z'),range('a','z'),range(0,9));
    for($i=0;$i < 8;$i++) {
	$password .= $randomGenerator[array_rand($randomGenerator)];
    }
    
    return $password;
}



