<?php
//Based on #http://stackoverflow.com/questions/5647461/how-do-i-send-a-post-request-with-php
require("lib/gump.class.php");
require("secret.php");

function webRequest($url, $post_data){
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($post_data),
        ),
    );
    $context  = stream_context_create($options);

    //var_dump($post_data);
    //var_dump($url);

    $result = @file_get_contents($url, false, $context);
    if($result === false){
        $error = error_get_last();
        echo "<h1>Cannot connect to server</h1>";
        echo "<code>".$error["message"]."</code>";
    }
    $result = json_decode($result);
    return $result;
}

function sanitizeAction($action) {
    $action_array = explode(";",$action);
    
    if(count($action_array) != 4) {
        echo "<code>Invalid Action</code>";
        return false;
    }
    else
    {
        $gump = new GUMP();
        $gump->sanitize($action_array);
        //var_dump($action_array);

        $gump->validation_rules(array(
            0 => 'required|alpha_dash|max_len,42',
            1 => 'required|integer|min_numeric,0|max_numeric,1000',
            2 => 'required|alpha_dash|max_len,42',
            3 => 'required|integer|min_numeric,0|max_numeric,1'
            ));
      
        $gump->filter_rules(array(
            0 => 'trim|sanitize_string|rmpunctuation',
            1 => 'sanitize_numbers',
            2 => 'trim|sanitize_string|rmpunctuation',
            3 => 'sanitize_numbers'
            ));

        $validated_data = $gump->run($action_array);
        if($validated_data == false){
            echo '<h1>ERROR</h1><code>ERROR : '.$gump->get_readable_errors(true).'</code><br>';
            return false;
        }
        else
        {
            $action = implode(";", $validated_data);
            //var_dump($action);
            return $action;
        }
    }
}

function action($action_string) {
    $url = "https://".HOST_ADDRESS.":".PORT."/api/v1/action/".$action_string;
    $post["token"] = TOKEN;
    $result = webRequest($url,$post);
    return $result;
}

?>