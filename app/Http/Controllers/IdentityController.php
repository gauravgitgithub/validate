<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;

class IdentityController extends Controller
{

    //Block size for encryption block cipher
    /**
     * @var integer
     */
    private $ENCRYPT_BLOCK_SIZE = 200; // this for 2048 bit key for example, leaving some room

    //Block size for decryption block cipher
    private $DECRYPT_BLOCK_SIZE = 256; // this again for 2048 bit key


    protected function getKeysPath()
    {
        return config('validate.keys');
    }

    protected function getAlgorithmConfigs()
    {
        return !empty(config('validate.configs')) ? config('validate.configs') : array();
    }

    protected function getPublicKeyName()
    {
        return config('validate.val-public');
    }

    protected function getPrivateKeyName()
    {
        return config('validate.val-secret');
    }

    protected function getPrivateKeyPassphrase()
    {
        return config('validate.passphrase');
    }

    protected function getCertification()
    {
        return config('validate.info');
    }

    protected function getCertificationDuration()
    {
        return config('validate.validity');
    }

    public function index()
    {
        if(file_exists($this->getKeysPath() . $this->getPrivateKeyName() . ".key") && file_exists($this->getKeysPath() . $this->getPublicKeyName() . ".crt")){
            echo '--------------------------------.'. PHP_EOL;
            echo "Keys has already been generated !". PHP_EOL;
            echo '--------------------------------.'. PHP_EOL;
        }else{
            $this->create();
        }
    }

    protected function create()
    {
        try{
            $privkey = openssl_pkey_new($this->getAlgorithmConfigs());
            $csr = openssl_csr_new($this->getCertification(), $privkey);
            $sscert = openssl_csr_sign($csr, null, $privkey, $this->getCertificationDuration());
            openssl_x509_export($sscert, $publickey);
            openssl_pkey_export($privkey, $privatekey, $this->getPrivateKeyPassphrase());
            openssl_csr_export($csr, $csrStr);
            $fp = fopen($this->getKeysPath() . $this->getPrivateKeyName() . ".key", "w");
            fwrite($fp, $privatekey);
            fclose($fp);
            $fp = fopen($this->getKeysPath() . $this->getPublicKeyName() . ".crt", "w");
            fwrite($fp, $publickey);
            fclose($fp);
            echo '---------------------------------'. PHP_EOL;
            echo '---------------Done--------------'. PHP_EOL;
            echo '---------------------------------'. PHP_EOL;

        }catch(Exception $ex){
            echo $ex->getMessage(). PHP_EOL;
        }
    }
}
