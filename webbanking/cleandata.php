
<?php
function cleanData($con,$data)
    {
        $data=mysqli_real_escape_string($con,$data);
        $data=trim($data);
        $data=stripcslashes($data);
        $data=htmlspecialchars($data);
        $data=strip_tags($data);
        return $data;
    }
    ?>
