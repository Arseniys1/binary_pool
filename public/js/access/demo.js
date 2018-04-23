function open_modal(event, id) {
    event.preventDefault();

    $('#preset_id').val(id);

    $('#sendRequest').modal('show');
}