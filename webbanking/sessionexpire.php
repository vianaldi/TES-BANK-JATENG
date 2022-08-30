
<?php

        if (time() > $_SESSION['expire']) {
            session_destroy();
        }
        else {
          $_SESSION['expire']=time() + (15*60);
        }
?>
