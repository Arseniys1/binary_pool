const $addAccessPreset = $('#addAccessPreset');
const $addAccessPresetLabel = $('#addAccessPresetLabel');

function add_access(event) {
    if (event !== undefined) {
        event.preventDefault();
    }

    $('#add-access-preset').attr('action', add_url);
    $addAccessPresetLabel.text('Добавить доступ');

    $addAccessPreset.modal('show');
}

function edit_access(event, id) {
    if (event !== undefined) {
        event.preventDefault();
    }

    $('#edit_access_id').val(id);
    $('#add-access-preset').attr('action', edit_url);
    $addAccessPresetLabel.text('Редактировать доступ');

    $addAccessPreset.modal('show');
}

function delete_access(event, id) {
    event.preventDefault();

    $.post(delete_url, {
        _token: $('meta[name="csrf-token"]').attr('content'),
        delete_id: id,
    }).done(() => {
        location.reload();
    });
}