$show_api_token = $('#show_api_token');
$api_token = $('#api_token');
$start = $('#start');
$stop = $('#stop');

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

const ext_id = 'lmldlkajhaffjhmnmpamkennmajkjjje';

//

chrome.runtime.sendMessage(ext_id, {action: "extInstalled"}, function(response) {
    if (!response) {
        window.location = '/ext_not_installed';
    }
});

function toggleButtons(run) {
    if (run) {
        $stop.show();
        $start.hide();
    } else {
        $start.show();
        $stop.hide();
    }
}

chrome.runtime.sendMessage(ext_id, {action: "getConfig"}, function(response) {
    toggleButtons(response.run);
});

chrome.runtime.sendMessage(ext_id, {action: "setData", user: JSON.parse(user), api_token: $api_token.val()});

$('#start, #stop').click(() => {
    chrome.runtime.sendMessage(ext_id, {action: "run"}, function (response) {
        toggleButtons(response.run);
    });
});