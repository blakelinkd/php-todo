<?php

function encode($object) {
    return(base64_encode(json_encode($object, JSON_FORCE_OBJECT)));
}
function decode($object) {
    return json_decode(base64_decode($object), true);
}

if($_GET['todo_list']) {
    $todo_list = decode($_GET['todo_list']);
}
if($_POST['new_todo']) {
    $id = sizeof($todo_list);
    $new_todo = $_POST['new_todo'];
    $todo_list[$id] = $new_todo;
    $b64object = encode($todo_list);
}
// have to check if null because if the id = 0 it will return true
if($_GET['remove'] != NULL) {
    if(isset($todo_list[$_GET['remove']])) {
        unset($todo_list[$_GET['remove']]);
        $b64object = encode($todo_list);
    }
}


if($_GET['todo_list']) {
    $todo_list_object = json_encode($todo_list, JSON_FORCE_OBJECT);
    $b64object = base64_encode($todo_list_object);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php 
foreach($todo_list as $key => $value) {
    ?>
    <p>
        <a href="/php/todo.php?id=<?php echo($id); ?>&todo_list=<?php echo($b64object . "&remove=" . $key); ?>"><?php echo $value; ?></a>
    </p>
<?php
}
?>
<a href="/php/todo.php">Restart</a>
<form method="POST" 
    action="/php/todo.php?todo_list=<?php echo $b64object; ?>">
    <label for="new_todo">New Todo</label>
    <input name="new_todo" id="new_todo" type="text">
    <button type="submit">Submit</button>
</form>

<script src="app.js"></script>

</body>
</html>
