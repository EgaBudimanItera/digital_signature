<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Oauth2_client {

    public $client_id       = 'OAUTH_CLIENT_ID';
    public $client_secret   = 'OAUTH_CLIENT_SECREET';
    public $redirect_uri    = 'APP_CLIENT_URL_CALLBACK';
    public $scope    		= 'SCOPE';

    protected $CI;
    public function __construct(){

        $this->CI =& get_instance();
        $this->CI->load->library('Rest','rest');
    }

    public function user_authentication( $provider_auth_uri, $more_args = array(), $return_uri = false ){

        $args['client_id']      = $this->client_id;
        $args['redirect_uri']   = $this->redirect_uri;
        if( ! empty($more_args) )
            foreach($more_args as $key => $val)
                $args[$key] = $val;
        $url = $provider_auth_uri.'?'.http_build_query($args);

        if($return_uri)
            return $url;
        header('Location:'.$url);
        exit;
    }

    public function get_access_token( $provider_token_uri, $code, $http_method = 'GET', $more_args = array() ){

        $args['client_id']      = $this->client_id;
        $args['client_secret']  = $this->client_secret;
        $args['code']           = $code;
        $args['redirect_uri']   = $this->redirect_uri;

        if( ! empty($more_args) )
            foreach($more_args as $key => $val)
                $args[$key] = $val;
        $url = $provider_token_uri.'?'.http_build_query($args);
        return $this->CI->rest->send_request($url, $http_method, $args);
    }

    public function access_user_resources($provider_uri, $acces_token, $http_method = 'GET', $more_args = array() ){

        $args['access_token']  = $acces_token;
        $args['scope']  = $this->scope;

        if( ! empty($more_args) )
            foreach($more_args as $key => $val)
                $args[$key] = $val;

        $url = $provider_uri.'?'.http_build_query($args);
        return $this->CI->rest->send_request($url, $http_method, $args);
    }
}