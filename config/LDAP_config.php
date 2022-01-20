<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


$config['hosts'] = array(
							'ABC.com.tr' =>array(
										    'DC-ABC-01',
										    'DC-ACB-02',
										    'DC-ABC-03') , 
							'DEF.com.tr' =>array(
											'10.111.1.111', // Get ip permission for application ip!
											'10.111.1.112',
											'10.111.1.113',
											'10.111.1.114',
											'10.111.1.115',
											'10.111.1.116',
											'10.111.1.117') , 
							'GHI.com.tr' =>array(
											 '10.222.1.22') , 
							'JKL.com.tr' =>array(
										     '10.333.1.33') ,	
							'MNO.com.tr' =>array(
										    '10.444.1.444') 	

);

$config['ports'] = array(
							'ABC.com.tr' =>array(333),  // Get port permission for application ip!
							'DEF.com.tr' =>array(333), 
							'GHI.com.tr' =>array(333), 
							'JKL.com.tr' =>array(333),
							'MNO.com.tr' =>array(333)	
);

$config['basedn'] = array(
							'ABC.com.tr' =>'DC=ABC,DC=com,DC=tr' , 
							'DEF.com.tr' =>'DC=DEF,DC=com,DC=tr' , 
							'GHI.com.tr,' =>'DC=GHI,DC=com,DC=tr' , 
							'JKL.com.tr' =>'DC=JKL,DC=intranet',
							'MNO.com.tr' =>'DC=MNO,DC=MNO'

);

$config['login_attribute'] = array(
							'ABC.com.tr' =>'mail' , 
							'DEF.com.tr' =>'mail' , 
							'GHI.com.tr,' =>'mail' , 
							'JKL.com.tr' =>'mail'	,
							'MNO.com.tr' =>'mail'	
);
$config['proxy_user'] = array(
							'ABC.com.tr' =>'' , 
							'DEF.com.tr' =>'' , 
							'GHI.com.tr,' =>'' , 
							'JKL.com.tr' =>'',
							'MNO.com.tr' =>'abcd'	
);

$config['proxy_pass'] = array(
							'ABC.com.tr' =>'12345*',  
							'DEF.com.tr' =>'65789', 
							'GHI.com.tr,' =>'12345', 
							'JKL.com.tr' =>'98765',
							'MNO.com.tr' =>'453455'	
);

$config['tckn_attribute'] = array(
							'ABC.com.tr' =>'extensionattribute1' ,  // It may be different. Please check variables with ADExplorer.
							'DEF.com.tr' =>'extensionattribute2' , 
							'GHI.com.tr,' =>'extensionattribute1' , 
							'JKL.com.tr' =>'extensionattribute1',
							'MNO.com.tr' =>'employeeid'	
);

$config['dn_attribute'] = array(
							'ABC.com.tr' =>'distinguishedName' ,  // It may be different. Please check variables with ADExplorer.
							'DEF.com.tr' =>'distinguishedName' , 
							'GHI.com.tr,' =>'distinguishedName' , 
							'JKL.com.tr' =>'distinguishedName'	,
							'MNO.com.tr' =>'dn'	
);


$config['mail_attribute'] = array(
							'ABC.com.tr' =>'mail' ,  // It may be different. Please check variables with ADExplorer.
							'DEF.com.tr' =>'mail' , 
							'GHI.com.tr,' =>'userPrincipalName' , 
							'JKL.com.tr' =>'mail'	,
							'MNO.com.tr' =>'mail'	
);

$config['givenName_attribute'] = array(
							'ABC.com.tr' =>'givenname' ,  // It may be different. Please check variables with ADExplorer.
							'DEF.com.tr' =>'givenname' , 
							'GHI.com.tr,' =>'givenname' , 
							'JKL.com.tr' =>'givenname'	,
							'MNO.com.tr' =>'givenname'	
);

$config['sn_attribute'] = array(
							'ABC.com.tr' =>'sn' , // It may be different. Please check variables with ADExplorer.
							'DEF.com.tr' =>'sn' , 
							'GHI.com.tr,' =>'sn' , 
							'JKL.com.tr' =>'sn'	,
							'MNO.com.tr' =>'sn'	
);





?>

