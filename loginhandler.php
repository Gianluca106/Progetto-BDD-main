<?php
$servername="localhost";
$username="root";
$password="";
$dbname="progetto";

function effettua_login($connection,$login,$password) {
    $login=mysqli_real_escape_string($connection,$login);
    $password=mysqli_real_escape_string($connection,$password);
    $rs=mysqli_query($connection,"SELECT * FROM userlist WHERE username='$login' AND password='$password'");
    return (array) mysqli_fetch_assoc($rs);
}
function verifica_registrazione($connection,$login) {
    $login=mysqli_real_escape_string($connection,$login);
    $rs=mysqli_query($connection,"SELECT * FROM userlist WHERE username='$login'");
    $array = mysqli_fetch_assoc($rs);
    if($array==array()) //se utente è un array vuoto
        {
            //utente non registrato
            return 0;
        }
        else{
            //utente registrato
            return 1;
        }

}
function login($info){
    $_SESSION['loggedin']=$info;
}
function isLogged(){
    return $_SESSION['loggedin'];
}
function insert_new($connection, $user, $password, $nome, $cognome, $indirizzo, $tipo){
    $user=mysqli_real_escape_string($connection,$user);
    $password=mysqli_real_escape_string($connection,$password);
    $nome=mysqli_real_escape_string($connection,$nome);
    $cognome=mysqli_real_escape_string($connection,$cognome);
    $indirizzo=mysqli_real_escape_string($connection,$indirizzo);
    $rs = mysqli_query($connection, "INSERT INTO userlist VALUES ('$user','$password','$nome','$cognome','$indirizzo');");
    return $rs;
}

session_start();
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

//data from html
$postuser = $_POST['username'];
$postpasswd = $_POST['password'];
$postformtype = $_POST['formtype'];

if($postformtype=='login'){
    //utente sta tentando di accedere
    $user=effettua_login($conn,$_POST['username'],$_POST['password']); //verifica dati in post
    if($user==array()) //se utente è un array vuoto
    {
        //credenziali errate
        header("Location: LoginPage.html"); //torna al form di autenticazione
        exit;
    }
    else {
        login($user); //memorizza in sessione i dati dell'utente
        echo "Benvenuto {$user['nome']} {$user['cognome']}"; //visualizza benvenuto
        header("Location: Cliente_no_ui.php?user=".$postuser);
        
}
}
else{
    if($postformtype == 'register'){
        //utente si vuole registrare
        $postname = $_POST['nome'];
        $postsurname = $_POST['cognome'];
        $postaddress = $_POST['indirizzo'];
        if(verifica_registrazione($conn,$_POST['username'])){   //verifica se gia registrato
            //gia registrato
            header("Location: LoginPage.html");
            exit;
        }
        else{        
            insert_new($conn,$postuser, $postpasswd, $postname, $postsurname, $postaddress, 0);
            header("Location: LoginPage.html");
        }

    }
}
mysqli_close($conn);
?>