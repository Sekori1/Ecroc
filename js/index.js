$(document).ready(function(){

    $("#login-link").click(function(){
        $("#register").addClass("mask");
        $("#login").removeClass("mask");
    });

    $("#register-link").click(function(){
        $("#login").addClass("mask");
        $("#register").removeClass("mask");
    });

});