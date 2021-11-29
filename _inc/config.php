<?php

require_once 'classes/DB.class.php';
require_once './connection.php';

/* Databazve poverenie */


define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'movies');

define('DB_SERVER1', '25.35.50.147');
define('DB_USERNAME1', 'velkykomp');
define('DB_PASSWORD1', '123');
define('DB_NAME1', 'movies');


class config{

private $link;
private $link1;
private $aviableconnection=[];
 private $notaviableconnection=[];

/* Pripojenie 
todo urobiť aby sa údaje odosielaly aj na druhú IP

*/


/* Prepojenie User */



/* Kontrola pripojenia */

public function connect(){

    $this->link = connectToDBS( DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME );
    $this->link1 = connectToDBS( DB_SERVER1, DB_USERNAME1, DB_PASSWORD1, DB_NAME1 );

    $connection = [

        'conn'  => $this->link,
        'conn1' => $this->link1
        
    ];

    foreach( $connection as $value ){

        if( $value instanceof mysqli ){  // instancof -> ci premenna v PHP je instanciovany objek urcitej triedy / mysqli -> predstavuje prepojenie medzi PHP a MySQL

            array_push( $this->aviableconnection , $value ); // array_push() -> vlozi jeden alebo viac prvkov na koniec pola 

        } else if( is_string( $value )){ // is_string() -> zisti ci typ premennej je retazec
            
            array_push( $this->notaviableconnection , $value);
            
        }
    }
    //$this->synchronize(); 
}

public function synchronize(){

    $deletedrows = [];
    $updateid  = []; 

    if( file_exists( "notaviablenodes.txt" )){ // file_exists() -> Skontroluje ci subor alebo adresar existuje 

        $myfile = "notaviablenodes.txt"; 
        $lines = File( $myfile , FILE_SKIP_EMPTY_LINES); // nacitanie celeho textoveho suboru do pola $lines / FILE_SKIP_EMPTY_LINES -> preskoci prazdne riadky

        for ( $i=0; $i < sizeof( $lines ); $i++ ){ // sizeof() -> vrati pocet prvkov v poli 
                /* Oddeli ip od sql prikazu */
            $boderOfIP = strpos( $lines[$i] , ":" ); // strpos() -> najde polohu prveho vyskytu podretazca v retazci 
            $ip = substr( $lines[$i] , 0 , $boderOfIP ); //substr() -> vrati cast retazca 
            $sqlcommand = substr( $lines[$i] , $boderOfIP + 1 ); 
    
                /* Pokusy sa pripojit na databazu ktorej ip nasiel v textovom subore */
            $db = connectToDBS( $ip, DB_USERNAME1, DB_PASSWORD1, DB_NAME1 );
                /* Ak je objekt mzsqly pripojenie bolo uspesne  a vykona mysqli prikaz na danaj databaze */
                if( $db instanceof mysqli ){
                
                    $db->query( $sqlcommand );
                    //echo "uzol ".$ip." bol synchronizovany s ostatnymi uzlami".PHP_EOL;
                    // echo'<div class="alert alert-success" role="alert">
                    //         uzol '. $ip .' bol synchronizovany s ostatnymi uzlami !
                    //     </div>';
                    array_push( $deletedrows, $i );
                    array_push($updateid, $ip);
                
                }else{
                
                    //echo "synchronize with".$ip. "was not sucessful".PHP_EOL;

                }
        }
        /* Zmaze vsetky riadky v poli ktore boli vykonane */
        foreach( $deletedrows as $value ){

            unset( $lines[ $value ]); // unset() -> Odstrany zadany parameter
            
        }
        /* Prepise subor */
        file_put_contents( "notaviablenodes.txt", implode( "", $lines )); // file_put_contents() -> zapis udajov do suboru / implode() -> spojenie prvkov pola pomocou retazca 
        $uniqueip = array_unique( $updateid, SORT_STRING ); //array_unique()-> Odstrani duplicitne hodnoty z pola / SORT_STRING -> porovnanie poloziek ako retazec

        return $uniqueip;
    }
}  
function getLink() { 
    return $this->link; 
} 

function setLink($link) {  
   $this->link = $link; 
} 
function getLink1() { 
    return $this->link1; 
} 

function setLink1($link1) {  
   $this->link1 = $link1; 
} 

function getAviableconnection() { 
    return $this->aviableconnection; 
} 

function setAviableconnection($aviableconnection) {  
   $this->aviableconnection = $aviableconnection; 
} 

function getNotaviableconnection() { 
    return $this->notaviableconnection; 
} 

function setNotaviableconnection($notaviableconnection) {  
   $this->notaviableconnection = $notaviableconnection; 
}  

}



	
?>