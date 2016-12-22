/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var objAvatar = {};
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
        showAbort: false,
        maxFileSize: 1000000,
        onSubmit: function () {
            $("#capaLoad").show();
        },
        onCancel: function (files, pd) {
            $("#capaLoad").hide();
            $("#dialogo").html(files + ' ' + pd);
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

    $("#selectAvatar").click(function () {
        $("#div_gridAvatar").empty();
        $("#div_imgUsr").empty();
        $("#inpt_idAvatar").val('');
        $("#inpt_email").val('');
        $.ajax({
            type: "GET",
            datatype: "json",
            url: "avatars/1",
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
                objAvatar = data;
                $.each(data, function (index, value) {
                    var myImage = $('<img/>');
                    myImage.attr({
                        title: 'Name:' + value.name + ', Size File:' + value.sizefile + ', MimeType:' + value.mimetype,
                        onclick: 'selectAvatar( ' + index + ' );',
                        height: value.size,
                        width: value.size,
                        class: 'img-thumbnail'
                    });
                    myImage.prop('src', 'data:' + value.mimetype + ';base64,' + value.thumb);
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

    $("#btn_search").click(function () {
        if (validateEmail($("#inpt_email").val()) == false || $("#inpt_email").val() == '') {
            $("#dialogo").html('Email invalid');
            $("#dialogo").dialog("open");
            return false;
        }
        $.ajax({
            type: "GET",
            datatype: "json",
            url: "avatars/2",
            data: {
                idAvatar: $("#inpt_idAvatar").val(),
                email: $.md5($("#inpt_email").val())
            },
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
                selectAvatar(data.img);
                $("#dialogo").html(data.message);
                $("#dialogo").dialog("open");

            }
        });
    });

    $("#btn_save").click(function () {

        if (validateEmail($("#inpt_email").val()) == false || $("#inpt_email").val() == '') {
            $("#dialogo").html('Email invalid');
            $("#dialogo").dialog("open");
            return false;
        }
        $.ajax({
            type: "GET",
            datatype: "json",
            url: "avatars/3",
            data: {
                idAvatar: $("#inpt_idAvatar").val(),
                email: $.md5($("#inpt_email").val())
            },
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
                selectAvatar(data.img);
                $("#dialogo").html(data.message);
                $("#dialogo").dialog("open");

            }
        });
    });


});

function selectAvatar(id) {
    var avatar = objAvatar[id];
    var imgUsr = $('<img/>');
    imgUsr.prop('src', 'data:' + avatar.mimetype + ';base64,' + avatar.image);

    imgUsr.attr({
        title: 'Name:' + avatar.name + ', Size File:' + avatar.sizefile + ', MimeType:' + avatar.mimetype,
        class: 'img-fluid'
    });

    imgUsr.css({
        'cursor': 'pointer',
        'border-style': 'solid',
        'border-width': '3px',
        'border-color': '#2E9AFE'
    });
    $("#div_imgUsr").html(imgUsr);
    $("#inpt_idAvatar").val(id);
}

function validateEmail(email) {
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return emailReg.test(email);
}