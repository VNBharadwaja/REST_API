$(document).ready(function() {
    $(function() {
        $('form').submit(function(e) {
            e.preventDefault();
            var serialized = $('form').serializeArray();
            var data = {};

            serialized.forEach(function(element){
                data[element.name] = element.value;
            });

            $.ajax({
                url: "studio/create.php",
                type: "POST",
                data: JSON.stringify(data),
                dataType: "json",
                contentType: "application/json; charset=utf-8",
                error: function (jqXHR, textStatus, errorThrown){
                    console.log(errorThrown);
                    alert("An error occured. Please fill all the fields and try again");
                },
                success: function(e) {
                    alert("Date has been added succesffully!");
                }
            });
        });
    });
});
