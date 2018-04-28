<template>
    <div class="message mb-3">
        <p class="mb-0">{{ text }}</p>
        <span class="time">{{ created_at }}</span>
    </div>
</template>

<script>
    export default {
        name: "message-item",
        props: [
            'text',
            'created_at',
        ],
    }
</script>

<style scoped>
    .message {
        border-bottom: 1px solid #6c757d;
    }

    .time {
        font-size: 12px;
        color: #828c94;
    }
</style>