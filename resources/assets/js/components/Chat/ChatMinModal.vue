<template>
    <div class="modal" tabindex="-1" role="dialog" :id="id">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title" v-if="title">{{ title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <textarea class="form-control" placeholder="Введите сообщение"></textarea>
                    <button class="btn btn-primary">Отправить</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import MessageItem from '../Chat/MessageItem';

    export default {
        name: "chat-min-modal",
        components: {
            MessageItem,
        },
        props: [
            'id',
            'title',
        ],
    }
</script>

<style scoped>

</style>