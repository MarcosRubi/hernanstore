<?php
function showMessage($type, $msg = '')
{
    unset($_SESSION['msg']);
    unset($_SESSION['type']);
    return "toastr." . $type . "('" . $msg . "')";
}
