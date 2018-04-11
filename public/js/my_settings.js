$save_account_mode = $('#save_account_mode');
$error_msg = $('#error_msg');
$account_mode = $('#account_mode');

const account_mode_value = $account_mode.val();

$save_account_mode.click((event) => {
    event.preventDefault();

    if (account_mode_value === $account_mode.val()) return;

    $.post('/api/changeAccountMode', {api_token: api_token}, (response) => {
        response = JSON.parse(response);

        if (response.success) {
            location.reload();
        }
    }).fail((response) => {
        if (response.status === 401) {
            $error_msg.text('Неверный api token');
            $error_msg.show();

            setTimeout(() => {
                $error_msg.hide();
            }, 3000);
            return;
        } else if (response.status === 429) {
            $error_msg.text('Изменять режим аккаунта можно менять 1 раз в 10 минут');
            $error_msg.show();

            setTimeout(() => {
                $error_msg.hide();
            }, 3000);
            return;
        }
    });
});

const ext_id = 'jlmdiecilelgoaiomgcikdafkhpaigai';

chrome.runtime.sendMessage(ext_id, {action: "setData", user: JSON.parse(user), api_token: api_token});