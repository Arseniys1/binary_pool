function copy_link(event, id) {
    event.preventDefault();
    $('#clipboard').remove();

    const href = $('#link-' + id + ' > .card-body > a').attr('href');

    $('<input>', {type: 'text', value: href, id: 'clipboard'}).appendTo('body');

    let $clipboard = $('#clipboard');

    $clipboard.css({
        position: 'absolute',
        left: -9999,
        top: 0,
    });

    $clipboard.select();

    document.execCommand('copy');
}

function delete_link(event, id) {
    event.preventDefault();

    $.post(delete_url, {
        _token: $('meta[name="csrf-token"]').attr('content'),
        link_id: id,
    }).done(() => {
        location.reload();
    });
}