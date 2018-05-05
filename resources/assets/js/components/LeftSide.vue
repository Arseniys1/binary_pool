<template>
    <div class="left-side text-white scrollbar-custom" id="left-side">
        <ul class="list-unstyled left-side-list">
            <li class="d-md-none" v-if="!showToggleBtn">
                <button class="btn btn-list d-block w-100" @click="leftSideToggle">
                    <i class="far fa-caret-square-right"></i>
                </button>
            </li>
            <li v-if="showToggleBtn">
                <button class="btn btn-list d-block w-100" @click="leftSideToggle">
                    <i class="far fa-caret-square-left"></i>
                    Скрыть
                </button>
            </li>
            <li class="d-none d-md-block">
                <button class="btn btn-list" @click="sourcesShow">
                    Источники
                    <i class="fas fa-bullhorn"></i>
                </button>
                <button class="btn btn-list" @click="listenersShow">
                    Слушатели
                    <i class="fas fa-headphones"></i>
                </button>
            </li>
            <li class="d-md-none">
                <button class="btn btn-list d-block w-100 mb-3" @click="sourcesShow">
                    <i class="fas fa-bullhorn"></i>
                </button>
                <button class="btn btn-list d-block w-100" @click="listenersShow">
                    <i class="fas fa-headphones"></i>
                </button>
            </li>
            <li class="d-none d-md-block" id="sources-listeners-lists">
                <div class="mb-4">
                    <ul class="list-inline">
                        <li class="list-inline-item mb-1">Источники online {{ this.sourceOnlineCount + '/' + this.sourceItems.length }}</li>
                        <li class="list-inline-item mb-1">Слушатели online {{ this.listenerOnlineCount + '/' + this.listenerItems.length }}</li>
                    </ul>
                </div>

                <div class="sources-list" v-if="showSourceOrListeners">
                    <h5>Источники</h5>

                    <div class="search mb-4">
                        <input type="text" class="form-control" placeholder="Поиск по листу">
                    </div>

                    <div class="items">
                        <source-item :item="item" :key="key" v-for="(item, key) in sourceItems"/>
                    </div>
                </div>
                <div class="listeners-list" v-if="!showSourceOrListeners">
                    <h5>Слушатели</h5>

                    <div class="search mb-4">
                        <input type="text" class="form-control" placeholder="Поиск по листу">
                    </div>

                    <div class="items">
                        <listener-item :item="item" :key="key" v-for="(item, key) in listenerItems"/>
                    </div>
                </div>
            </li>
        </ul>

        <source-notice-modal title="Уведомления от источника Arseniys1" id="source-notice"/>
        <chat-min-modal title="Чат с пользователем Arseniys1" id="mini-chat"/>
    </div>
</template>

<script>
    import SourceItem from './LeftSide/SourceItem';
    import ListenerItem from './LeftSide/ListenerItem';
    import SourceNoticeModal from './Notice/SourceNoticeModal';
    import ChatMinModal from './Chat/ChatMinModal';

    export default {
        name: "left-side",
        components: {
            SourceItem,
            ListenerItem,
            SourceNoticeModal,
            ChatMinModal,
        },
        data() {
            return {
                showToggleBtn: false,
                showSourceOrListeners: true,
                sourceItems: [],
                listenerItems: [],
                sourceOnlineCount: 0,
                listenerOnlineCount: 0,
            };
        },
        methods: {
            leftSideToggle() {
                window.app.leftSideToggle();
            },
            sourcesShow() {
                this.showSourceOrListeners = true;
            },
            listenersShow() {
                this.showSourceOrListeners = false;
            },
            onlineCounters() {
                this.sourceOnlineCount = this.listenerOnlineCount = 0;

                for (const key in this.sourceItems) {
                    let item = this.sourceItems[key];

                    if (item.online) this.sourceOnlineCount += 1;
                }

                for (const key in this.listenerItems) {
                    let item = this.listenerItems[key];

                    if (item.online) this.listenerOnlineCount += 1;
                }
            },
        },
        created() {
            window.leftSide = this;

            this.sourceItems = window.data.sources;
            this.listenerItems = window.data.listeners;

            this.onlineCounters();
        },
    }
</script>

<style scoped>

</style>