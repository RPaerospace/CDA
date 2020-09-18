<?php

//insert_chat.php

session_start();

function fetch_chat_history(){
    

    require('connection.php');
    require('functions/retrieveUsers.php');

    $query = "
    SELECT * FROM chat 
    WHERE (IdMission = ".$_SESSION['mission']['IdMission']." ) 
    ORDER BY time ASC
    ";
    $statement = $base->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    $time = "";
    $oldIdUser = "";
    if(!isset($_GET['hist'])){
        $result = array_slice($result,-50); ?>

        <button class="btn btn-block btn-outline-secondary" id="chat_history">Load previous messages</button>

        <?php
    }
    foreach($result as $message){
?>


    <!--chat Row -->
    <li class="<?php if($message['IdUser']==$_SESSION['user']['IdUser']){ echo "odd ";} ?>chat-item">
        <div class="chat-content">
    <?php if($message['IdUser']!=$oldIdUser && $message['IdUser']!=$_SESSION['user']['IdUser']){ ?>
            <h6 class="font-medium"><?php echo retrieveUsers($message['IdUser'])->fetch()[0]; ?></h6>
    <?php } ?>

            <div class="box bg-light-<?php if($message['IdUser']==$_SESSION['user']['IdUser']){
                echo "inverse ";
            }else{
                echo "info";
            } ?>">
            <?php echo $message['Message']; ?></div>
        </div>
        <?php if($message['time']!=$time){ ?><div class="chat-time"><?php echo $message['time']; ?></div> <?php } ?>
    </li>

<?php 
$time = $message['time'];
$oldIdUser = $message['IdUser'];
}

}

if(isset($_POST['chat_message'])){

require('connection.php');

// require('functions.php');


$data = array(
 ':IdMission'  => $_SESSION["mission"]["IdMission"],
 ':from_user_id'  => $_SESSION['user']['IdUser'],
 ':chat_message'  => $_POST['chat_message'],
 ':status'   => '1'
);

$query = "
INSERT INTO chat 
(IdMission, IdUser, Message, Status) 
VALUES (:IdMission, :from_user_id, :chat_message, :status)
";

$statement = $base->prepare($query);

$statement->execute($data);

}
echo fetch_chat_history();



?>
