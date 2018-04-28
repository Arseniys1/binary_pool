<template>
    <div class="item bg-dark p-4">
        <div class="title">
            <a href="#" class="avatar-link">
                <div class="avatar-inline"></div>
            </a>
            <div class="name">
                <h4>
                    <a href="#" class="text-white">Arseniys1</a>
                </h4>
            </div>
            <div class="right">
                <i class="fab hover fa-telegram-plane" data-toggle="modal" data-target="#mini-chat"></i>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6">
                <div class="bg-dark3 p-3 mb-1">
                    <div class="mb-2">
                        <h5 class="float-left mb-0 mr-1">Статистика</h5>
                        <a href="#" class="small" @click.prevent="toggleStat" v-if="realStat">Реальный счет</a>
                        <a href="#" class="small" @click.prevent="toggleStat" v-if="!realStat">Демо счет</a>
                    </div>
                    <ul class="list-unstyled mb-0">
                        <li>Успешные сделки: <span class="text-success">100</span></li>
                        <li>Проигрышные сделки: <span class="text-danger">10</span></li>
                        <li>Возвраты: <span>10</span></li>
                        <li>Продажи: <span>10</span></li>
                        <li>Заработал: <span class="text-success">1000</span> рублей</li>
                        <li>Проиграл: <span class="text-danger">100</span> рублей</li>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="bg-dark3 p-3 mb-1">
                    <h5>Подписка</h5>
                    <ul class="list-unstyled">
                        <li>Количество подписчиков: 100
                            <a href="#" class="small">Посмотреть</a>
                        </li>
                        <li>Стоимость подписки: <strong>1000</strong> рублей
                            <a href="#" class="small">Демо доступ</a>
                        </li>
                    </ul>

                    <button class="btn bg-success text-white">Купить подписку</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "item",
        data() {
            return {
                realStat: true,
            };
        },
        methods: {
            toggleStat() {
                this.realStat = !this.realStat;
            },
        },
    }
</script>

<style scoped>
    .item {

    }

    .title {
        height: 40px;
        margin-bottom: 15px;
    }

    .title .avatar-link {
        display: inline-block;
        line-height: 0;
        float: left;
    }

    .title .name {
        display: block;
        margin-left: 45px;
        padding-top: 10px;
    }

    .title .name h4 {
        margin: 0;
    }

    .right {
        position: absolute;
        right: 40px;
        top: 20px;
        font-size: 1.35rem;
        padding-top: 10px;
    }

    a.small {
        font-size: 12px;
    }
</style>