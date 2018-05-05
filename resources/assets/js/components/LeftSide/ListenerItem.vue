<template>
    <div class="item mb-3">
        <i class="fab fa-telegram-plane hover float-right" data-toggle="modal" data-target="#mini-chat"></i>
        <h6 class="text-center mb-0">
            <i class="fas fa-circle text-success" v-if="item.online"></i>
            <i class="fas fa-circle text-danger" data-toggle="tooltip" data-placement="top" :title="'Последний раз онлайн ' + getLastOnline()" v-if="!item.online"></i>
            <a href="#">{{ item.name }}</a>
        </h6>
    </div>
</template>

<script>
    export default {
        name: "listener-item",
        props: [
            'item',
        ],
        methods: {
            getLastOnline() {
                const date = new Date(this.item.last_online);

                return date.getDate() + '/' + date.getMonth() + '/' + date.getFullYear() % 100 + ' ' + date.getHours() + ':' + date.getSeconds();
            },
        },
        mounted() {
            window.initTooltips();
        },
    }
</script>

<style scoped>
    .item {
        background-color: #192533;
        padding: 15px;
    }

    a {
        color: #fff;
    }

    a:hover {
        color: #fff;
    }
</style>