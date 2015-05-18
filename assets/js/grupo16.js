$("#queryarea").keypress(function(e){
    if ((e.metaKey && e.which == 13) || (e.ctrlKey && e.which == 13)) {
        $('button[type = submit]').click();
    };
});

$(document).ready(function(){
    $('.form').submit(function(e){
        e.preventDefault();

        var $this = $(this);
        switch ($this.data("query")) {
            case "query2":
                var id_city = $("#id_city").val();
                $.ajax({
                    url: $this.attr('action'),
                    type: $this.attr('method'),
                    data: $this.serialize(),
                    dataType: 'json',
                    success: function(json) {
                        $("#query2").html(json.response);
                    }
                });
                break;

            case "query3":
                var username = $("#username").val();
                $.ajax({
                    url: $this.attr('action'),
                    type: $this.attr('method'),
                    data: $this.serialize(),
                    dataType: 'json',
                    success: function(json) {
                        $("#query3").html(json.response);
                    }
                });
                break;
        }
    });
});