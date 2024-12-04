$("#delete-article").on("click", function (e){
    e.preventDefault();

    if(confirm('Are you sure?')){

        var frm = $("<form>");
        frm.attr('method', 'post');
        frm.attr('action', $(this).attr('href'));
        frm.appendTo("body");
        frm.submit();

    }
});

$.validator.addMethod("dateTime", function (value, element) {
    return (value == "") || !isNaN(Date.parse(value)) ;
}, "Must be a valid date and time");

$("#formArticle").validate({
    rules: {
        title: {
            required: true
        },
        content: {
            required: true
        },
        published_at: {
            dateTime: true
        },
    },
    messages: {
        title: "وارد کن",
    }
});

$("button.publish-btn").on('click', function (e){
    var id = $(this).data('id');
    var button = $(this)
    $.ajax({
        url: '/admin/publish-article.php',
        type: 'POST',
        data: {id: id}
    })
        .done(function (data){
            button.parent().html(data);
        })
        .fail(function (data){
            alert('an error occurred');
        });
});

$('#published_at').datetimepicker({
    format: "Y-m-d\\TH:i:s"
});

$("#formContact").validate({
    rules: {
        email: {
            required: true,
            email: true
        },
        subject: {
            required: true
        },
        message: {
            required: true
        }
    }
})