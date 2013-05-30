<?php
class EncryptPass{
	private $key = 'path to the key.txt';
	//default is blowfish
	private $hash_method = '$2y$12$';
	//default is sha512
	private $hmac_method = 'sha512';
	
	//change default hash algorithm
	public function hash_method($method){
	$this->hash_method = $method;
	}
	//change default hmac hash algorithm
	public function hmac_method($method){
	$this->hmac_method = $method;
	}
	//change path to the key
	public function keyPath($path){
	$this->key = $path;
	}
	//create hash for storing to db
	public function create_hash($pass){
	$hmac = $this->hmac($pass);
	$salt = substr(strtr($this->create_key(25), '+', '.'), 0, 22);
	return crypt($hmac, $this->hash_method.$salt);
	}
	//compare pass with pass from db
	public function compare_pass($pass, $dbHash){
		$hmac = $this->hmac($pass);
		if (crypt($hmac, $dbHash) === $dbHash) {
			return true;
		} else {
			return false;
		}
	}
	//create random key
	public function create_key($bytes=128){
		if(function_exists('openssl_random_pseudo_bytes')){
			return base64_encode(openssl_random_pseudo_bytes($bytes));
		}else{
			return base64_encode(mcrypt_create_iv($bytes, MCRYPT_DEV_URANDOM));
		}
	}
	//create hmac
	private function hmac($pass){
		return hash_hmac($this->hmac_method, $pass, file_get_contents($this->key));
	}
	
}

$password = 'blah';
$hpass= new EncryptPass();
$hpass->keyPath('somedir/key.txt');
echo $hpass->create_key();
echo '<br />';
$dbpass= $hpass->create_hash($password);
echo $dbpass;
echo '<br />';
echo $hpass->compare_pass($password, $dbpass);
?>