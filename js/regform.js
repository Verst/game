$(document).ready(function(){
    $('#nik').change(function() {
        var nik = $("#nik").val();
        $.ajax({
            type: "POST",
            url: "reg/ajax_chek",
            cache: false,
            data: "nik="+nik,
            success: function(html){
                $("#loginchek").text(html);
            }
        });
    });
});

