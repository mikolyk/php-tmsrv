<?php
/**
 * Created by PhpStorm.
 * User: Aleksandr M
 * Date: 14/03/2018
 * Time: 17:49
 */
define("TMSRV_TOKEN","{YOUR_TOKEN_HERE}");
define("TMSRV_API_URL","https://tmsrv.pw/send/v1");

Class tms {

    public static function send($text, $token=TMSRV_TOKEN) {

        if(empty($text))
            return array('ok'=>false, 'error'=>'message is empty');

        $url = TMSRV_API_URL;
        $post = array(
            'token' => $token,
            'message' => $text,
            'language'=> 'PHP',
        );

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            if ($post) {
                curl_setopt($ch, CURLOPT_POST, 1);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
            }
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $result = curl_exec($ch);

            if ($result === false) {
                $result = array('ok' => false, 'error' => 'curl error ' . curl_error($ch) . ' code ' . curl_errno($ch));
            } else {
                $result = json_encode($result);
            }
            curl_close($ch);

        } catch (Exception $e) {
            return array('ok'=>false, 'error'=>$e->getMessage());
        }
        return $result;
    }
}