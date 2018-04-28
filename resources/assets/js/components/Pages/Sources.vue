<template>
    <div class="sources">
        <h3 class="text-center mt-4 mb-4">Источники оповещений</h3>

        <div class="row">
            <div class="col-12 col-md-6 mb-3">
                <item/>
            </div>
            <div class="col-12 col-md-6 mb-3">
                <item/>
            </div>
            <div class="col-12 col-md-6 mb-3">
                <item/>
            </div>
        </div>
    </div>
</template>

<script>
    import Item from './Sources/Item'

    export default {
        name: "sources",
        components: {
            Item,
        },
    }
</script>

<style scoped>

</style>