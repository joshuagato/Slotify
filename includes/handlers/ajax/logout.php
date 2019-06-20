<?php
session_start();
session_destroy();

// without the presence of the session_start method preceding the session_destroy method, there is no way the
// session_destroy will work...since it does not know any session, which should be destroyed
?>