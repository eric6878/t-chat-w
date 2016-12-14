<?php

	//http://www.monsite.fr/users/see/1
	//http://localhost/t-chat-w/public/
	//[-------------------------------]
	//             URL
   //[-----][---------][--------------]
	
	$w_routes = array(
		['GET', '/', 'Default#home', 'default_home'],
		['GET', '/test', 'Default#test', 'test'],
		['GET|POST', '/login', 'Login#form', 'login'],
		['GET|POST', '/register', 'Users#register', 'register']
	);