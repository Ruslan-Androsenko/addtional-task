"use strict";

$(function (){
    $("#form_generate").submit(function (e){
        e.preventDefault();

        $.ajax({
            method: "post",
            url: "/generate.php",
            dataType: "json",
            data: $(this).serialize()
        }).done(function (response) {
            if (response.success) {
                var message = "<b>Mac-адрес сгенерирован:</b> " + response.macAddress;
                var responseMessage = $(".response-message");

                responseMessage.html(message);
                responseMessage.fadeIn(600);
            }
        });
    });
});