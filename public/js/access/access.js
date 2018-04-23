function accept_request(event, id) {
    event.preventDefault();

    $.post(accept_url, {
        _token: $('meta[name="csrf-token"]').attr('content'),
        request_id: id,
    }).done(() => {
        location.reload();
    });
}

function reject_request(event, id) {
    event.preventDefault();

    $.post(reject_url, {
        _token: $('meta[name="csrf-token"]').attr('content'),
        request_id: id,
    }).done(() => {
        location.reload();
    });
}