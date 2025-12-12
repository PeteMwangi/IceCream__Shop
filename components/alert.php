<?php
if (isset($success_msg)){
    foreach ($success_msg as $success_msg) {
        echo '<script>swal("'.$success_msg.'", "", "success");</script>';
    }
    }

  
    if (isset($warning_msg)) {
        foreach ($warning_msg as $msg) {
            echo '<script>swal("' . $msg . '", "", "warning");</script>';
        }
    }
  
    

if (isset($info_msg)){
    foreach ($info_msg as $info_msg) {
        echo '<script>swal("'.$info_msg.'", "", "info");</script>';
    }
    }


    if (isset($error_msg)){
        foreach ($error_msg as $error_msg) {
            echo '<script>swal("'.$error_msg.'", "", "error");</script>';
        }
        }

    ?>
    

    <?php if (!empty($success_msg)) {
    foreach ($success_msg as $msg) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '$msg',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        </script>";
    }
}

if (!empty($warning_msg)) {
    foreach ($warning_msg as $msg) {
        echo "<script>
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: '$msg',
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK'
            });
        </script>";
    }
}
?>

<?php if (!empty($success_msg)) {
    foreach ($success_msg as $msg) {
        echo "<script>swal('Success', '{$msg}', 'success');</script>";
    }
} ?>

<?php if (!empty($warning_msg)) {
    foreach ($warning_msg as $msg) {
        echo "<script>swal('Warning', '{$msg}', 'warning');</script>";
    }
} ?>
<?php
if (isset($_SESSION['message'])) {
    foreach ($_SESSION['message'] as $msg) {
        echo '<script>
            swal({
                title: "",
                text: "'.$msg['text'].'",
                icon: "'.$msg['type'].'",
                button: "OK"
            });
        </script>';
    }
    unset($_SESSION['message']);
}
?>
