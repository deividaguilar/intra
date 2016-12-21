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

    var icons = {
        header: "ui-icon-circle-arrow-e",
        activeHeader: "ui-icon-circle-arrow-s"
    };
    $("#accordion").accordion({
        icons: icons,
        heightStyle: "content"
    });
    $("#toggle").button().on("click", function () {
        if ($("#accordion").accordion("option", "icons")) {
            $("#accordion").accordion("option", "icons", null);
        } else {
            $("#accordion").accordion("option", "icons", icons);
        }
    });


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
        showDone: true,
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
        },
        onCancel: function (files, pd) {
            $("#capaLoad").hide();
            $("#dialogo").html(files + ' ' + pd);
        }
    });

    $("#selectAvatar").click(function () {
        $.ajax({
            type: "GET",
            datatype: "json",
            url: "avatars/1",
            data: {tipo: $("#tipo").val()},
            beforeSend: function () {
                $("#capaLoad").show();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                $("#capaLoad").hide();
                $("#dialogo").html(textStatus + ' ' + errorThrown);
                $("#dialogo").dialog("open");
            },
            success: function (data, textStatus, jqXHR)
            {
                $("#capaLoad").hide();
                $("#div_gridAvatar").empty();
                $.each(data, function (index, value) {
                    var myImage = $('<img/>');
                    myImage.attr({
//                        title: 'Expediente:' + value.expediente + ', Archivo:' + value.archivo + ', Folio:' + value.folio + ', folder:' + value.folder,
//                        onclick: 'renderImg(\'' + value.db + '\',\'' + value.archivo + '\',\'' + value.expediente + '\',\'' + value.folio + '\',\'' + value.folder + '\');'
                        height: value.size,
                        width: value.size
                    });
                    myImage.prop('src', 'data:' + value.mimetype + ';base64,' + value.image);
                    myImage.css({
                        'cursor': 'pointer',
                        'border-style': 'solid',
                        'border-width': '3px',
                        'border-color': '#2E9AFE'
                    });
                    $("#div_gridAvatar").append(myImage);
                });

            }
        });
    });
});
