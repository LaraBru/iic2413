<?php 

function is_user_register_post_var_defined($data)
{
    $keys = User::getProperties();
    echo '<br>';
    $res = true;
    foreach ($keys as $key) {
        $res = $res && isset($data[$key]) && ($data[$key] != "");
    }
    return $res;
}

function is_user_signin_post_var_defined($data)
{
    return isset($data['password']) && isset($data['username']);
}


?>