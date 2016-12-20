/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {

    $("#capaLoad").hide();

    $("#dialogo").dialog(
            {
                autoOpen: false,
                height: 350,
                width: 350,
                show: {
                    effect: "blind",
                    duration: 1000
                },
                hide: {
                    effect: "explode",
                    duration: 1000
                }
            });

    $("#accordion").accordion();

    $("#fileuploader").uploadFile({
        url: "avatars/",
        method: 'POST',
        allowedTypes: "jpg, png, gif, bmp",
        fileName: 'uploadFiles',
//        dynamicFormData: function () {
//            var data = {
//                tipo: $("#hddTipo").val(),
//                evento: "cargarArchivo"
//            };
//            return data;
//        },
        returnType: "json",
        onSubmit: function () {
            $("#capaLoad").show();
        },
        onSuccess: function (files, data, xhr) {
            $("#capaLoad").hide();

            $("#dialogo").html(data.message);

            $("#dialogo").dialog("open");
        },
        onError: function (files, status, errMsg, pd) {
            $("#capaLoad").hide();
            $("#dialogo").html(errMsg);

            $("#dialogo").dialog("open");
        }
    });
});
