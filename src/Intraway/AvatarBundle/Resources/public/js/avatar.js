/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    $("#accordion").accordion();

    $("#fileuploader").uploadFile({
        url: "Excel/uploadfileTipCal.php",
        method: 'POST',
        allowedTypes: "xlsx",
        fileName: $("#filename").val(),
        dynamicFormData: function () {
            var data = {
                tipo: $("#hddTipo").val(),
                evento: "cargarArchivo"
            };
            return data;
        },
        returnType: "json",
        onSubmit: function () {
            $(".estiloGifLoad").show();
        },
        onSuccess: function (files, data, xhr) {
            $(".estiloGifLoad").hide();
            if (data.error != '') {
                $("#dialogo").html(data.error);
            } else {
                $("#dialogo").html(data.correcto);
            }
            $("#dialogo").dialog("open");
        },
        onError: function () {
            $(".estiloGifLoad").hide();
        }
    });
});
