<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark" id="navbar">
        <a class="navbar-brand" href="#">
            <img src="/binary-pool-no-fon.png" alt="Binary Pool">
            Binary Pool</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">Источники оповещений</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">О сервисе</a>
                </li>
            </ul>

            <ul class="navbar-nav">
                <li class="nav-item">
                    <div class="dropdown">
                        <a href="#" class="nav-link dropdown-toggle" id="profileDropdown" data-toggle="dropdown">
                            <div class="avatar d-none d-lg-block"></div>
                            Arseniys1
                        </a>
                        <div class="dropdown-menu dropdown-menu-dark dd-fix" aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="#">Профиль</a>
                            <a class="dropdown-item" href="#">Баланс: 100 <i class="fas fa-ruble-sign"></i></a>
                            <a class="dropdown-item" href="#">Выход</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
    export default {
        name: "navbar"
    }
</script>

<style scoped>

</style>