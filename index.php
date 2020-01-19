<?php
    session_name("Sessoin_Crud");
    session_start();

    //add new session data
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['add'])){
        $_SESSION['bio'][] = [
            'name' => $_POST['name'],
            'roll' => $_POST['roll'],
            'age' => $_POST['age']
        ];
    }//end of add new session data

    //edit session data
    if($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['edit'])){
        $_SESSION['bio'][$_GET['editkey']] = [
            'name' => $_POST['name'],
            'roll' => $_POST['roll'],
            'age' => $_POST['age']
        ];
        header("location: index.php");
    }//end of edit session data


    //session data delete
    if(isset($_GET['key']) && isset($_GET['action']) && $_GET['action'] == "delete"){
        unset($_SESSION['bio'][$_GET['key']]);
        header("location: index.php");
    }//end of session data delete
?>
<!DOCTYPE html>
<html>
    <head>
        <title>PHP-Session CRUD</title>
    </head>
    <body>
        <!--session data view table-->
        <table border="1">
            <thead>
                <tr>
                    <td>Serial</td>
                    <td>Name</td>
                    <td>Roll</td>
                    <td>Age</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
<?php
    if(isset($_SESSION['bio'])){
        krsort($_SESSION['bio']);
        $i = 0;
        foreach($_SESSION['bio'] as $key => $value){ ?>
            <tr>
                <td><?php echo ++$i; ?></td>
                <td><?php echo $value['name']; ?></td>
                <td><?php echo $value['roll']; ?></td>
                <td><?php echo $value['age']; ?></td>
                <td><a href="?editkey=<?php echo $key; ?>&action=edit">Edit</a> | <a onclick="return confirm('Are you to delete?')" href="?key=<?php echo $key; ?>&action=delete">Delete</a></td>
            </tr>
       <?php }
    }
?>
                
            </tbody>
        </table><!--end of session data view table-->


        <br/><br/>



        <!--add new session-->
        <form action="" method="POST">
            <input type="hidden" name="editkey" value="<?php if(isset($_GET['editkey'])){ echo $_GET['editkey']; } ?>">
            <table>
                <tr>
                    <td colspan="2"><?php if(isset($_GET['editkey'])){ echo 'Edit your data'; }else{ echo 'Add new data'; } ?></td>
                </tr>
                <tr>
                    <td>Name</td>
                    <td><input type="text" name="name" placeholder="Your name" value="<?php if(isset($_GET['editkey'])){ echo $_SESSION['bio'][$_GET['editkey']]['name']; } ?>"></td>
                </tr>
                <tr>
                    <td>Roll</td>
                    <td><input type="number" name="roll" placeholder="Your roll" value="<?php if(isset($_GET['editkey'])){ echo $_SESSION['bio'][$_GET['editkey']]['roll']; } ?>"></td>
                </tr>
                <tr>
                    <td>Age</td>
                    <td><input type="number" name="age" placeholder="Your age" value="<?php if(isset($_GET['editkey'])){ echo $_SESSION['bio'][$_GET['editkey']]['age']; } ?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="<?php if(isset($_GET['editkey'])){ echo "edit"; }else{ echo "add"; } ?>" value="<?php if(isset($_GET['editkey'])){ echo "Save"; }else{ echo "Add"; } ?>"></td>
                </tr>
            </table>
        </form><!--end of add new session-->
    </body>
</html>


<?php
    //session_destroy();
?>