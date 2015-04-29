<?php 

function is_user_register_post_var_defined($data)
{
    $keys = User::getProperties();
    $res = true;
    foreach ($keys as $key) {
        if (!isset($data[$key]))
        {
            $res = $res && false;
        }
        elseif ($data[$key] == "") {
            $res = $res && false;
        }
    }
    if ($res) {
        $data['password'] = sha1($data['password']);
    }
    return $res;
}

function is_user_signin_post_var_defined($data)
{
    return isset($data['password']) && isset($data['username']);
}


?>