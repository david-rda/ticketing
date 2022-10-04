<template>
    <div>
        <router-view></router-view>
    </div>
</template>

<script>
    export default {
        
    }
</script>

<style lang="scss">
    @import "assets/css/variables.scss";

    html, body {
        margin: 0;
        padding: 0;
        background-color: $bgColor;
        color: $fgColor;
    }

    * {
        box-sizing: border-box !important;
    }
</style>