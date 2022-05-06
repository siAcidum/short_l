<html lang="ru">
<head>
    <title>Shorten the link today!</title>
    <link rel="stylesheet" href="/styleform.css">
</head>
</html>
<div id="feedback-form">
    <h2 class="header">Shorten the link today!</h2>
    <div>
        <form action="/ajax/link.php" id="link-form">
            <input pattern="^(https:\/\/)([\w-]{1,32}\.[\w-]{1,32})[^\s@]*$" required type="text" name="link"
                   placeholder="https://example.com">
            <button type="submit">Generate link</button>
        </form>
    </div>
</div>

<script src="/jquery-3.6.0.min.js"></script>
<script>
    $("#link-form").submit(function (e) {
        e.preventDefault(); // avoid to execute the actual submit of the form.
        var form = $(this);
        var actionUrl = form.attr('action');
        $.ajax({
            type: "POST",
            url: actionUrl,
            data: form.serialize(), // serializes the form's elements.
            success: function (data) {
                let result = $.parseJSON(data);
                if (result.status === 'success') {
                    $("#link-form").append('<div class="one"><a target="_blank" href="' + result.short_link + '">' + result.short_link + '</a></div>')
                }
            }
        });

    });
</script>
<?php
