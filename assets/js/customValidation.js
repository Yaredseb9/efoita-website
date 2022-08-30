// JavaScript Document
"use strict";
function validateName(obj, obj_er) {
	// regular expression to match only alphanumeric characters and spaces
	var re = /^[A-Za-z]{2,}$/;

	obj = document.getElementById(obj);
	obj_er = document.getElementById(obj_er);

	// validation fails if the input doesn't match our regular expression
	if (!re.test(obj.value)) {
		obj.setAttribute('style', 'border-bottom-color: red; border-right-color: red; border-top-color: red;');
		obj_er.setAttribute('style', 'display: block');
		obj.focus();
		return false;
	} else {
		obj.setAttribute('style', 'border-bottom-color: green; red; border-right-color: green; border-top-color: green;');
		obj_er.setAttribute('style', 'display: none');
		return true;
	}
}

function isItSetSelect(obj, obj_er) {

	obj = document.getElementById(obj);
	obj_er = document.getElementById(obj_er);

	if (obj.selectedIndex === 0) {
		obj_er.setAttribute('style', 'display: block');
		//obj.setAttribute('style', 'border-bottom-color: red; border-right-color: red; border-top-color: red;');
		//obj.focus();
		return false;
	}
	obj_er.setAttribute('style', 'display: none');
	return true;
}

function isItSetGender(obj1, obj2, obj_er) {
	//alert(obj1.checked);
	obj1 = document.getElementById(obj1);
	obj2 = document.getElementById(obj2);
	obj_er = document.getElementById(obj_er);
	//alert(obj1.value);
	//obj.value == "me"
	//alert(obj2.value);
	if (obj1.checked) {
		obj_er.setAttribute('style', 'display: none');
		return true;
	}
	if (obj2.checked){
		obj_er.setAttribute('style', 'display: none');
		return true;
	}
	
	obj_er.setAttribute('style', 'display: block');
	return false;
	
}

function validateEmpID(obj, obj_er, obj_exist) {
	// regular expression to match only alphanumeric characters and spaces
	var re = /^\d{6}$/;
	var allEmpID = document.getElementById('allEmpID').value.split(';');

	obj = document.getElementById(obj);
	var obj_value = obj.value.toString();
	obj_er = document.getElementById(obj_er);
	obj_exist = document.getElementById(obj_exist);

	var i;
	var isfound = false;
	
	for (i = 0; i < allEmpID.length; i++){
		if(allEmpID[i] == obj_value){
			isfound = true;
		}
	}
	
	// validation fails if the input doesn't match our regular expression
	if (!re.test(obj.value)) {
		obj.setAttribute('style', 'border-bottom-color: red; border-right-color: red; border-top-color: red;');
		obj_exist.setAttribute('style', 'display: none');
		obj_er.setAttribute('style', 'display: block');
		obj.focus();
		return false;
	}else if(isfound) {
		
		obj.setAttribute('style', 'border-bottom-color: red; border-right-color: red; border-top-color: red;');
		obj_er.setAttribute('style', 'display: none');
		obj_exist.setAttribute('style', 'display: block');
		obj.focus();
		return false;
	}
	else {
		obj.setAttribute('style', 'border-bottom-color: green; red; border-right-color: green; border-top-color: green;');
		obj_er.setAttribute('style', 'display: none');
		obj_exist.setAttribute('style', 'display: none');
		return true;
	}
}

function validateAccount(obj, obj_er, obj_exist) {
	// regular expression to match only alphanumeric characters and spaces
	var accouts = document.getElementById('allAccounts').value.split(';');
	var re = /^\w{13}$/;

	obj = document.getElementById(obj);
	var obj_value = obj.value.toString();
	obj_er = document.getElementById(obj_er);
	obj_exist = document.getElementById(obj_exist);

	var i;
	var isfound = false;
	
	for (i = 0; i < accouts.length; i++){
		if(accouts[i] == obj_value){
			isfound = true;
		}
	}
	
	if (!re.test(obj.value)) {
		obj.setAttribute('style', 'border-bottom-color: red; border-right-color: red; border-top-color: red;');
		obj_er.setAttribute('style', 'display: block');
		obj_exist.setAttribute('style', 'display: none');
		obj.focus();
		return false;
	}else if(isfound) {
		
		obj.setAttribute('style', 'border-bottom-color: red; border-right-color: red; border-top-color: red;');
		obj_er.setAttribute('style', 'display: none');
		obj_exist.setAttribute('style', 'display: block');
		obj.focus();
		return false;
	} else {
		obj.setAttribute('style', 'border-bottom-color: green; red; border-right-color: green; border-top-color: green;');
		obj_er.setAttribute('style', 'display: none');
		obj_exist.setAttribute('style', 'display: none');
		return true;
	}
}

function validateAny(obj, obj_er) {
	// regular expression to match only alphanumeric characters and spaces
	var re = /^((\w)|([\/\\-])){2,}$/; // ((\w)|([\/\\-])){2,}

	obj = document.getElementById(obj);
	obj_er = document.getElementById(obj_er);

	// validation fails if the input doesn't match our regular expression
	if (!re.test(obj.value)) {
		obj.setAttribute('style', 'border-bottom-color: red; border-right-color: red; border-top-color: red;');
		obj_er.setAttribute('style', 'display: block');
		obj.focus();
		return false;
	} else {
		obj.setAttribute('style', 'border-bottom-color: green; red; border-right-color: green; border-top-color: green;');
		obj_er.setAttribute('style', 'display: none');
		return true;
	}
}

function validatePassword(obj, obj_er) {
	// regular expression to match only alphanumeric characters and spaces
	var re = new RegExp("^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#\$%\^&\*])(?=.{6,})");

	obj = document.getElementById(obj);
	obj_er = document.getElementById(obj_er);

	// validation fails if the input doesn't match our regular expression
	if (!re.test(obj.value)) {
		obj.setAttribute('style', 'border-bottom-color: #EDBF1D; border-right-color: #EDBF1D; border-top-color: #EDBF1D;');
		obj_er.setAttribute('style', 'display: block');
		obj.focus();
		return false;
	} else {
		obj.setAttribute('style', 'border-bottom-color: green; border-right-color: green; border-top-color: green;');
		obj_er.setAttribute('style', 'display: none');
		return true;
	}
}

function validatePasswordConfirm(obj1, obj2, obj_er){

	
	obj1 = document.getElementById(obj1);
	obj2 = document.getElementById(obj2);
	obj_er = document.getElementById(obj_er);
	
	if(obj1.value === obj2.value ){
		obj1.setAttribute('style', 'border-bottom-color: green; border-right-color: green; border-top-color: green;');
		obj2.setAttribute('style', 'border-bottom-color: green; border-right-color: green; border-top-color: green;');
		obj_er.setAttribute('style', 'display: none');
		return true;
	}else{
		obj1.setAttribute('style', 'border-bottom-color: red; border-right-color: red; border-top-color: red;');
		obj2.setAttribute('style', 'border-bottom-color: red; border-right-color: red; border-top-color: red;');
		obj_er.setAttribute('style', 'display: block');
		return false;
	}
}

function validatePhone(obj, obj_er, obj_exist) {
	// regular expression to match only alphanumeric characters and spaces
	var phones = document.getElementById('allPhones').value.split(';');
	var re = /^\d{9}$/;

	obj = document.getElementById(obj);
	var obj_value= obj.value.toString();
	obj_er = document.getElementById(obj_er);
	obj_exist = document.getElementById(obj_exist);
	
	var i;
	var isfound = false;
	
	for (i = 0; i < phones.length; i++){
		if(phones[i] == obj_value){
			isfound = true;
		}
	}
	// validation fails if the input doesn't match our regular expression
	if (!re.test(obj.value)) {
		obj.setAttribute('style', 'border-bottom-color: red; border-right-color: red; border-top-color: red;');
		obj_exist.setAttribute('style', 'display: none');
		obj_er.setAttribute('style', 'display: block');
		obj.focus();
		return false;
	} else if(isfound){
		obj.setAttribute('style', 'border-bottom-color: red; border-right-color: red; border-top-color: red;');
		obj_er.setAttribute('style', 'display: none');
		obj_exist.setAttribute('style', 'display: block');
		obj.focus();
		return false;
	}else {
		
		obj.setAttribute('style', 'border-bottom-color: green;  border-right-color: green; border-top-color: green;');
		obj_er.setAttribute('style', 'display: none');
		obj_exist.setAttribute('style', 'display: none');
		return true;
	}
}

function validateWoreda(obj, obj_er) {
	// regular expression to match only alphanumeric characters and spaces
	var re = /^\d{2}$/;

	obj = document.getElementById(obj);
	obj_er = document.getElementById(obj_er);

	// validation fails if the input doesn't match our regular expression
	if (!re.test(obj.value)) {
		obj.setAttribute('style', 'border-bottom-color: red; border-right-color: red; border-top-color: red;');
		obj_er.setAttribute('style', 'display: block');
		obj.focus();
		return false;
	} else {
		obj.setAttribute('style', 'border-bottom-color: green;  border-right-color: green; border-top-color: green;');
		obj_er.setAttribute('style', 'display: none');
		return true;
	}
}

function validateTerm(obj, obj_er) {

	obj = document.getElementById(obj);
	obj_er = document.getElementById(obj_er);

	if (obj.checked) {
		obj.setAttribute('style', 'border-bottom-color: green; red; border-right-color: green; border-top-color: green;');
		obj_er.setAttribute('style', 'display: none');
		return true;
	} else {
		obj.setAttribute('style', 'border-bottom-color: red; border-right-color: red; border-top-color: red;');
		obj_er.setAttribute('style', 'display: block');
		obj.focus();
		return false;
	}
}