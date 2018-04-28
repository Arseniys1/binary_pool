<template>
    <div class="item mb-3">
        <i class="fas fa-bell hover float-right" data-toggle="modal" data-target="#source-notice"></i>
        <i class="fab fa-telegram-plane hover float-right mr-2" data-toggle="modal" data-target="#mini-chat"></i>
        <h6 class="text-center">
            <i class="fas fa-circle text-success" v-if="item.online"></i>
            <i class="fas fa-circle text-danger" data-toggle="tooltip" data-placement="top" title="Last online" v-if="!item.online"></i>
            <a href="#">{{ item.name }}</a>
        </h6>
        <button class="btn text-white bg-success d-block w-100">Получать оповещения</button>
    </div>
</template>

<script>
    export default {
        name: "source-item",
        props: [
            'item',
        ],
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