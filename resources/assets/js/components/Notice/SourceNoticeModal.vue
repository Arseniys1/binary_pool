<template>
    <div class="modal" tabindex="-1" role="dialog" :id="id">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-dark">
                <div class="modal-header">
                    <h5 class="modal-title" v-if="title">{{ title }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <message-item text="Привет! Сегодня торгуем с 18:00 по МСК." created_at="21 Сентября в 14:04"/>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import MessageItem from '../Chat/MessageItem';

    export default {
        name: "source-notice-modal",
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