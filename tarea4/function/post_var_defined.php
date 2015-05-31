<?php 

function is_user_signin_var_defined($data)
{
    return isset($data['password']) && isset($data['username']);
}


?>