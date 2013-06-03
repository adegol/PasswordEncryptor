-------------------------------------------------------------------------
|	PasswordEncryptor class is written by Petar Fedorovsky 27.05.2013	|
|	Please retain this credit when displaying this code online.			|
-------------------------------------------------------------------------

PasswordEncryptor v1.0

Default settings:
-uses hash_hmac with sha512 algorithm and a random key that you need to generate
-uses crypt with blowfish $2y$12$ algorithm


Methods:
create_hash($password)								//used for creating a hash			- returns hash string
compare_pass($password, $dbpass)					//used for comparison of passwords	- returns boolean
hash_method('hash algorithm')						//used for changing crypt algorithm
hmac_method('hmac hash algorithm')					//used for changing hash_hmac algorithm
keyPath('path to the file with random key')			//used for setting a path to the file with a random key
create_key(number)									//used for creating a random key - default number si 128


How to hash passwords?

//include the class file
include('EncryptPass.php');

//initialize the class
$hpass= new EncryptPass();

//hash the password for storing to the database
$dbpass = $hpass->create_hash($password);

// $dbpass is the variable containing the hash of the password andd this should go to the database

How to check if the password is valid?

/*
$password is the pass gatherd from the user
$dbpass os the hash of the password from the database
*/
if($hpass->compare_pass($password, $dbpass)){
	//it validates and your code should go here

}else{
	//it doesn't validate

}


