<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

 function login_ldap($username, $password, $domain) {
       $ci =& get_instance();
       $ci->load->library('session');
       $ci->load->config('LDAP_config');
        if (!function_exists('ldap_connect')) {
            error_message('LDAP is not avalible. Please install LDAP module or check php.ini file!'); //error handling with helper. You may use echo instead of this!
            return FALSE;
        }
        $domain=str_replace('@', '', $domain);
        $hosts = $ci->config->item('hosts')[$domain];
        $ports = $ci->config->item('ports')[$domain];
        $basedn = $ci->config->item('basedn')[$domain];
        $login_attribute  = $ci->config->item('login_attribute')[$domain]; 
        $proxy_user = $ci->config->item('proxy_user')[$domain];
        $proxy_pass = $ci->config->item('proxy_pass')[$domain]; 
        $tckn_attribute=$ci->config->item('id_attribute')[$domain]; 
        $dn_attribute=$ci->config->item('dn_attribute')[$domain]; 
        $givenName_attribute=$ci->config->item('givenName_attribute')[$domain]; 
        $sn_attribute=$ci->config->item('sn_attribute')[$domain];

        $connect_status=0;
        foreach($hosts as $host) {
            $ldapconn = ldap_connect($host);
            if($ldapconn) {
                $connect_status=1;
               break;
            }else {
               $connect_status=0;
            }
        }

        if ($connect_status==0) {
            mesaj_hata_login("LDAP server has gone away!");
            return FALSE;
        }

        ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0);
        ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, 3);
    
        try {

        if ($proxy_user=="") {
        $bind = @ldap_bind($ldapconn, $username, $password);
        }
        else $bind = @ldap_bind($ldapconn, $proxy_user, $proxy_pass);

            if (!$bind) {
                mesaj_hata_login("Wrong username or password!");
                return FALSE;
            }
        } catch (Exception $e) {
             mesaj_hata_login("Wrong username or password!");
            return FALSE;
        }

        $filter = '('.$login_attribute.'='.$username.')';

        $search = ldap_search($ldapconn, $basedn, $filter, 
                    array(
                        $dn_attribute,
                        $givenName_attribute, // It may be different. Please check your variables ldap config!
                        $sn_attribute, 
                        $id_attribute 
                    )
                ); //If succes, datas gathered from LDAP server.
       
        $entries = ldap_get_entries($ldapconn, $search);

        if ($entries['count']==0) {
            mesaj_hata_login("User not found please contact your administrator!");
            return FALSE;
        }

        if ($proxy_user!="") {

            try {
            $dn= $entries['0'][$dn_attribute];
            $bind = @ldap_bind($ldapconn, $dn, $password);

                if (!$bind) {
                        mesaj_hata_login("Wrong username or password!");
                        return FALSE;
                }
            } 
            catch (Exception $e) {
                    mesaj_hata_login("Wrong username or password!");
                    return FALSE;
            }
        }

        if (empty($entries['0'][$id_attribute]['0'])) {
            $id=user_id_kontrol($username);
            }
        else if (strlen(trim($entries['0'][$id_attribute]['0']))==11)   {
            $id= $entries['0'][$id_attribute]['0'];
        }   
        else {
            $id= "-";
        }       

        // Set the session data
        $customdata = array('username' => $username,
                            'name_surname' => trim($entries['0'][$givenName_attribute]['0']).' '.trim($entries['0'][$sn_attribute]['0']),
                            'name' => trim($entries['0'][$givenName_attribute]['0']),
                            'surname' => trim($entries['0'][$sn_attribute]['0']),
                            'id' => trim($id),
                            'logged_in' => TRUE);

       $ci->session->set_userdata($customdata);
        return TRUE;
        }


function ldap_enter($mail,$pwd,$domain)
{
   $ci = & get_instance(); 

    $status=FALSE;
    $status=login_ldap($mail,$pwd,$domain);

    if ($status==TRUE) {
        $ldap=new stdclass;
        $ldap->personel_id = $ci->session->userdata('id');
        $ldap->personel_firstName = $ci->session->userdata('name');
        $ldap->personel_lastName = strtoupper($ci->session->userdata('surname'));
        $ldap->personel_email = $ci->session->userdata('username');
        load_user_info($ldap->personel_email,$ldap);
        return TRUE;
    }
    else return FALSE;
}


function load_user_info($personel_email,$ldap)
{
    $ci = & get_instance(); 
    $ci->load->model('Login_Model');

    $data=$ci->Login_Model->get_user_info($personel_email);

    if (!empty($data)) {
            if (empty($data->fk_department_id) or $data->fk_department_id==="") {
                $data->fk_department_id=10;// Undefined department
            }
       $ci->session->set_userdata('user_data',$data);// Set session variables.
       $department_id=$ci->Login_Model->get_department_id($data->fk_department_id);
    }
    else {  
       $ci->Login_Model->add_user($ldap->personel_id,$ldap->personel_firstName,$ldap->personel_lastName,$ldap->personel_email);                
        $data=$ci->Login_Model->get_user_info($personel_email);
        $data->fk_personel_department=10; // Undefined department
        $ci->session->set_userdata('user_data',$data);// Set session variables.
        $department_id=$data->fk_department_id;
    }
    return TRUE;
}
