$show_api_token = $('#show_api_token');
$api_token = $('#api_token');

$show_api_token.click((event) => {
    event.preventDefault();

    if ($api_token.attr('type') === 'password') {
        $api_token.attr('type', 'text');

        setTimeout(() => {
            $api_token.attr('type', 'password');
        }, 3000);
    } else if ($api_token.attr('type') === 'text') {
        $api_token.attr('type', 'password');
    }
});